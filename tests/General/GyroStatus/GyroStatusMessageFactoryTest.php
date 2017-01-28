<?php
namespace Volante\SkyBukkit\Common\Tests\General\GyroStatus;

use Volante\SkyBukkit\Common\Src\General\GyroStatus\GyroStatus;
use Volante\SkyBukkit\Common\Src\General\GyroStatus\GyroStatusMessageFactory;
use Volante\SkyBukkit\Common\Src\General\GyroStatus\IncomingGyroStatusMessage;
use Volante\SkyBukkit\Common\Src\Server\Messaging\IncomingMessage;
use Volante\SkyBukkit\Common\Src\Server\Network\NetworkRawMessage;
use Volante\SkyBukkit\Common\Tests\Server\General\MessageFactoryTestCase;

/**
 * Class GyroStatusMessageFactoryTest
 *
 * @package Volante\SkyBukkit\Common\Tests\General\GyroStatus
 */
class GyroStatusMessageFactoryTest extends MessageFactoryTestCase
{
    /**
     * @var GyroStatusMessageFactory
     */
    private $factory;

    protected function setUp()
    {
        parent::setUp();
        $this->factory = new GyroStatusMessageFactory();
    }

    public function test_create_yawMissing()
    {
        $this->validateMissingKey('yaw');
    }

    public function test_create_rollMissing()
    {
        $this->validateMissingKey('roll');
    }

    public function test_create_pitchMissing()
    {
        $this->validateMissingKey('pitch');
    }

    public function test_create_latitudeNotNumeric()
    {
        $this->validateNotNumeric('yaw');
    }

    public function test_create_rollNotNumeric()
    {
        $this->validateNotNumeric('roll');
    }

    public function test_create_pitchNotNumeric()
    {
        $this->validateNotNumeric('pitch');
    }

    public function test_create_correct()
    {
        $message = $this->getRawMessage($this->getCorrectMessageData());
        $result = $this->factory->create($message);

        self::assertInstanceOf(IncomingGyroStatusMessage::class, $result);
        self::assertEquals(10.123991, $result->getGyroStatus()->getYaw());
        self::assertEquals(40.123123, $result->getGyroStatus()->getPitch());
        self::assertEquals(180.13, $result->getGyroStatus()->getRoll());
    }

    /**
     * @return string
     */
    protected function getMessageType(): string
    {
        return GyroStatus::TYPE;
    }

    /**
     * @param NetworkRawMessage $rawMessage
     * @return mixed
     */
    protected function callFactory(NetworkRawMessage $rawMessage): IncomingMessage
    {
        return $this->factory->create($rawMessage);
    }

    /**
     * @return array
     */
    protected function getCorrectMessageData(): array
    {
        return [
            'yaw'   => 10.123991,
            'pitch' => 40.123123,
            'roll'  => 180.13
        ];
    }
}