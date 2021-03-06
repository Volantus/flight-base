<?php
namespace Volantus\FlightBase\Src\General\GyroStatus;

use Volantus\FlightBase\Src\Client\OutgoingMessage;

/**
 * Class GyroStatus
 *
 * @package Volantus\FlightBase\Src\GyroStatus
 */
class GyroStatus extends OutgoingMessage implements \JsonSerializable
{
    const TYPE = 'gyroStatus';

    /***
     * @var string
     */
    protected $type = self::TYPE;

    /**
     * @var string
     */
    protected $messageTitle = 'Gyro Status';

    /**
     * @var float
     */
    private $yaw;

    /**
     * @var float
     */
    private $pitch;

    /**
     * @var float
     */
    private $roll;

    /**
     * GyroStatus constructor.
     *
     * @param float $yaw
     * @param float $roll
     * @param float $pitch
     */
    public function __construct(float $yaw, float $roll, float $pitch)
    {
        $this->yaw = $yaw;
        $this->pitch = $pitch;
        $this->roll = $roll;
    }

    /**
     * @return float
     */
    public function getYaw(): float
    {
        return $this->yaw;
    }

    /**
     * @return float
     */
    public function getPitch(): float
    {
        return $this->pitch;
    }

    /**
     * @return float
     */
    public function getRoll(): float
    {
        return $this->roll;
    }


    /**
     * @return array
     */
    public function getRawData(): array
    {
        return [
            'yaw'   => $this->yaw,
            'pitch' => $this->pitch,
            'roll'  => $this->roll
        ];
    }

    /**
     * @inheritdoc
     */
    function jsonSerialize()
    {
        return $this->getRawData();
    }
}
