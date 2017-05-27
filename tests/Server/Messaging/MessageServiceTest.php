<?php
namespace Volantus\FlightBase\Tests\Server\Messaging;

use Volantus\FlightBase\Src\General\FlightController\IncomingPIDFrequencyStatus;
use Volantus\FlightBase\Src\General\FlightController\IncomingPIDTuningStatusMessage;
use Volantus\FlightBase\Src\General\FlightController\IncomingPIDTuningUpdateMessage;
use Volantus\FlightBase\Src\General\FlightController\PIDFrequencyStatus;
use Volantus\FlightBase\Src\General\FlightController\PIDFrequencyStatusMessageFactory;
use Volantus\FlightBase\Src\General\FlightController\PIDTuningStatus;
use Volantus\FlightBase\Src\General\FlightController\PIDTuningStatusCollection;
use Volantus\FlightBase\Src\General\FlightController\PIDTuningStatusMessageFactory;
use Volantus\FlightBase\Src\General\FlightController\PIDTuningUpdateCollection;
use Volantus\FlightBase\Src\General\FlightController\PIDTuningUpdateMessageFactory;
use Volantus\FlightBase\Src\General\Generic\GenericInternalMessage;
use Volantus\FlightBase\Src\General\Generic\GenericInternalMessageFactory;
use Volantus\FlightBase\Src\General\Generic\IncomingGenericInternalMessage;
use Volantus\FlightBase\Src\General\GeoPosition\GeoPosition;
use Volantus\FlightBase\Src\General\GeoPosition\GeoPositionMessageFactory;
use Volantus\FlightBase\Src\General\GeoPosition\IncomingGeoPositionMessage;
use Volantus\FlightBase\Src\General\GyroStatus\GyroStatus;
use Volantus\FlightBase\Src\General\GyroStatus\GyroStatusMessageFactory;
use Volantus\FlightBase\Src\General\GyroStatus\IncomingGyroStatusMessage;
use Volantus\FlightBase\Src\General\Motor\IncomingMotorControlMessage;
use Volantus\FlightBase\Src\General\Motor\IncomingMotorStatusMessage;
use Volantus\FlightBase\Src\General\Motor\Motor;
use Volantus\FlightBase\Src\General\Motor\MotorControlMessage;
use Volantus\FlightBase\Src\General\Motor\MotorControlMessageFactory;
use Volantus\FlightBase\Src\General\Motor\MotorStatus;
use Volantus\FlightBase\Src\General\Motor\MotorStatusMessageFactory;
use Volantus\FlightBase\Src\Server\Authentication\AuthenticationMessage;
use Volantus\FlightBase\Src\Server\Authentication\AuthenticationMessageFactory;
use Volantus\FlightBase\Src\Server\Messaging\MessageService;
use Volantus\FlightBase\Src\Server\Network\Client;
use Volantus\FlightBase\Src\Server\Network\NetworkRawMessage;
use Volantus\FlightBase\Src\Server\Network\RawMessageFactory;
use Volantus\FlightBase\Src\Server\Role\IntroductionMessage;
use Volantus\FlightBase\Src\Server\Role\IntroductionMessageFactory;
use Volantus\FlightBase\Tests\Server\General\DummyConnection;

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
     * @var PIDTuningStatusMessageFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $pidTuningStatusMessageFactory;

    /**
     * @var PIDTuningUpdateMessageFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $pidTuningUpdateMessageFactory;

    /**
     * @var GenericInternalMessageFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $genericInternalMessageFactory;

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
        $this->pidTuningStatusMessageFactory = $this->getMockBuilder(PIDTuningStatusMessageFactory::class)->setMethods(['create'])->disableOriginalConstructor()->getMock();
        $this->pidTuningUpdateMessageFactory = $this->getMockBuilder(PIDTuningUpdateMessageFactory::class)->setMethods(['create'])->disableOriginalConstructor()->getMock();
        $this->genericInternalMessageFactory = $this->getMockBuilder(GenericInternalMessageFactory::class)->setMethods(['create'])->disableOriginalConstructor()->getMock();

        $this->service = $this->createService();
    }

    /**
     * @return MessageService
     */
    protected function createService() : MessageService
    {
        return new MessageService($this->rawMessageFactory, $this->introductionMessageFactory, $this->authenticationMessageFactory, $this->geoPositionMessageFactory, $this->gyroStatusMessageFactory, $this->motorStatusMessageFactory, $this->PIDFrequencyStatusMessageFactory, $this->motorControlMessageFactory, $this->pidTuningStatusMessageFactory, $this->pidTuningUpdateMessageFactory, $this->genericInternalMessageFactory);
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
        $expected = new IncomingMotorControlMessage($this->sender, new MotorControlMessage(new GyroStatus(1, 2, 3), 0.3, 0.5, true));

        $this->rawMessageFactory->expects(self::once())
            ->method('create')
            ->with($this->sender, 'correct')
            ->willReturn($rawMessage);
        $this->motorControlMessageFactory->expects(self::once())->method('create')->willReturn($expected);

        $result = $this->service->handle($this->sender, 'correct');

        self::assertInstanceOf(IncomingMotorControlMessage::class, $result);
        self::assertSame($expected, $result);
    }

    public function test_handle_pidTuningStatusCorrect()
    {
        $rawMessage = new NetworkRawMessage($this->sender, PIDTuningStatusCollection::TYPE, 'test', []);
        $expected = new IncomingPIDTuningStatusMessage($this->sender, new PIDTuningStatusCollection(new PIDTuningStatus(1, 2, 3), new PIDTuningStatus(1, 2, 3), new PIDTuningStatus(1, 2, 3)));

        $this->rawMessageFactory->expects(self::once())
            ->method('create')
            ->with($this->sender, 'correct')
            ->willReturn($rawMessage);
        $this->pidTuningStatusMessageFactory->expects(self::once())->method('create')->willReturn($expected);

        $result = $this->service->handle($this->sender, 'correct');

        self::assertInstanceOf(IncomingPIDTuningStatusMessage::class, $result);
        self::assertSame($expected, $result);
    }

    public function test_handle_pidTuningUpdateCorrect()
    {
        $rawMessage = new NetworkRawMessage($this->sender, PIDTuningUpdateCollection::TYPE, 'test', []);
        $expected = new IncomingPIDTuningUpdateMessage($this->sender, new PIDTuningUpdateCollection(new PIDTuningStatus(1, 2, 3), new PIDTuningStatus(1, 2, 3), new PIDTuningStatus(1, 2, 3)));

        $this->rawMessageFactory->expects(self::once())
            ->method('create')
            ->with($this->sender, 'correct')
            ->willReturn($rawMessage);
        $this->pidTuningUpdateMessageFactory->expects(self::once())->method('create')->willReturn($expected);

        $result = $this->service->handle($this->sender, 'correct');

        self::assertInstanceOf(IncomingPIDTuningUpdateMessage::class, $result);
        self::assertSame($expected, $result);
    }

    public function test_handle_genericInternalMessage()
    {
        $payload = new \stdClass();
        $payload->firstProperty = 'correctValue';

        $rawMessage = new NetworkRawMessage($this->sender, GenericInternalMessage::TYPE, 'test', [serialize($payload)]);
        $expected = new IncomingGenericInternalMessage($this->sender, $payload);

        $this->rawMessageFactory->expects(self::once())
            ->method('create')
            ->with($this->sender, 'correct')
            ->willReturn($rawMessage);
        $this->genericInternalMessageFactory->expects(self::once())->method('create')->willReturn($expected);

        $result = $this->service->handle($this->sender, 'correct');

        self::assertInstanceOf(IncomingGenericInternalMessage::class, $result);
        self::assertSame($expected, $result);
    }
}