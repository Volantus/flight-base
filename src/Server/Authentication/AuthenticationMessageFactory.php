<?php
namespace Volante\SkyBukkit\Common\Src\Server\Authentication;

use Volante\SkyBukkit\Common\Src\Server\Messaging\IncomingMessage;
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
     * @return AuthenticationMessage|IncomingMessage
     */
    public function create(RawMessage $rawMessage) : IncomingMessage
    {
        $this->validateString($rawMessage->getData(), 'token');
        return new AuthenticationMessage($rawMessage->getSender(), $rawMessage->getData()['token']);
    }
}