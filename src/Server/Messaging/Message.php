<?php
namespace Volante\SkyBukkit\Common\Src\Server\Messaging;

use Volante\SkyBukkit\Common\Src\Server\Network\Client;

/**
 * Class Message
 * @package Volante\SkyBukkit\Common\Src\Server\FlightStatus\Network
 */
abstract class Message
{
    /**
     * @var Client
     */
    private $sender;

    /**
     * Message constructor.
     * @param Client $sender
     */
    public function __construct(Client $sender)
    {
        $this->sender = $sender;
    }

    /**
     * @return Client
     */
    public function getSender(): Client
    {
        return $this->sender;
    }
}