<?php
namespace Volantus\FlightBase\Src\General\FlightController;

/**
 * Class PIDTuningStatusMessage
 *
 * @package Volantus\FlightBase\Src\General\FlightController
 */
class PIDTuningStatusCollection extends PIDTuningCollection
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
}