<?php
namespace Volante\SkyBukkit\Common\Src\Server\Messaging;

use Volante\SkyBukkit\Common\Src\Server\Network\Client;

/**
 * Class Message
 * @package Volante\SkyBukkit\Common\Src\Server\FlightStatus\Network
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