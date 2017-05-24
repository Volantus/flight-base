<?php
namespace Volantus\FlightBase\Src\Server\Network;

use Ratchet\ConnectionInterface;
use Volantus\FlightBase\Src\Server\Messaging\Sender;
use Volantus\FlightBase\Src\Server\Subscription\Topic;


/**
 * Class Connection
 * @package Volante\SkyBukkit\Monitor\Src\FlightStatus\Network
 */
class Client implements Sender
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var ConnectionInterface
     */
    private $connection;

    /**
     * @var bool
     */
    private $authenticated = false;

    /**
     * @var int
     */
    private $role;

    /**
     * Client constructor.
     * @param int $id
     * @param ConnectionInterface $connection
     * @param int $role
     */
    public function __construct(int $id, ConnectionInterface $connection, int $role)
    {
        $this->connection = $connection;
        $this->role = $role;
        $this->id = $id;
    }

    /**
     * @return ConnectionInterface
     */
    public function getConnection(): ConnectionInterface
    {
        return $this->connection;
    }

    /**
     * @param int $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * @return int
     */
    public function getRole(): int
    {
        return $this->role;
    }

    public function setAuthenticated()
    {
        $this->authenticated = true;
    }

    /**
     * @return bool
     */
    public function isAuthenticated(): bool
    {
        return $this->authenticated;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param string $data
     */
    public function send(string $data)
    {
        $this->connection->send($data);
    }

    public function disconnect()
    {
        $this->connection->close();
    }
}