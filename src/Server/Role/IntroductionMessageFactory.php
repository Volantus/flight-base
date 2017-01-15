<?php
namespace Volante\SkyBukkit\Common\Src\Server\Role;

use Assert\Assertion;
use Volante\SkyBukkit\Common\Src\General\Role\ClientRole;
use Volante\SkyBukkit\Common\Src\Server\Messaging\IncomingMessage;
use Volante\SkyBukkit\Common\Src\Server\Messaging\MessageFactory;
use Volante\SkyBukkit\Common\Src\Server\Network\NetworkRawMessage;

/**
 * Class IntroductionMessageFactory
 * @package Volante\SkyBukkit\Common\Src\Server\Role
 */
class IntroductionMessageFactory extends MessageFactory
{
    /**
     * @var string
     */
    protected $type = IntroductionMessage::TYPE;

    /**
     * @param NetworkRawMessage $rawMessage
     * @return IntroductionMessage|IncomingMessage
     */
    public function create(NetworkRawMessage $rawMessage) : IncomingMessage
    {
        $this->validate($rawMessage->getData());
        return new IntroductionMessage($rawMessage->getSender(), (int) $rawMessage->getData()['role']);
    }

    /**
     * @param array $data
     */
    protected function validate(array $data)
    {
        $this->validateNumeric($data, 'role');
        Assertion::inArray($data['role'], ClientRole::getSupportedRoles(), 'Invalid ' . IntroductionMessage::TYPE . ' message: given role is not supported');
    }
}