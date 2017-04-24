<?php
namespace Volante\SkyBukkit\Common\Src\General\FlightController;

use Volante\SkyBukkit\Common\Src\Client\OutgoingMessage;

/**
 * Class PIDTuningCollection
 *
 * @package Volante\SkyBukkit\Common\Src\General\FlightController
 */
abstract class PIDTuningCollection extends OutgoingMessage
{
    /**
     * @var PIDTuningStatus
     */
    protected $yawStatus;

    /**
     * @var PIDTuningStatus
     */
    protected $rollStatus;

    /**
     * @var PIDTuningStatus
     */
    protected $pitchStatus;

    /**
     * PIDTuningStatusMessage constructor.
     *
     * @param PIDTuningStatus $yawStatus
     * @param PIDTuningStatus $rollStatus
     * @param PIDTuningStatus $pitchStatus
     */
    public function __construct(PIDTuningStatus $yawStatus, PIDTuningStatus $rollStatus, PIDTuningStatus $pitchStatus)
    {
        $this->yawStatus = $yawStatus;
        $this->rollStatus = $rollStatus;
        $this->pitchStatus = $pitchStatus;
    }

    /**
     * @return PIDTuningStatus
     */
    public function getYawStatus(): PIDTuningStatus
    {
        return $this->yawStatus;
    }

    /**
     * @return PIDTuningStatus
     */
    public function getRollStatus(): PIDTuningStatus
    {
        return $this->rollStatus;
    }

    /**
     * @return PIDTuningStatus
     */
    public function getPitchStatus(): PIDTuningStatus
    {
        return $this->pitchStatus;
    }

    /**
     * @return array
     */
    public function getRawData(): array
    {
        return [
            'yaw'   => $this->yawStatus,
            'roll'  => $this->rollStatus,
            'pitch' => $this->pitchStatus
        ];
    }
}