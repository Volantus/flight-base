<?php
namespace Volantus\FlightBase\Src\General\MSP;

use Volantus\FlightBase\Src\Client\Server;

/**
 * Class MspServerBased
 *
 * @package Volantus\FlightBase\Src\General\MSP
 */
abstract class MspServerBased
{
    /**
     * Connections ready for MSP requests
     *
     * @var Server[]
     */
    protected $freeConnections = [];

    /**
     * MspServerBased constructor.
     *
     * @param Server[] $connections
     */
    public function __construct(array $connections = [])
    {
        foreach ($connections as $connection) {
            $this->addServer($connection);
        }
    }

    /**
     * @param Server $server
     */
    public function addServer(Server $server)
    {
        $this->freeConnections[spl_object_hash($server)] = $server;
    }

    /**
     * @param Server $server
     */
    public function removeServer(Server $server)
    {
        unset($this->freeConnections[spl_object_hash($server)]);
    }
}