<?php
namespace Volantus\FlightBase\Tests\General\Network;

use Volantus\FlightBase\Src\General\Network\BaseRawMessage;

/**
 * Class MessageTest
 * @package Volante\SkyBukkit\Monitor\Tests\Message
 */
class MessageTest extends \PHPUnit_Framework_TestCase
{
    public function test_jsonSerialize()
    {
        $expected = [
            'type' => 'testMessage',
            'title' => 'This is a test',
            'data' => [
                'sub01' => [1, 2, 3],
                'sub02' => [4, 5, 6]
            ]
        ];

        $message = new BaseRawMessage($expected['type'], $expected['title'], $expected['data']);
        self::assertEquals($expected, $message->jsonSerialize());
    }
}