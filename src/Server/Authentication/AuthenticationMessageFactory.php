<?php
namespace Volante\SkyBukkit\Common\Src\Server\Authentication;

use Volante\SkyBukkit\Common\Src\Server\Messaging\IncomingMessage;
use Volante\SkyBukkit\Common\Src\Server\Messaging\MessageFactory;
use Volante\SkyBukkit\Common\Src\Server\Network\NetworkRawMessage;

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
     * @param NetworkRawMessage $rawMessage
     * @return AuthenticationMessage|IncomingMessage
     */
    public function create(NetworkRawMessage $rawMessage) : IncomingMessage
    {
        $this->validateString($rawMessage->getData(), 'token');
        return new AuthenticationMessage($rawMessage->getSender(), $rawMessage->getData()['token']);
    }
}