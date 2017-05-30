<?php
namespace Volantus\FlightBase\Src\Client;

use Ratchet\Client\WebSocket;
use React\EventLoop\ExtEventLoop;
use Symfony\Component\Console\Output\OutputInterface;
use Volantus\FlightBase\Src\General\CLI\OutputOperations;
use Volantus\FlightBase\Src\General\Role\ClientRole;
use Volantus\FlightBase\Src\Server\Messaging\IncomingMessage;
use Volantus\FlightBase\Src\Server\Messaging\MessageService;

/**
 * Class ClientService
 * @package Volantus\FlightBase\Src\Client
 */
class ClientService
{
    use OutputOperations;

    /**
     * @var int
     */
    protected $clientRole = -1;

    /**
     * @var Server[]
     */
    protected $servers = [];

    /**
     * @var MessageService
     */
    protected $messageService;

    /**
     * @var ExtEventLoop
     */
    protected $loop;

    /**
     * ClientService constructor.
     * @param OutputInterface $output
     * @param MessageService $messageService
     */
    public function __construct(OutputInterface $output, MessageService $messageService)
    {
        $this->messageService = $messageService;
        $this->output = $output;
    }

    /**
     * @param Server $server
     */
    public function addServer(Server $server)
    {
        $this->servers[$server->getRole()] = $server;
        $this->initServer($server);
    }

    /**
     * @param Server $server
     */
    public function removeServer(Server $server)
    {
        unset($this->servers[$server->getRole()]);
    }

    /**
     * @param string $serverRole
     * @return bool
     */
    public function isConnected(string $serverRole) : bool
    {
        return isset($this->servers[$serverRole]);
    }

    /**
     * @param WebSocket $connection
     * @param string $data
     */
    public function newMessage(WebSocket $connection, string $data)
    {
        $this->sandbox(function () use ($connection, $data) {
            $server = $this->findServer($connection);
            $message = $this->messageService->handle($server, $data);
            $this->handleMessage($message);
        });
    }

    /**
     * @param IncomingMessage $incomingMessage
     */
    protected function handleMessage(IncomingMessage $incomingMessage)
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
            $this->writeErrorLine('ClientService', $e->getMessage());
        } catch (\TypeError $e) {
            $this->writeErrorLine('ClientService', $e->getMessage());
        }
    }

    /**
     * @param WebSocket $connection
     * @return Server
     */
    private function findServer(WebSocket $connection)
    {
        foreach ($this->servers as $server) {
            if ($server->getConnection() === $connection) {
                return $server;
            }
        }

        throw new \RuntimeException('No connected server found!');
    }

    /**
     * @param Server $server
     */
    private function initServer(Server $server)
    {
        $authentication = (new AuthenticationMessage(getenv('AUTH_TOKEN')))->toRawMessage();
        $server->getConnection()->send((json_encode($authentication)));

        $introduction = (new IntroductionMessage($this->clientRole))->toRawMessage();
        $server->getConnection()->send(json_encode($introduction));
    }

    /**
     * @param ExtEventLoop $loop
     */
    public function setLoop(ExtEventLoop $loop)
    {
        $this->loop = $loop;
    }
}