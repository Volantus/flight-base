<?php
namespace Volante\SkyBukkit\Common\Src\Server\Messaging;

use Assert\Assertion;
use Volante\SkyBukkit\Common\Src\Server\Network\NetworkRawMessage;

/**
 * Class MessageFactory
 * @package Volante\SkyBukkit\Common\Src\Server\Messaging
 */
abstract class MessageFactory
{
    /**
     * @var string
     */
    protected $type = 'notDefined';

    abstract public function create(NetworkRawMessage $rawMessage) : IncomingMessage;

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param array $data
     * @param string $key
     */
    protected function validateString(array $data, string $key)
    {
        Assertion::keyExists($data, $key, 'Invalid ' . $this->type . ' message: ' . $key . ' key is missing');
        Assertion::string($data[$key], 'Invalid ' . $this->type . ' message: value of key ' . $key . ' is not a string');
    }

    /**
     * @param array $data
     * @param string $key
     */
    protected function validateNumeric(array $data, string $key)
    {
        Assertion::keyExists($data, $key, 'Invalid ' . $this->type . ' message: ' . $key . ' key is missing');
        Assertion::numeric($data[$key], 'Invalid ' . $this->type . ' message: value of key ' . $key . ' is not numeric');
    }

    /**
     * @param array $data
     * @param string $key
     */
    protected function validateArray(array $data, string $key)
    {
        Assertion::keyExists($data, $key, 'Invalid ' . $this->type . ' message: ' . $key . ' key is missing');
        Assertion::isArray($data[$key], 'Invalid ' . $this->type . ' message: value of key ' . $key . ' is not an array');
    }
}