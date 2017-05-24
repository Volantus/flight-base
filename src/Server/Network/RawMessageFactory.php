<?php
namespace Volantus\FlightBase\Src\Server\Network;

use Volantus\FlightBase\Src\Server\Messaging\Sender;

/**
 * Class MessageFactory
 *
 * @package Volante\SkyBukkit\Monitor\Src\FlightStatus\Network
 */
class RawMessageFactory extends \Volantus\FlightBase\Src\General\Network\RawMessageFactory
{
    /**
     * @param Sender $sender
     * @param string $json
     * @return NetworkRawMessage
     */
    public function create(Sender $sender, string $json) : NetworkRawMessage
    {
        $json = $this->getJsonData($json);
        $rawMessage = new NetworkRawMessage($sender, $json['type'], $json['title'], $json['data']);

        return $rawMessage;
    }
}