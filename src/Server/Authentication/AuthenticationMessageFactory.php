<?php
namespace Volante\SkyBukkit\Common\Src\Server\Authentication;

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
    protected $label = AuthenticationMessage::TYPE;

    /**
     * @param RawMessage $rawMessage
     * @return AuthenticationMessage
     */
    public function create(RawMessage $rawMessage) : AuthenticationMessage
    {
        $this->validateString($rawMessage->getData(), 'token');
        return new AuthenticationMessage($rawMessage->getSender(), $rawMessage->getData()['token']);
    }
}