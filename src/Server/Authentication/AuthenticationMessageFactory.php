<?php
namespace Volantus\FlightBase\Src\Server\Authentication;

use Volantus\FlightBase\Src\Server\Messaging\IncomingMessage;
use Volantus\FlightBase\Src\Server\Messaging\MessageFactory;
use Volantus\FlightBase\Src\Server\Network\NetworkRawMessage;

/**
 * Class AuthenticationMessageFactory
 * @package Volantus\FlightBase\Src\Server\Authentication
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