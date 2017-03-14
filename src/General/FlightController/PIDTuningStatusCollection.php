<?php
namespace Volante\SkyBukkit\Common\Src\General\FlightController;

use Volante\SkyBukkit\Common\Src\Client\OutgoingMessage;

/**
 * Class PIDTuningStatusMessage
 *
 * @package Volante\SkyBukkit\Common\Src\General\FlightController
 */
class PIDTuningStatusCollection extends OutgoingMessage
{
    const TYPE = 'pidTuningStatus';

    /**
     * @var string
     */
    protected $type = self::TYPE;

    /**
     * @var string
     */
    protected $messageTitle = 'PID tuning status';

    /**
     * @var PIDTuningStatus
     */
    private $yawStatus;

    /**
     * @var PIDTuningStatus
     */
    private $rollStatus;

    /**
     * @var PIDTuningStatus
     */
    private $pitchStatus;

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