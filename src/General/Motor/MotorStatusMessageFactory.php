<?php
namespace Volantus\FlightBase\Src\General\Motor;

use Volantus\FlightBase\Src\Server\Messaging\IncomingMessage;
use Volantus\FlightBase\Src\Server\Messaging\MessageFactory;
use Volantus\FlightBase\Src\Server\Network\NetworkRawMessage;

/**
 * Class MotorStatusMessageFactory
 * @package Volantus\FlightBase\Src\General\Motor
 */
class MotorStatusMessageFactory extends MessageFactory
{
    /**
     * @var string
     */
    protected $type = MotorStatus::TYPE;

    /**
     * @param NetworkRawMessage $rawMessage
     *
     * @return IncomingMotorStatusMessage|IncomingMessage
     */
    public function create(NetworkRawMessage $rawMessage): IncomingMessage
    {
        $data = $rawMessage->getData();
        $this->validateArray($data, 'motors');

        $motors = [];
        foreach ($data['motors'] as $motor) {
            $this->validateNumeric($motor, 'id');
            $this->validateNumeric($motor, 'pin');
            $this->validateNumeric($motor, 'power');

            $motors[] = new Motor($motor['id'], $motor['power'], $motor['pin']);
        }

        return new IncomingMotorStatusMessage($rawMessage->getSender(), new MotorStatus($motors));
    }
}