<?php
namespace Volante\SkyBukkit\Common\Tests\Server\Messaging;

use Volante\SkyBukkit\Common\Src\General\FlightController\IncomingPIDFrequencyStatus;
use Volante\SkyBukkit\Common\Src\General\FlightController\PIDFrequencyStatus;
use Volante\SkyBukkit\Common\Src\General\FlightController\PIDFrequencyStatusMessageFactory;
use Volante\SkyBukkit\Common\Src\General\GeoPosition\GeoPosition;
use Volante\SkyBukkit\Common\Src\General\GeoPosition\GeoPositionMessageFactory;
use Volante\SkyBukkit\Common\Src\General\GeoPosition\IncomingGeoPositionMessage;
use Volante\SkyBukkit\Common\Src\General\GyroStatus\GyroStatus;
use Volante\SkyBukkit\Common\Src\General\GyroStatus\GyroStatusMessageFactory;
use Volante\SkyBukkit\Common\Src\General\GyroStatus\IncomingGyroStatusMessage;
use Volante\SkyBukkit\Common\Src\General\Motor\IncomingMotorControlMessage;
use Volante\SkyBukkit\Common\Src\General\Motor\IncomingMotorStatusMessage;
use Volante\SkyBukkit\Common\Src\General\Motor\Motor;
use Volante\SkyBukkit\Common\Src\General\Motor\MotorControlMessage;
use Volante\SkyBukkit\Common\Src\General\Motor\MotorControlMessageFactory;
use Volante\SkyBukkit\Common\Src\General\Motor\MotorStatus;
use Volante\SkyBukkit\Common\Src\General\Motor\MotorStatusMessageFactory;
use Volante\SkyBukkit\Common\Src\Server\Authentication\AuthenticationMessage;
use Volante\SkyBukkit\Common\Src\Server\Authentication\AuthenticationMessageFactory;
use Volante\SkyBukkit\Common\Src\Server\Messaging\MessageService;
use Volante\SkyBukkit\Common\Src\Server\Network\Client;
use Volante\SkyBukkit\Common\Src\Server\Network\NetworkRawMessage;
use Volante\SkyBukkit\Common\Src\Server\Network\RawMessageFactory;
use Volante\SkyBukkit\Common\Src\Server\Role\IntroductionMessage;
use Volante\SkyBukkit\Common\Src\Server\Role\IntroductionMessageFactory;
use Volante\SkyBukkit\Common\Tests\Server\General\DummyConnection;

/**
 * Class MessageServiceIntegrationTest
 * @package Volante\SkyBukkit\RleayServer\Tests
 */
class MessageServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MessageService
     */
    protected $service;

    /**
     * @var RawMessageFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $rawMessageFactory;

    /**
     * @var IntroductionMessageFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $introductionMessageFactory;

    /**
     * @var AuthenticationMessageFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $authenticationMessageFactory;

    /**
     * @var GeoPositionMessageFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $geoPositionMessageFactory;

    /**
     * @var GyroStatusMessageFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $gyroStatusMessageFactory;

    /**
     * @var MotorStatusMessageFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $motorStatusMessageFactory;

    /**
     * @var PIDFrequencyStatusMessageFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $PIDFrequencyStatusMessageFactory;

    /**
     * @var MotorControlMessageFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $motorControlMessageFactory;

    /**
     * @var Client
     */
    protected $sender;

    protected function setUp()
    {
        $this->sender = new Client(1, new DummyConnection(), -1);
        $this->rawMessageFactory = $this->getMockBuilder(RawMessageFactory::class)->disableOriginalConstructor()->getMock();
        $this->introductionMessageFactory = $this->getMockBuilder(IntroductionMessageFactory::class)->setMethods(['create'])->disableOriginalConstructor()->getMock();
        $this->authenticationMessageFactory = $this->getMockBuilder(AuthenticationMessageFactory::class)->setMethods(['create'])->disableOriginalConstructor()->getMock();
        $this->geoPositionMessageFactory = $this->getMockBuilder(GeoPositionMessageFactory::class)->setMethods(['create'])->disableOriginalConstructor()->getMock();
        $this->gyroStatusMessageFactory = $this->getMockBuilder(GyroStatusMessageFactory::class)->setMethods(['create'])->disableOriginalConstructor()->getMock();
        $this->motorStatusMessageFactory = $this->getMockBuilder(MotorStatusMessageFactory::class)->setMethods(['create'])->disableOriginalConstructor()->getMock();
        $this->PIDFrequencyStatusMessageFactory = $this->getMockBuilder(PIDFrequencyStatusMessageFactory::class)->setMethods(['create'])->disableOriginalConstructor()->getMock();
        $this->motorControlMessageFactory = $this->getMockBuilder(MotorControlMessageFactory::class)->setMethods(['create'])->disableOriginalConstructor()->getMock();

        $this->service = $this->createService();
    }

    /**
     * @return MessageService
     */
    protected function createService() : MessageService
    {
        return new MessageService($this->rawMessageFactory, $this->introductionMessageFactory, $this->authenticationMessageFactory, $this->geoPositionMessageFactory, $this->gyroStatusMessageFactory, $this->motorStatusMessageFactory, $this->PIDFrequencyStatusMessageFactory, $this->motorControlMessageFactory);
    }

    public function test_handle_rawMessageServiceCalled()
    {
        $this->rawMessageFactory->expects(self::once())
            ->method('create')
            ->with($this->sender, 'correct')
            ->willReturn(new NetworkRawMessage($this->sender, IntroductionMessage::TYPE, 'test', []));
        $this->introductionMessageFactory->method('create')->willReturn(new IntroductionMessage($this->sender, 99));

        $this->service->handle($this->sender, 'correct');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Unable to handle message: given type <invalidMessageType> is unknown
     */
    public function test_handle_invalidMessageType()
    {
        $this->rawMessageFactory->expects(self::once())
            ->method('create')
            ->with($this->sender, 'correct')
            ->willReturn(new NetworkRawMessage($this->sender, 'invalidMessageType', 'test', []));

        $this->service->handle($this->sender, 'correct');
    }

    public function test_handle_introductionMessageHandledCorrectly()
    {
        $rawMessage = new NetworkRawMessage($this->sender, IntroductionMessage::TYPE, 'test', []);
        $expected = new IntroductionMessage($this->sender, 99);

        $this->rawMessageFactory->expects(self::once())
            ->method('create')
            ->with($this->sender, 'correct')
            ->willReturn($rawMessage);
        $this->introductionMessageFactory->expects(self::once())->method('create')->willReturn($expected);

        $result = $this->service->handle($this->sender, 'correct');

        self::assertInstanceOf(IntroductionMessage::class, $result);
        self::assertSame($expected, $result);
    }

    public function test_handle_authenticationMessageHandledCorrectly()
    {
        $rawMessage = new NetworkRawMessage($this->sender, AuthenticationMessage::TYPE, 'test', []);
        $expected = new AuthenticationMessage($this->sender, 'correctToken');

        $this->rawMessageFactory->expects(self::once())
            ->method('create')
            ->with($this->sender, 'correct')
            ->willReturn($rawMessage);
        $this->authenticationMessageFactory->expects(self::once())->method('create')->willReturn($expected);

        $result = $this->service->handle($this->sender, 'correct');

        self::assertInstanceOf(AuthenticationMessage::class, $result);
        self::assertSame($expected, $result);
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

    public function test_handle_gyroStatusMessageHandledCorrectly()
    {
        $rawMessage = new NetworkRawMessage($this->sender, GyroStatus::TYPE, 'test', []);
        $expected = new IncomingGyroStatusMessage($this->sender, new GyroStatus(1, 2, 3));

        $this->rawMessageFactory->expects(self::once())
            ->method('create')
            ->with($this->sender, 'correct')
            ->willReturn($rawMessage);
        $this->gyroStatusMessageFactory->expects(self::once())->method('create')->willReturn($expected);

        $result = $this->service->handle($this->sender, 'correct');

        self::assertInstanceOf(IncomingGyroStatusMessage::class, $result);
        self::assertSame($expected, $result);
    }

    public function test_handle_motorStatusMessageHandledCorrectly()
    {
        $rawMessage = new NetworkRawMessage($this->sender, MotorStatus::TYPE, 'test', []);
        $expected = new IncomingMotorStatusMessage($this->sender, new MotorStatus([new Motor(1, Motor::ZERO_LEVEL, 22)]));

        $this->rawMessageFactory->expects(self::once())
            ->method('create')
            ->with($this->sender, 'correct')
            ->willReturn($rawMessage);
        $this->motorStatusMessageFactory->expects(self::once())->method('create')->willReturn($expected);

        $result = $this->service->handle($this->sender, 'correct');

        self::assertInstanceOf(IncomingMotorStatusMessage::class, $result);
        self::assertSame($expected, $result);
    }

    public function test_handle_pidFrequencyStatusCorrectly()
    {
        $rawMessage = new NetworkRawMessage($this->sender, PIDFrequencyStatus::TYPE, 'test', []);
        $expected = new IncomingPIDFrequencyStatus($this->sender, new PIDFrequencyStatus(1000, 950));

        $this->rawMessageFactory->expects(self::once())
            ->method('create')
            ->with($this->sender, 'correct')
            ->willReturn($rawMessage);
        $this->PIDFrequencyStatusMessageFactory->expects(self::once())->method('create')->willReturn($expected);

        $result = $this->service->handle($this->sender, 'correct');

        self::assertInstanceOf(IncomingPIDFrequencyStatus::class, $result);
        self::assertSame($expected, $result);
    }

    public function test_handle_motorControlCorrectly()
    {
        $rawMessage = new NetworkRawMessage($this->sender, MotorControlMessage::TYPE, 'test', []);
        $expected = new IncomingMotorControlMessage($this->sender, new MotorControlMessage(new GyroStatus(1, 2, 3), 0.3, 0.5));

        $this->rawMessageFactory->expects(self::once())
            ->method('create')
            ->with($this->sender, 'correct')
            ->willReturn($rawMessage);
        $this->motorControlMessageFactory->expects(self::once())->method('create')->willReturn($expected);

        $result = $this->service->handle($this->sender, 'correct');

        self::assertInstanceOf(IncomingMotorControlMessage::class, $result);
        self::assertSame($expected, $result);
    }
}