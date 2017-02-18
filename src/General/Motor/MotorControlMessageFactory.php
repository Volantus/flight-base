<?php
namespace Volante\SkyBukkit\Common\Src\General\Motor;

use Volante\SkyBukkit\Common\Src\General\GyroStatus\GyroStatus;
use Volante\SkyBukkit\Common\Src\Server\Messaging\IncomingMessage;
use Volante\SkyBukkit\Common\Src\Server\Messaging\MessageFactory;
use Volante\SkyBukkit\Common\Src\Server\Network\NetworkRawMessage;

/**
 * Class MotorControlMessageFactory
 *
 * @package Volante\SkyBukkit\Common\Src\General\Motor
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

        $gyroStatus = new GyroStatus($data['desiredPosition']['yaw'], $data['desiredPosition']['roll'], $data['desiredPosition']['pitch']);
        $motorControl = new MotorControlMessage($gyroStatus, $data['horizontalThrottle'], $data['verticalThrottle']);

        return new IncomingMotorControlMessage($rawMessage->getSender(), $motorControl);
    }
}