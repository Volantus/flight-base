<?php
namespace Volantus\FlightBase\Src\General\FlightController;

/**
 * Class PIDTuningStatus
 *
 * @package Volantus\FlightBase\Src\General\FlightController
 */
class PIDTuningStatus implements \JsonSerializable
{
    /**
     * @var float
     */
    private $Kp;

    /**
     * @var float
     */
    private $Ki;

    /**
     * @var float
     */
    private $Kd;

    /**
     * PIDTuningStatus constructor.
     *
     * @param float $Kp
     * @param float $Ki
     * @param float $Kd
     */
    public function __construct(float $Kp, float $Ki, float $Kd)
    {
        $this->Kp = $Kp;
        $this->Ki = $Ki;
        $this->Kd = $Kd;
    }

    /**
     * @return float
     */
    public function getKp(): float
    {
        return $this->Kp;
    }

    /**
     * @return float
     */
    public function getKi(): float
    {
        return $this->Ki;
    }

    /**
     * @return float
     */
    public function getKd(): float
    {
        return $this->Kd;
    }

    /**
     * @inheritdoc
     */
    function jsonSerialize()
    {
        return [
            'Kp' => $this->Kp,
            'Ki' => $this->Ki,
            'Kd' => $this->Kd
        ];
    }
}