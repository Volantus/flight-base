<?php
namespace Volante\SkyBukkit\Common\Src\General\FlightController;

use Volante\SkyBukkit\Common\Src\Server\Messaging\IncomingMessage;
use Volante\SkyBukkit\Common\Src\Server\Messaging\MessageFactory;
use Volante\SkyBukkit\Common\Src\Server\Network\NetworkRawMessage;

/**
 * Class PIDTuningStatusMessageFactory
 *
 * @package Volante\SkyBukkit\Common\Src\General\FlightController
 */
class PIDTuningStatusMessageFactory extends MessageFactory
{
    /**
     * @var string
     */
    protected $type = PIDTuningStatusCollection::TYPE;

    /**
     * @param NetworkRawMessage $rawMessage
     *
     * @return IncomingPIDTuningStatusMessage|IncomingMessage
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

        $statusCollection = new PIDTuningStatusCollection($this->buildStatus($data['yaw']), $this->buildStatus($data['roll']), $this->buildStatus($data['pitch']));
        return new IncomingPIDTuningStatusMessage($rawMessage->getSender(), $statusCollection);
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