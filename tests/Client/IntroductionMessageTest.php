<?php
namespace Volante\SkyBukkit\Common\Tests\Client;

use Volante\SkyBukkit\Common\Src\Client\IntroductionMessage;
use Volante\SkyBukkit\Common\Src\General\Network\RawMessage;
use Volante\SkyBukkit\Common\Src\General\Role\ClientRole;

/**
 * Class IntroductionMessageTest
 * @package Volante\SkyBukkit\Common\Tests\Client\Role
 */
class IntroductionMessageTest extends \PHPUnit_Framework_TestCase
{
    public function test_toRawMessage_correct()
    {
        $message = new IntroductionMessage(ClientRole::OPERATOR);
        $rawMessage = $message->toRawMessage();

        self::assertInstanceOf(RawMessage::class, $rawMessage);
        self::assertEquals('introduction', $rawMessage->getType());
        self::assertEquals('Introduction' , $rawMessage->getTitle());
        self::assertEquals(['role' => ClientRole::OPERATOR], $rawMessage->getData());
    }
}