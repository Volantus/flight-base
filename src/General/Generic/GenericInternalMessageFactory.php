<?php
namespace Volantus\FlightBase\Src\General\Generic;

use Volantus\FlightBase\Src\Server\Messaging\IncomingMessage;
use Volantus\FlightBase\Src\Server\Messaging\MessageFactory;
use Volantus\FlightBase\Src\Server\Network\NetworkRawMessage;

/**
 * Class GenericInternalMessageFactory
 *
 * @package Volantus\FlightBase\Src\General\Generic
 */
class GenericInternalMessageFactory extends MessageFactory
{
    /**
     * @var string
     */
    protected $type = GenericInternalMessage::TYPE;

    /**
     * @param NetworkRawMessage $rawMessage
     *
     * @return IncomingMessage
     */
    public function create(NetworkRawMessage $rawMessage): IncomingMessage
    {
        $data = $rawMessage->getData();
        $this->validateString($data, 0);

        $payload = @unserialize($data[0]);
        if ($payload !== false) {
            if (is_object($payload)) {
                return new IncomingGenericInternalMessage($rawMessage->getSender(), $payload);
            } else {
                throw new \InvalidArgumentException('Unserialized payload is not an object => ' . var_export($payload, true));
            }
        } else {
            throw new \InvalidArgumentException('Generic message payload is not unserializeable. Data: ' . $data[0]);
        }
    }
}