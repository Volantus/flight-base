<?php
namespace Volante\SkyBukkit\Common\Tests\Server\General;

use Volante\SkyBukkit\Common\Src\Server\Messaging\IncomingMessage;
use Volante\SkyBukkit\Common\Src\Server\Network\Client;
use Volante\SkyBukkit\Common\Src\Server\Network\NetworkRawMessage;

/**
 * Class MessageFactoryTestCase
 * @package Volante\SkyBukkit\Common\Tests\Server\General
 */
abstract class MessageFactoryTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Client
     */
    protected $client;

    protected function setUp()
    {
       $this->client = new Client(1, new DummyConnection(), -1);
    }

    /**
     * @return string
     */
    abstract protected function getMessageType() : string;

    /**
     * @param NetworkRawMessage $rawMessage
     * @return mixed
     */
    abstract protected function callFactory(NetworkRawMessage $rawMessage) : IncomingMessage;

    /**
     * @return array
     */
    abstract protected function getCorrectMessageData() : array;

    /**
     * @param string $key
     */
    protected function validateMissingKey(string $key)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid ' . $this->getMessageType() . ' message: ' . $key . ' key is missing');

        $data = $this->getCorrectMessageData();
        unset($data[$key]);
        $message = $this->getRawMessage($data);
        $this->callFactory($message);
    }

    /**
     * @param string $key
     */
    protected function validateNotNumeric(string $key)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid ' . $this->getMessageType() . ' message: value of key ' . $key . ' is not numeric');

        $data = $this->getCorrectMessageData();
        $data[$key] = 'abc';
        $message = $this->getRawMessage($data);
        $this->callFactory($message);
    }

    /**
     * @param string $key
     */
    protected function validateNotBool(string $key)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid ' . $this->getMessageType() . ' message: value of key ' . $key . ' is not bool');

        $data = $this->getCorrectMessageData();
        $data[$key] = 'abc';
        $message = $this->getRawMessage($data);
        $this->callFactory($message);
    }


    /**
     * @param string $key
     */
    protected function validateNotString(string $key)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid ' . $this->getMessageType() . ' message: value of key ' . $key . ' is not a string');

        $data = $this->getCorrectMessageData();
        $data[$key] = [];
        $message = $this->getRawMessage($data);
        $this->callFactory($message);
    }

    /**
     * @param string $key
     */
    protected function validateNotArray(string $key)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid ' . $this->getMessageType() . ' message: value of key ' . $key . ' is not an array');

        $data = $this->getCorrectMessageData();
        $data[$key] = 'abc';
        $message = $this->getRawMessage($data);
        $this->callFactory($message);
    }

    /**
     * @param array $data
     * @return NetworkRawMessage
     */
    protected function getRawMessage(array $data) : NetworkRawMessage
    {
        return new NetworkRawMessage($this->client, $this->getMessageType(), 'Dummy message', $data);
    }
}