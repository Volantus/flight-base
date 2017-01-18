<?php
namespace Volante\SkyBukkit\Common\Src\Client;

use Ratchet\Client\WebSocket;
use Volante\SkyBukkit\Common\Src\Server\Messaging\Sender;

/**
 * Class Server
 * @package Volante\SkyBukkit\StatusBroker\Src\Network
 */
class Server implements Sender
{
    const ROLE_LOCAL = 'local';
    const ROLE_REMOTE = 'remote';
    const ROLE_GEO_POSITION_SERVICE = 'geoPositionService';

    /**
     * @var WebSocket
     */
    private $connection;

    /**
     * @var string
     */
    private $role;

    /**
     * Server constructor.
     * @param WebSocket $connection
     * @param string $role
     */
    public function __construct(WebSocket $connection, string $role)
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
     * @return string
     */
    public function getRole(): string
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
     * @param string $role
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