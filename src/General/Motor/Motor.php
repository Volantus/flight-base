<?php
namespace Volantus\FlightBase\Src\General\Motor;

/**
 * Class Motor
 * @package Volante\SkyBukkit\FlightController\Src\FlightController
 */
class Motor implements \JsonSerializable
{
    const ZERO_LEVEL = 0;
    const FULL_LEVEL = 1;

    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $pin;

    /**
     * @var float
     */
    private $power;

    /**
     * Motor constructor.
     *
     * @param int $id
     * @param int $power
     * @param int $pin
     */
    public function __construct(int $id, int $power, int $pin = null)
    {
        $this->id = $id;
        $this->power = $power;
        $this->pin = $pin;
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
     * @return int
     */
    public function getPin(): int
    {
        return $this->pin;
    }

    /**
     * @inheritdoc
     */
    function jsonSerialize()
    {
        return [
            'id'    => $this->id,
            'pin'   => $this->pin,
            'power' => $this->power
        ];
    }
}