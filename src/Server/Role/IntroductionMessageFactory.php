<?php
namespace Volantus\FlightBase\Src\Server\Role;

use Assert\Assertion;
use Volantus\FlightBase\Src\General\Role\ClientRole;
use Volantus\FlightBase\Src\Server\Messaging\IncomingMessage;
use Volantus\FlightBase\Src\Server\Messaging\MessageFactory;
use Volantus\FlightBase\Src\Server\Network\NetworkRawMessage;

/**
 * Class IntroductionMessageFactory
 * @package Volantus\FlightBase\Src\Server\Role
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

        if (!in_array($data['role'], ClientRole::getSupportedRoles())) {
            throw new \InvalidArgumentException('Invalid ' . IntroductionMessage::TYPE . ' message: given role is not supported');
        }
    }
}