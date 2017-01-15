<?php
namespace Volante\SkyBukkit\Common\Tests\General\GeoPosition;

use Volante\SkyBukkit\Common\Src\General\GeoPosition\GeoPosition;
use Volante\SkyBukkit\Common\Src\General\GeoPosition\GeoPositionMessageFactory;
use Volante\SkyBukkit\Common\Src\General\GeoPosition\GeoPositionMessageService;
use Volante\SkyBukkit\Common\Src\General\GeoPosition\IncomingGeoPositionMessage;
use Volante\SkyBukkit\Common\Src\Server\Authentication\AuthenticationMessageFactory;
use Volante\SkyBukkit\Common\Src\Server\Messaging\Sender;
use Volante\SkyBukkit\Common\Src\Server\Network\NetworkRawMessage;
use Volante\SkyBukkit\Common\Src\Server\Network\RawMessageFactory;
use Volante\SkyBukkit\Common\Src\Server\Role\IntroductionMessageFactory;

/**
 * Class GeoPositionMessageServiceTest
 * @package Volante\SkyBukkit\Common\Tests\General\GeoPosition
 */
class GeoPositionMessageServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var GeoPositionMessageService
     */
    private $service;

    /**
     * @var RawMessageFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    private $rawMessageFactory;

    /**
     * @var IntroductionMessageFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    private $introductionMessageFactory;

    /**
     * @var AuthenticationMessageFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    private $authenticationMessageFactory;

    /**
     * @var GeoPositionMessageFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    private $geoPositionMessageFactory;

    /**
     * @var Sender
     */
    private $sender;

    protected function setUp()
    {
        $this->rawMessageFactory = $this->getMockBuilder(RawMessageFactory::class)->disableOriginalConstructor()->getMock();
        $this->introductionMessageFactory = $this->getMockBuilder(IntroductionMessageFactory::class)->setMethods(['create'])->disableOriginalConstructor()->getMock();
        $this->authenticationMessageFactory = $this->getMockBuilder(AuthenticationMessageFactory::class)->setMethods(['create'])->disableOriginalConstructor()->getMock();
        $this->geoPositionMessageFactory = $this->getMockBuilder(GeoPositionMessageFactory::class)->setMethods(['create'])->disableOriginalConstructor()->getMock();
        $this->sender = $this->getMockBuilder(Sender::class)->getMock();

        $this->service = new GeoPositionMessageService($this->rawMessageFactory, $this->introductionMessageFactory, $this->authenticationMessageFactory, $this->geoPositionMessageFactory);
    }

    public function test_handle_geoPositionMessageHandledCorrectly()
    {
        $rawMessage = new NetworkRawMessage($this->sender, GeoPosition::TYPE, 'test', []);
        $expected = new IncomingGeoPositionMessage($this->sender, new GeoPosition(1, 2, 3));

        $this->rawMessageFactory->expects(self::once())
            ->method('create')
            ->with($this->sender, 'correct')
            ->willReturn($rawMessage);
        $this->geoPositionMessageFactory->expects(self::once())->method('create')->willReturn($expected);

        $result = $this->service->handle($this->sender, 'correct');

        self::assertInstanceOf(IncomingGeoPositionMessage::class, $result);
        self::assertSame($expected, $result);
    }
}