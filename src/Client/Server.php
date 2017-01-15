<?php
namespace Volante\SkyBukkit\Common\Src\Client;

use Ratchet\Client\WebSocket;

/**
 * Class Server
 * @package Volante\SkyBukkit\StatusBroker\Src\Network
 */
class Server
{
    const ROLE_LOCAL  = 'local';
    const ROLE_REMOTE = 'remote';

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
}