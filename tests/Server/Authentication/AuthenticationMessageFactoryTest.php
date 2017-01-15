<?php
namespace Volante\SkyBukkit\Common\Tests\Server\Authentication;

use Volante\SkyBukkit\Common\Src\Server\Authentication\AuthenticationMessage;
use Volante\SkyBukkit\Common\Src\Server\Authentication\AuthenticationMessageFactory;
use Volante\SkyBukkit\Common\Src\Server\Messaging\IncomingMessage;
use Volante\SkyBukkit\Common\Src\Server\Network\RawMessage;
use Volante\SkyBukkit\Common\Tests\Server\General\MessageFactoryTestCase;

/**
 * Class AuthenticationMessageFactoryTest
 * @package Volante\SkyBukkit\Common\Tests\Server\Authentication
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
     * @param RawMessage $rawMessage
     * @return mixed
     */
    protected function callFactory(RawMessage $rawMessage): IncomingMessage
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