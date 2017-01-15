<?php
namespace Volante\SkyBukkit\Common\Src\Server\Role;

use Assert\Assertion;
use Volante\SkyBukkit\Common\Src\General\Role\ClientRole;
use Volante\SkyBukkit\Common\Src\Server\Messaging\Message;
use Volante\SkyBukkit\Common\Src\Server\Messaging\MessageFactory;
use Volante\SkyBukkit\Common\Src\Server\Network\RawMessage;

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
     * @param RawMessage $rawMessage
     * @return IntroductionMessage|Message
     */
    public function create(RawMessage $rawMessage) : Message
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