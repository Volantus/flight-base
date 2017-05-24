<?php
namespace Volantus\FlightBase\Src\Server\Messaging;

/**
 * Class Message
 * @package Volantus\FlightBase\Src\Server\FlightStatus\Network
 */
abstract class IncomingMessage
{
    /**
     * @var Sender
     */
    private $sender;

    /**
     * Message constructor.
     * @param Sender $sender
     */
    public function __construct(Sender $sender)
    {
        $this->sender = $sender;
    }

    /**
     * @return Sender
     */
    public function getSender(): Sender
    {
        return $this->sender;
    }
}