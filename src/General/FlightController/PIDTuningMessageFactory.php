<?php
namespace Volantus\FlightBase\Src\General\FlightController;

use Volantus\FlightBase\Src\Server\Messaging\IncomingMessage;
use Volantus\FlightBase\Src\Server\Messaging\MessageFactory;
use Volantus\FlightBase\Src\Server\Messaging\Sender;
use Volantus\FlightBase\Src\Server\Network\NetworkRawMessage;

/**
 * Class PIDTuningMessageFactory
 *
 * @package Volantus\FlightBase\Src\General\FlightController
 */
abstract class PIDTuningMessageFactory extends MessageFactory
{
    /**
     * @param PIDTuningStatus $yawStatus
     * @param PIDTuningStatus $rollStatus
     * @param PIDTuningStatus $pitchStatus
     *
     * @return PIDTuningCollection
     */
    abstract protected function createCollection(PIDTuningStatus $yawStatus, PIDTuningStatus $rollStatus, PIDTuningStatus $pitchStatus): PIDTuningCollection;

    /**
     * @param Sender              $sender
     * @param PIDTuningCollection $pidCollection
     *
     * @return IncomingPIDTuningMessage
     */
    abstract protected function createIncomingMessage(Sender $sender, PIDTuningCollection $pidCollection): IncomingPIDTuningMessage;

    /**
     * @param NetworkRawMessage $rawMessage
     *
     * @return IncomingMessage
     */
    public function create(NetworkRawMessage $rawMessage): IncomingMessage
    {
        $data = $rawMessage->getData();
        $this->validateArray($data, 'yaw');
        $this->validateArray($data, 'roll');
        $this->validateArray($data, 'pitch');

        foreach ($data as $type => $statusData) {
            $this->validateNumeric($data[$type], 'Kp');
            $this->validateNumeric($data[$type], 'Ki');
            $this->validateNumeric($data[$type], 'Kd');
        }

        $statusCollection = $this->createCollection($this->buildStatus($data['yaw']), $this->buildStatus($data['roll']), $this->buildStatus($data['pitch']));
        return $this->createIncomingMessage($rawMessage->getSender(), $statusCollection);
    }

    /**
     * @param array $data
     *
     * @return PIDTuningStatus
     */
    private function buildStatus(array $data): PIDTuningStatus
    {
        return new PIDTuningStatus($data['Kp'], $data['Ki'], $data['Kd']);
    }
}