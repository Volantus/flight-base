<?php
namespace Volante\SkyBukkit\Common\Src\General\FlightController;

use Volante\SkyBukkit\Common\Src\Server\Messaging\IncomingMessage;
use Volante\SkyBukkit\Common\Src\Server\Messaging\Sender;

/**
 * Class IncomingPIDTuningMessage
 *
 * @package Volante\SkyBukkit\Common\Src\General\FlightController
 */
abstract class IncomingPIDTuningMessage extends IncomingMessage
{
    /**
     * @var PIDTuningCollection
     */
    private $statusCollection;

    /**
     * IncomingPIDTuningStatusMessage constructor.
     *
     * @param Sender              $sender
     * @param PIDTuningCollection $status
     */
    public function __construct(Sender $sender, PIDTuningCollection $status)
    {
        parent::__construct($sender);
        $this->statusCollection = $status;
    }

    /**
     * @return PIDTuningCollection
     */
    public function getStatus(): PIDTuningCollection
    {
        return $this->statusCollection;
    }
}