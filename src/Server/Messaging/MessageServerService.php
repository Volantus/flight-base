<?php
namespace Volantus\FlightBase\Src\Server\Messaging;

use Ratchet\ConnectionInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Volantus\FlightBase\Src\General\CLI\OutputOperations;
use Volantus\FlightBase\Src\General\Generic\IncomingGenericInternalMessage;
use Volantus\FlightBase\Src\General\Network\BaseRawMessage;
use Volantus\FlightBase\Src\General\Role\ClientRole;
use Volantus\FlightBase\Src\Server\Authentication\AuthenticationMessage;
use Volantus\FlightBase\Src\Server\Authentication\UnauthorizedException;
use Volantus\FlightBase\Src\Server\Network\Client;
use Volantus\FlightBase\Src\Server\Network\ClientFactory;
use Volantus\FlightBase\Src\Server\Role\IntroductionMessage;

/**
 * Class MessageServerService
 * @package Volante\SkyBukkit\Monitor\Src\FlightStatus\Network
 */
class MessageServerService
{
    use OutputOperations;

    /**
     * @var MessageService
     */
    protected $messageService;

    /**
     * @var ClientFactory
     */
    protected $clientFactory;

    /**
     * @var Client[]
     */
    protected $clients = [];

    /**
     * MessageServerService constructor.
     * @param OutputInterface $output
     * @param MessageService $messageService
     * @param ClientFactory $clientFactory
     */
    public function __construct(OutputInterface $output, MessageService $messageService = null, ClientFactory $clientFactory = null)
    {
        $this->output = $output;
        $this->messageService = $messageService ?: new MessageService();
        $this->clientFactory = $clientFactory ?: new ClientFactory();
    }

    /**
     * @param ConnectionInterface $connection
     */
    public function newClient(ConnectionInterface $connection)
    {
        $this->sandbox(function () use ($connection) {
            $this->clients[] = $client = $this->clientFactory->get($connection);
            $this->writeGreenLine('MessageServerService', 'New client ' . $client->getId() . ' connected!');
        });
    }

    /**
     * @param ConnectionInterface $connection
     */
    public function removeClient(ConnectionInterface $connection)
    {
        $this->sandbox(function () use ($connection) {
            $client = $this->findClient($connection);
            $this->disconnectClient($client);
            $this->writeRedLine('MessageServerService', 'Client ' . $client->getId() . ' disconnected!');
        });
    }

    /**
     * @param ConnectionInterface $connection
     * @param string $message
     */
    public function newMessage(ConnectionInterface $connection, string $message)
    {
        $this->sandbox(function () use ($connection, $message) {
            $client = $this->findClient($connection);
            $message = $this->messageService->handle($client, $message);
            $this->handleMessage($message);
        });
    }

    /**
     * @param IncomingMessage $message
     */
    protected function handleMessage(IncomingMessage $message)
    {
        switch (get_class($message)) {
            case IncomingGenericInternalMessage::class:
                /** @var IncomingGenericInternalMessage $message */
                $this->handleGenericMessage($message);
                break;
            case AuthenticationMessage::class:
                /** @var AuthenticationMessage $message */
                $this->handleAuthenticationMessage($message);
                break;
            case IntroductionMessage::class:
                /** @var IntroductionMessage $message */
                $this->handleIntroductionMessage($message);
                break;
        }
    }

    /**
     * @param IncomingGenericInternalMessage $message
     */
    protected function handleGenericMessage(IncomingGenericInternalMessage $message)
    {
    }

    /**
     * @param callable $function
     */
    protected function sandbox(callable $function)
    {
        try {
            call_user_func($function);
        } catch (\Exception $e) {
            $this->writeErrorLine('MessageServerService', $e->getMessage());
        } catch (\TypeError $e) {
            $this->writeErrorLine('MessageServerService', $e->getMessage());
        }
    }

    /**
     * @param AuthenticationMessage $message
     */
    protected function handleAuthenticationMessage(AuthenticationMessage $message)
    {
        if ($message->getToken() === getenv('AUTH_TOKEN')) {
            $message->getSender()->setAuthenticated();
            $this->writeGreenLine('MessageServerService', 'Client ' . $message->getSender()->getId() . ' authenticated successfully.');
        } else {
            $this->disconnectClient($message->getSender());
            throw new UnauthorizedException('Client ' . $message->getSender()->getId() . ' tried to authenticate with wrong token!');
        }
    }

    /**
     * @param IntroductionMessage $message
     */
    protected function handleIntroductionMessage(IntroductionMessage $message)
    {
        $this->authenticate($message->getSender());
        $message->getSender()->setRole($message->getRole());
        $this->writeGreenLine('MessageServerService', 'Client ' . $message->getSender()->getId() . ' introduced as ' . ClientRole::getTitle($message->getRole()) . '.');
    }

    /**
     * @param BaseRawMessage $rawMessage
     */
    protected function broadcastMessage(BaseRawMessage $rawMessage)
    {
        $data = json_encode($rawMessage);

        foreach ($this->clients as $client) {
            $client->getConnection()->send($data);
        }
    }

    /**
     * @param Sender $client
     */
    private function authenticate(Sender $client)
    {
        if (!$client->isAuthenticated()) {
            $this->disconnectClient($client);
            throw new UnauthorizedException('Client ' . $client->getId() . ' tried to perform unauthenticated action!');
        }
    }

    /**
     * @param Sender $removedClient
     */
    private function disconnectClient(Sender $removedClient)
    {
        $removedClient->disconnect();
        foreach ($this->clients as $i => $client) {
            if ($client === $removedClient) {
                unset($this->clients[$i]);
                $this->clients = array_values($this->clients);
                break;
            }
        }
    }

    /**
     * @param ConnectionInterface $connection
     * @return Client
     */
    private function findClient(ConnectionInterface $connection) : Client
    {
        foreach ($this->clients as $client) {
            if ($client->getConnection() === $connection) {
                return $client;
            }
        }

        throw new \RuntimeException('No connected client found!');
    }
}