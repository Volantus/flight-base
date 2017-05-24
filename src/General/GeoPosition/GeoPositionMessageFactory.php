<?php
namespace Volantus\FlightBase\Src\General\GeoPosition;

use Volantus\FlightBase\Src\Server\Messaging\IncomingMessage;
use Volantus\FlightBase\Src\Server\Messaging\MessageFactory;
use Volantus\FlightBase\Src\Server\Network\NetworkRawMessage;

/**
 * Class GeoPositionFactory
 * @package Volantus\FlightBase\Src\General\GeoPosition
 */
class GeoPositionMessageFactory extends MessageFactory
{
    /**
     * @var string
     */
    protected $type = GeoPosition::TYPE;

    /**
     * @param NetworkRawMessage $rawMessage
     * @return IncomingGeoPositionMessage|IncomingMessage
     */
    public function create(NetworkRawMessage $rawMessage): IncomingMessage
    {
        $data = $rawMessage->getData();
        $this->validateNumeric($data, 'longitude');
        $this->validateNumeric($data, 'latitude');
        $this->validateNumeric($data, 'altitude');

        return new IncomingGeoPositionMessage($rawMessage->getSender(), new GeoPosition($data['latitude'], $data['longitude'], $data['altitude']));
    }
}