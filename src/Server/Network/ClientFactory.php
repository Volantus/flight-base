<?php
namespace Volante\SkyBukkit\Common\Src\Server\Network;

use Ratchet\ConnectionInterface;

/**
 * Class ClientFactory
 * @package Volante\SkyBukkit\Common\Src\Server\Network
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
        $this->currentId++;
        return new Client($this->currentId, $connection, -1);
    }
}