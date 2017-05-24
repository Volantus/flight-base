<?php
namespace Volantus\FlightBase\Tests\Client;

use Volantus\FlightBase\Src\Client\AuthenticationMessage;
use Volantus\FlightBase\Src\General\Network\BaseRawMessage;

/**
 * Class AuthenticationMessageTest
 * @package Volantus\FlightBase\Tests\Client
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