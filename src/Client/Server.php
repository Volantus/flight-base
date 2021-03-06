<?php

namespace Volantus\FlightBase\Src\Client;

use Ratchet\Client\WebSocket;
use Volantus\FlightBase\Src\General\Generic\GenericInternalMessage;
use Volantus\FlightBase\Src\Server\Messaging\Sender;

/**
 * Class Server
 *
 * @package Volante\SkyBukkit\StatusBroker\Src\Network
 */
class Server implements Sender
{
    const ROLE_RELAY_SERVER_A  = 1;
    const ROLE_RELAY_SERVER_B  = 2;
    const ROLE_MSP_BROKER_A    = 3;
    const ROLE_MSP_BROKER_B    = 4;

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

    /**
     * @param mixed $payload
     */
    public function sendGenericMessage($payload)
    {
        $message = new GenericInternalMessage($payload);
        $message = json_encode($message->toRawMessage());
        $this->send($message);
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

    /**
     * @return bool
     */
    public function isRelayServer(): bool
    {
        return $this->role == self::ROLE_RELAY_SERVER_A
            || $this->role == self::ROLE_RELAY_SERVER_B;
    }

    /**
     * @return bool
     */
    public function isMspServer(): bool
    {
        return $this->role == self::ROLE_MSP_BROKER_A
            || $this->role == self::ROLE_MSP_BROKER_B;
    }
}