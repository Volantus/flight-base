<?php
namespace Volante\SkyBukkit\Common\Src\General\GeoPosition;

use Volante\SkyBukkit\Common\Src\Server\Messaging\IncomingMessage;
use Volante\SkyBukkit\Common\Src\Server\Messaging\Sender;

/**
 * Class IncomingGeoPositionMessage
 * @package Volante\SkyBukkit\Common\Src\General\GeoPosition
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