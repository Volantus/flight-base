<?php
namespace Volante\SkyBukkit\Common\Tests\Network;

use Volante\SkyBukkit\Common\Src\Network\RawMessage;

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

        $message = new RawMessage($expected['type'], $expected['title'], $expected['data']);
        self::assertEquals($expected, $message->jsonSerialize());
    }
}