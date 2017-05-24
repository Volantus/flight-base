<?php
namespace Volantus\FlightBase\Tests\Server\Authentication;

use Volantus\FlightBase\Src\Server\Authentication\AuthenticationMessage;
use Volantus\FlightBase\Src\Server\Authentication\AuthenticationMessageFactory;
use Volantus\FlightBase\Src\Server\Messaging\IncomingMessage;
use Volantus\FlightBase\Src\Server\Network\NetworkRawMessage;
use Volantus\FlightBase\Tests\Server\General\MessageFactoryTestCase;

/**
 * Class AuthenticationMessageFactoryTest
 * @package Volantus\FlightBase\Tests\Server\Authentication
 */
class AuthenticationMessageFactoryTest extends MessageFactoryTestCase
{
    /**
     * @var AuthenticationMessageFactory
     */
    private $factory;

    protected function setUp()
    {
        parent::setUp();
        $this->factory = new AuthenticationMessageFactory();
    }

    public function test_create_tokenMissing()
    {
        $this->validateMissingKey('token');
    }

    public function test_create_tokenNoString()
    {
        $this->validateNotString('token');
    }

    public function test_create_messageCorrect()
    {
        $message = $this->getRawMessage($this->getCorrectMessageData());
        $result = $this->factory->create($message);

        self::assertInstanceOf(AuthenticationMessage::class, $result);
        self::assertEquals('correctToken', $result->getToken());
    }

    /**
     * @return string
     */
    protected function getMessageType(): string
    {
        return AuthenticationMessage::TYPE;
    }

    /**
     * @param NetworkRawMessage $rawMessage
     * @return mixed
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
        return ['token' => 'correctToken'];
    }
}