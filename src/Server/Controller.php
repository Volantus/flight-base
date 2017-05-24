<?php
namespace Volantus\FlightBase\Src\Server;

use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Volantus\FlightBase\Src\Server\Messaging\MessageServerService;

/**
 * Class Controller
 * @package Volantus\FlightBase\Src\Server
 */
class Controller implements MessageComponentInterface
{
    /**
     * @var MessageServerService
     */
    private $service;

    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * Controller constructor.
     * @param OutputInterface $output
     * @param MessageServerService $messageRelayService
     */
    public function __construct(OutputInterface $output, MessageServerService $messageRelayService)
    {
        $this->service = $messageRelayService;
        $this->output = $output;
    }

    /**
     * @param ConnectionInterface $conn
     */
    public function onOpen(ConnectionInterface $conn)
    {
        $this->service->newClient($conn);
    }

    /**
     * @param ConnectionInterface $from
     * @param string $msg
     */
    public function onMessage(ConnectionInterface $from, $msg)
    {
        $this->service->newMessage($from, $msg);
    }

    /**
     * @param ConnectionInterface $conn
     */
    public function onClose(ConnectionInterface $conn)
    {
        $this->service->removeClient($conn);
    }

    /**
     * @param ConnectionInterface $conn
     * @param \Exception $e
     */
    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        $this->output->writeln('<error>[Controller] ' . $e->getMessage() . '</error>');
        $this->service->removeClient($conn);
    }
}