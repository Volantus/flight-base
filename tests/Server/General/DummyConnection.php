<?php
namespace Volantus\FlightBase\Tests\Server\General;

use Ratchet\ConnectionInterface;

/**
 * Class DummyConnection
 * @package Volantus\FlightBase\Tests\Server\General
 */
class DummyConnection implements ConnectionInterface
{
    /**
     * @var bool
     */
    private $connectionClosed = false;

    /**
     * @inheritdoc
     */
    function send($data)
    {
    }

    /**
     * @inheritdoc
     */
    function close()
    {
        $this->connectionClosed = true;
    }

    /**
     * @return bool
     */
    public function isConnectionClosed(): bool
    {
        return $this->connectionClosed;
    }
}