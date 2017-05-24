<?php
namespace Volantus\FlightBase\Src\General\FlightController;

/**
 * Class PIDTuningUpdateCollection
 *
 * @package Volantus\FlightBase\Src\General\FlightController
 */
class PIDTuningUpdateCollection extends PIDTuningCollection
{
    const TYPE = 'pidTuningUpdate';

    /**
     * @var string
     */
    protected $type = self::TYPE;

    /**
     * @var string
     */
    protected $messageTitle = 'PID tuning update';
}