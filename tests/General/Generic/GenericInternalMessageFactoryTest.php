<?php
namespace Volantus\FlightBase\Tests\General\Generic;

use Volantus\FlightBase\Src\General\Generic\GenericInternalMessage;
use Volantus\FlightBase\Src\General\Generic\GenericInternalMessageFactory;
use Volantus\FlightBase\Src\General\Generic\IncomingGenericInternalMessage;
use Volantus\FlightBase\Src\Server\Messaging\IncomingMessage;
use Volantus\FlightBase\Src\Server\Network\NetworkRawMessage;
use Volantus\FlightBase\Tests\Server\General\MessageFactoryTestCase;

/**
 * Class GenericInternalMessageFactoryTest
 *
 * @package Volantus\FlightBase\Tests\General\Generic
 */
class GenericInternalMessageFactoryTest extends MessageFactoryTestCase
{
    /**
     * @var GenericInternalMessageFactory
     */
    private $factory;

    protected function setUp()
    {
        parent::setUp();
        $this->factory = new GenericInternalMessageFactory();
    }

    /**
     * @return string
     */
    protected function getMessageType(): string
    {
        return GenericInternalMessage::TYPE;
    }

    /**
     * @param NetworkRawMessage $rawMessage
     *
     * @return IncomingGenericInternalMessage|IncomingMessage
     */
    protected function callFactory(NetworkRawMessage $rawMessage): IncomingMessage
    {
        return $this->factory->create($rawMessage);
    }

    /**
     * @return array
     */
    protected function getCorrectMessageData(): array
    {
        $payload = new \stdClass();
        $payload->firstProperty = 'correctValue';
        return [serialize($payload)];
    }

    public function test_create_missingKey()
    {
        $this->validateMissingKey(0);
    }

    public function test_create_notString()
    {
        $this->validateNotString(0);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Generic message payload is not unserializeable. Data: abc
     */
    public function test_create_payloadIsUnserializeable()
    {
        $data = ['abc'];
        $message = $this->getRawMessage($data);
        $this->callFactory($message);
    }


    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Unserialized payload is not an object => array (
     */
    public function test_create_payloadIsNotAnObject()
    {
        $data = [serialize(['a', 'b', 'c'])];
        $message = $this->getRawMessage($data);
        $this->callFactory($message);
    }

    public function test_create_correct()
    {
        $expectedPayload = new \stdClass();
        $expectedPayload->firstProperty = 'correctValue';

        $message = $this->getRawMessage($this->getCorrectMessageData());
        $result = $this->callFactory($message);

        self::assertInstanceOf(IncomingGenericInternalMessage::class, $result);
        self::assertEquals($expectedPayload, $result->getPayload());
    }
}