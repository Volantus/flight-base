<?php
namespace Volante\SkyBukkit\Common\Src\General\GyroStatus;

use Volante\SkyBukkit\Common\Src\Server\Messaging\IncomingMessage;
use Volante\SkyBukkit\Common\Src\Server\Messaging\MessageFactory;
use Volante\SkyBukkit\Common\Src\Server\Network\NetworkRawMessage;

/**
 * Class GyroStatusMessageFactory
 *
 * @package Volante\SkyBukkit\Common\Src\General\GyroStatus
 */
class GyroStatusMessageFactory extends MessageFactory
{
    /**
     * @var string
     */
    protected $type = GyroStatus::TYPE;

    /**
     * @param NetworkRawMessage $rawMessage
     * @return IncomingGyroStatusMessage|IncomingMessage
     */
    public function create(NetworkRawMessage $rawMessage): IncomingMessage
    {
        $data = $rawMessage->getData();
        $this->validateNumeric($data, 'yaw');
        $this->validateNumeric($data, 'roll');
        $this->validateNumeric($data, 'pitch');

        return new IncomingGyroStatusMessage($rawMessage->getSender(), new GyroStatus($data['yaw'], $data['roll'], $data['pitch']));
    }
}