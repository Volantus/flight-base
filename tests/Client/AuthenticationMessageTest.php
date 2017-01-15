<?php
namespace Volante\SkyBukkit\Common\Tests\Client;

use Volante\SkyBukkit\Common\Src\Client\AuthenticationMessage;
use Volante\SkyBukkit\Common\Src\General\Network\BaseRawMessage;

/**
 * Class AuthenticationMessageTest
 * @package Volante\SkyBukkit\Common\Tests\Client
 */
class AuthenticationMessageTest extends \PHPUnit_Framework_TestCase
{
    public function test_toRawMessage_correct()
    {
        $message = new AuthenticationMessage('correctToken');
        $rawMessage = $message->toRawMessage();

        self::assertInstanceOf(BaseRawMessage::class, $rawMessage);
        self::assertEquals('authentication', $rawMessage->getType());
        self::assertEquals('Authentication' , $rawMessage->getTitle());
        self::assertEquals(['token' => 'correctToken'], $rawMessage->getData());
    }
}