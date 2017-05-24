<?php
namespace Volantus\FlightBase\Src\General\Motor;

use Volantus\FlightBase\Src\General\GyroStatus\GyroStatus;
use Volantus\FlightBase\Src\Server\Messaging\IncomingMessage;
use Volantus\FlightBase\Src\Server\Messaging\MessageFactory;
use Volantus\FlightBase\Src\Server\Network\NetworkRawMessage;

/**
 * Class MotorControlMessageFactory
 *
 * @package Volantus\FlightBase\Src\General\Motor
 */
class MotorControlMessageFactory extends MessageFactory
{
    /**
     * @var string
     */
    protected $type = MotorControlMessage::TYPE;

    /**
     * @param NetworkRawMessage $rawMessage
     *
     * @return IncomingMessage|IncomingMotorControlMessage
     */
    public function create(NetworkRawMessage $rawMessage): IncomingMessage
    {
        $data = $rawMessage->getData();
        $this->validateArray($data, 'desiredPosition');
        $this->validateNumeric($data['desiredPosition'], 'yaw');
        $this->validateNumeric($data['desiredPosition'], 'roll');
        $this->validateNumeric($data['desiredPosition'], 'pitch');

        $this->validateNumeric($data, 'horizontalThrottle');
        $this->validateNumeric($data, 'verticalThrottle');
        $this->validateBool($data, 'motorsStarted');

        $gyroStatus = new GyroStatus($data['desiredPosition']['yaw'], $data['desiredPosition']['roll'], $data['desiredPosition']['pitch']);
        $motorControl = new MotorControlMessage($gyroStatus, $data['horizontalThrottle'], $data['verticalThrottle'], $data['motorsStarted']);

        return new IncomingMotorControlMessage($rawMessage->getSender(), $motorControl);
    }
}