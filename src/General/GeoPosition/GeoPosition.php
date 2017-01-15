<?php
namespace Volante\SkyBukkit\Common\Src\General\GeoPosition;

use Volante\SkyBukkit\Common\Src\Client\OutgoingMessage;

/**
 * Class GeoPosition
 * @package Volante\SkyBukkit\Common\Src\General\GeoPosition
 */
class GeoPosition extends OutgoingMessage
{
    const TYPE = 'geoPosition';

    /**
     * @var string
     */
    protected $type = self::TYPE;

    /**
     * @var string
     */
    protected $messageTitle = 'Geo position';

    /**
     * @var float
     */
    private $latitude;

    /**
     * @var float
     */
    private $longitude;

    /**
     * @var float
     */
    private $altitude;

    /**
     * GeoPosition constructor.
     * @param float $latitude
     * @param float $longitude
     * @param float $altitude
     */
    public function __construct(float $latitude, float $longitude, float $altitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->altitude = $altitude;
    }

    /**
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * @return float
     */
    public function getAltitude(): float
    {
        return $this->altitude;
    }

    /**
     * @return array
     */
    protected function getRawData(): array
    {
        return [
            'latitude'  => $this->latitude,
            'longitude' => $this->longitude,
            'altitude'  => $this->altitude
        ];
    }
}