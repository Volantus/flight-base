<?php
namespace Volantus\FlightBase\Src\General\FlightController;

use Volantus\FlightBase\Src\Server\Messaging\Sender;

/**
 * Class PIDTuningUpdateMessageFactory
 *
 * @package Volantus\FlightBase\Src\General\FlightController
 */
class PIDTuningUpdateMessageFactory extends PIDTuningMessageFactory
{
    /**
     * @var string
     */
    protected $type = PIDTuningUpdateCollection::TYPE;

    /**
     * @param PIDTuningStatus $yawStatus
     * @param PIDTuningStatus $rollStatus
     * @param PIDTuningStatus $pitchStatus
     *
     * @return PIDTuningCollection|PIDTuningUpdateCollection
     */
    protected function createCollection(PIDTuningStatus $yawStatus, PIDTuningStatus $rollStatus, PIDTuningStatus $pitchStatus): PIDTuningCollection
    {
        return new PIDTuningUpdateCollection($yawStatus, $rollStatus, $pitchStatus);
    }

    /**
     * @param Sender              $sender
     * @param PIDTuningCollection $pidCollection
     *
     * @return IncomingPIDTuningMessage|IncomingPIDTuningUpdateMessage
     */
    protected function createIncomingMessage(Sender $sender, PIDTuningCollection $pidCollection): IncomingPIDTuningMessage
    {
        return new IncomingPIDTuningUpdateMessage($sender, $pidCollection);
    }
}