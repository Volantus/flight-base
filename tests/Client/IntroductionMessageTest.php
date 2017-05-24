<?php
namespace Volantus\FlightBase\Tests\Client;

use Volantus\FlightBase\Src\Client\IntroductionMessage;
use Volantus\FlightBase\Src\General\Network\BaseRawMessage;
use Volantus\FlightBase\Src\General\Role\ClientRole;

/**
 * Class IntroductionMessageTest
 * @package Volantus\FlightBase\Tests\Client\Role
 */
class IntroductionMessageTest extends \PHPUnit_Framework_TestCase
{
    public function test_toRawMessage_correct()
    {
        $message = new IntroductionMessage(ClientRole::OPERATOR);
        $rawMessage = $message->toRawMessage();

        self::assertInstanceOf(BaseRawMessage::class, $rawMessage);
        self::assertEquals('introduction', $rawMessage->getType());
        self::assertEquals('Introduction' , $rawMessage->getTitle());
        self::assertEquals(['role' => ClientRole::OPERATOR], $rawMessage->getData());
    }
}