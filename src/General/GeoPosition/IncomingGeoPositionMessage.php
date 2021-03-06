<?php
namespace Volantus\FlightBase\Src\General\GeoPosition;

use Volantus\FlightBase\Src\Server\Messaging\IncomingMessage;
use Volantus\FlightBase\Src\Server\Messaging\Sender;

/**
 * Class IncomingGeoPositionMessage
 * @package Volantus\FlightBase\Src\General\GeoPosition
 */
class IncomingGeoPositionMessage extends IncomingMessage
{
    /**
     * @var GeoPosition
     */
    private $geoPosition;

    /**
     * IncomingGeoPositionMessage constructor.
     * @param Sender $sender
     * @param GeoPosition $geoPosition
     */
    public function __construct(Sender $sender, GeoPosition $geoPosition)
    {
        parent::__construct($sender);
        $this->geoPosition = $geoPosition;
    }

    /**
     * @return GeoPosition
     */
    public function getGeoPosition(): GeoPosition
    {
        return $this->geoPosition;
    }
}