<?php
namespace Volantus\FlightBase\Src\General\FlightController;

use Volantus\FlightBase\Src\Server\Messaging\Sender;

/**
 * Class PIDTuningStatusMessageFactory
 *
 * @package Volantus\FlightBase\Src\General\FlightController
 */
class PIDTuningStatusMessageFactory extends PIDTuningMessageFactory
{
    /**
     * @var string
     */
    protected $type = PIDTuningStatusCollection::TYPE;

    /**
     * @param PIDTuningStatus $yawStatus
     * @param PIDTuningStatus $rollStatus
     * @param PIDTuningStatus $pitchStatus
     *
     * @return PIDTuningCollection|PIDTuningStatusCollection
     */
    protected function createCollection(PIDTuningStatus $yawStatus, PIDTuningStatus $rollStatus, PIDTuningStatus $pitchStatus): PIDTuningCollection
    {
        return new PIDTuningStatusCollection($yawStatus, $rollStatus, $pitchStatus);
    }

    /**
     * @param Sender              $sender
     * @param PIDTuningCollection $pidCollection
     *
     * @return IncomingPIDTuningMessage|IncomingPIDTuningStatusMessage
     */
    protected function createIncomingMessage(Sender $sender, PIDTuningCollection $pidCollection): IncomingPIDTuningMessage
    {
        return new IncomingPIDTuningStatusMessage($sender, $pidCollection);
    }
}