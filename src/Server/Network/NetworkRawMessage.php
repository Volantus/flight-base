<?php
namespace Volantus\FlightBase\Src\Server\Network;

use Volantus\FlightBase\Src\Server\Messaging\Sender;

/**
 * Class Message
 * @package Volante\SkyBukkit\Monitor\Src\FlightStatus\Network
 */
class NetworkRawMessage extends \Volantus\FlightBase\Src\General\Network\BaseRawMessage
{
    /**
     * @var Sender
     */
    private $sender;

    /**
     * Message constructor.
     * @param Sender $client
     * @param string $type
     * @param string $title
     * @param array $data
     * @internal param ClientInterface $client
     */
    public function __construct(Sender $client, string $type, string $title, array $data)
    {
        parent::__construct($type, $title, $data);
        $this->sender = $client;
    }

    /**
     * @return Sender
     */
    public function getSender(): Sender
    {
        return $this->sender;
    }
}