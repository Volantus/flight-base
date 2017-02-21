<?php
namespace Volante\SkyBukkit\Common\Src\General\Motor;

/**
 * Class Motor
 * @package Volante\SkyBukkit\FlightController\Src\FlightController
 */
class Motor implements \JsonSerializable
{
    const ZERO_LEVEL = 1000;
    const FULL_LEVEL = 2000;

    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $gpioPin;

    /**
     * @var int
     */
    private $power;

    /**
     * Motor constructor.
     *
     * @param int $id
     * @param int $power
     * @param int $gpioPin
     */
    public function __construct(int $id, int $power, int $gpioPin = null)
    {
        $this->id = $id;
        $this->power = $power;

        $this->gpioPin = $gpioPin ?: (int) getenv('MOTOR_' . $this->id . '_PIN');
        if (!is_int($this->gpioPin) || $this->gpioPin == 0) {
            throw new \InvalidArgumentException('GPIO Pin for motor ' . $this->id . ' needs to be configured');
        }
    }

    /**
     * @param int $delta
     */
    public function changePower(int $delta)
    {
        $this->power += $delta;
        $this->keepPowerLimits();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return float
     */
    public function getPower(): float
    {
        return $this->power;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @param int $power
     */
    public function setPower(int $power)
    {
        $this->power = $power;
        $this->keepPowerLimits();
    }

    private function keepPowerLimits()
    {
        if ($this->power < self::ZERO_LEVEL) {
            $this->power = self::ZERO_LEVEL;
        } elseif ($this->power > self::FULL_LEVEL) {
            $this->power = self::FULL_LEVEL;
        }
    }

    /**
     * @return int
     */
    public function getGpioPin(): int
    {
        return $this->gpioPin;
    }

    /**
     * @inheritdoc
     */
    function jsonSerialize()
    {
        return [
            'id'    => $this->id,
            'pin'   => $this->gpioPin,
            'power' => $this->power
        ];
    }
}