<?php
namespace Volante\SkyBukkit\Common\Tests\General\GeoPosition;

use Volante\SkyBukkit\Common\Src\General\GeoPosition\GeoPosition;
use Volante\SkyBukkit\Common\Src\General\Network\BaseRawMessage;

/**
 * Class GeoPositionTest
 *
 * @package Volante\SkyBukkit\GeoPositionService\Tests\GeoPosition
 */
class GeoPositionTest extends \PHPUnit_Framework_TestCase
{
    public function test_toRawMessage_correct()
    {
        $expected = [
            'latitude'  => 30.1001711,
            'longitude' => 50.7974963,
            'altitude'  => 512.15
        ];

        $geoPosition = new GeoPosition($expected['latitude'], $expected['longitude'], $expected['altitude']);
        $rawMessage = $geoPosition->toRawMessage();

        self::assertInstanceOf(BaseRawMessage::class, $rawMessage);
        self::assertEquals('Geo position', $rawMessage->getTitle());
        self::assertEquals('geoPosition', $rawMessage->getType());
        self::assertEquals($expected, $rawMessage->getData());
    }
}