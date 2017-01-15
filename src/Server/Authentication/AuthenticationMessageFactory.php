<?php
namespace Volante\SkyBukkit\Common\Src\Server\Authentication;

use Volante\SkyBukkit\Common\Src\Server\Messaging\Message;
use Volante\SkyBukkit\Common\Src\Server\Messaging\MessageFactory;
use Volante\SkyBukkit\Common\Src\Server\Network\RawMessage;

/**
 * Class AuthenticationMessageFactory
 * @package Volante\SkyBukkit\Common\Src\Server\Authentication
 */
class AuthenticationMessageFactory extends MessageFactory
{
    /**
     * @var string
     */
    protected $type = AuthenticationMessage::TYPE;

    /**
     * @param RawMessage $rawMessage
     * @return AuthenticationMessage|Message
     */
    public function create(RawMessage $rawMessage) : Message
    {
        $this->validateString($rawMessage->getData(), 'token');
        return new AuthenticationMessage($rawMessage->getSender(), $rawMessage->getData()['token']);
    }
}