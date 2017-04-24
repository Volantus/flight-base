<?php
namespace Volante\SkyBukkit\Common\Src\General\FlightController;

/**
 * Class PIDTuningUpdateCollection
 *
 * @package Volante\SkyBukkit\Common\Src\General\FlightController
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