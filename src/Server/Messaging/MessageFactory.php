<?php
namespace Volantus\FlightBase\Src\Server\Messaging;

use Assert\Assertion;
use Volantus\FlightBase\Src\Server\Network\NetworkRawMessage;

/**
 * Class MessageFactory
 * @package Volantus\FlightBase\Src\Server\Messaging
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
     * @param array      $data
     * @param string|int $key
     */
    protected function validateString(array $data, $key)
    {
        if (!isset($data[$key])) {
            throw new \InvalidArgumentException('Invalid ' . $this->type . ' message: ' . $key . ' key is missing');
        }

        if (!is_string($data[$key])) {
            throw new \InvalidArgumentException('Invalid ' . $this->type . ' message: value of key ' . $key . ' is not a string');
        }
    }

    /**
     * @param array $data
     * @param string $key
     */
    protected function validateNumeric(array $data, string $key)
    {
        if (!isset($data[$key])) {
            throw new \InvalidArgumentException('Invalid ' . $this->type . ' message: ' . $key . ' key is missing');
        }

        if (!is_numeric($data[$key])) {
            throw new \InvalidArgumentException('Invalid ' . $this->type . ' message: value of key ' . $key . ' is not numeric');
        }
    }

    /**
     * @param array $data
     * @param string $key
     */
    protected function validateBool(array $data, string $key)
    {
        if (!isset($data[$key])) {
            throw new \InvalidArgumentException('Invalid ' . $this->type . ' message: ' . $key . ' key is missing');
        }

        if (!is_bool($data[$key])) {
            throw new \InvalidArgumentException('Invalid ' . $this->type . ' message: value of key ' . $key . ' is not bool');
        }
    }


    /**
     * @param array      $data
     * @param string|int $key
     */
    protected function validateArray(array $data, $key)
    {
        if (!isset($data[$key])) {
            throw new \InvalidArgumentException('Invalid ' . $this->type . ' message: ' . $key . ' key is missing');
        }

        if (!is_array($data[$key])) {
            throw new \InvalidArgumentException('Invalid ' . $this->type . ' message: value of key ' . $key . ' is not an array');
        }
    }
}