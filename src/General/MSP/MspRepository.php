<?php
namespace Volantus\FlightBase\Src\General\MSP;

use Volantus\FlightBase\Src\Client\Server;
use Volantus\FlightBase\Src\General\Generic\GenericInternalMessage;
use Volantus\MSPProtocol\Src\Protocol\Request\Request;
use Volantus\MSPProtocol\Src\Protocol\Response\Response;

/**
 * Class MspRepository
 *
 * @package Volantus\FlightBase\Src\General\MSP
 */
abstract class MspRepository extends MspServerBased
{
    /**
     * @var array
     */
    protected $currentEntities = [];

    /**
     * @var int
     */
    protected $priority = 3;

    public function sendRequests()
    {
        if (!empty($this->freeConnections)) {
            $request = new MSPRequestMessage($this->priority, $this->createMspRequest());
            $request = new GenericInternalMessage($request);
            $request = $request->toRawMessage();
            $request = json_encode($request);

            foreach ($this->freeConnections as $objHash => $connection) {
                $connection->send($request);
                unset($this->freeConnections[$objHash]);
            }
        }
    }

    /**
     * @param Server             $server
     * @param MSPResponseMessage $message
     *
     * @return mixed
     */
    public function onMspResponse(Server $server, MSPResponseMessage $message)
    {
        $objHash = spl_object_hash($server);
        $this->freeConnections[$objHash] = $server;

        $this->currentEntities[$objHash] = $this->decodeResponse($message->getMspResponse());
        return $this->currentEntities[$objHash];
    }

    /**
     * @return Request
     */
    protected abstract function createMspRequest(): Request;

    /**
     * @param Response $response
     *
     * @return mixed
     */
    protected abstract function decodeResponse(Response $response);
}