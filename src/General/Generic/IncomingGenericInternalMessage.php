<?php
namespace Volantus\FlightBase\Src\General\Generic;

use Volantus\FlightBase\Src\Server\Messaging\IncomingMessage;
use Volantus\FlightBase\Src\Server\Messaging\Sender;

/**
 * Class IncomingGenericInternalMessage
 *
 * @package Volantus\FlightBase\Src\General\Generic
 */
class IncomingGenericInternalMessage extends IncomingMessage
{
    /**
     * @var mixed
     */
    private $payload;

    /**
     * IncomingGenericInternalMessage constructor.
     *
     * @param Sender $sender
     * @param mixed $payload
     */
    public function __construct(Sender $sender, $payload)
    {
        parent::__construct($sender);
        $this->payload = $payload;
    }

    /**
     * @return mixed
     */
    public function getPayload()
    {
        return $this->payload;
    }
}