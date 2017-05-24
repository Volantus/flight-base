<?php

namespace Volantus\FlightBase\Src\Client;

use Ratchet\Client\WebSocket;
use Volantus\FlightBase\Src\Server\Messaging\Sender;

/**
 * Class Server
 *
 * @package Volante\SkyBukkit\StatusBroker\Src\Network
 */
class Server implements Sender
{
    const ROLE_LOCAL_RELAY_SERVER   = 1;
    const ROLE_REMOTE_RELAY_SERVER  = 2;
    const ROLE_GEO_POSITION_SERVICE = 3;
    const ROLE_GYRO_STATUS_SERVICE  = 4;

    /**
     * @var WebSocket
     */
    private $connection;

    /**
     * @var int
     */
    private $role;

    /**
     * Server constructor.
     *
     * @param WebSocket $connection
     * @param int       $role
     */
    public function __construct(WebSocket $connection, int $role)
    {
        $this->connection = $connection;
        $this->role = $role;
    }

    /**
     * @return WebSocket
     */
    public function getConnection(): WebSocket
    {
        return $this->connection;
    }

    /**
     * @return int
     */
    public function getRole(): int
    {
        return $this->role;
    }

    /**
     * @return bool
     */
    public function isAuthenticated(): bool
    {
        return true;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return 1;
    }

    /**
     * @param string $data
     */
    public function send(string $data)
    {
        $this->connection->send($data);
    }


    public function setAuthenticated()
    {
    }

    /**
     * @param int $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    public function disconnect()
    {
        $this->connection->close();
    }
}