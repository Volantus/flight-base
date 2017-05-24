<?php
namespace Volantus\FlightBase\Src\Server\Network;

use Ratchet\ConnectionInterface;

/**
 * Class ClientFactory
 * @package Volantus\FlightBase\Src\Server\Network
 */
class ClientFactory
{
    /**
     * @var int
     */
    private $currentId = 0;

    /**
     * @param ConnectionInterface $connection
     * @return Client
     */
    public function get(ConnectionInterface $connection)
    {
        return new Client($this->getNextId(), $connection, -1);
    }

    protected function getNextId() : int
    {
        $this->currentId++;
        return $this->currentId;
    }
}