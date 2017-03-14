<?php
namespace Volante\SkyBukkit\Common\Tests\General\FlightController;

use Volante\SkyBukkit\Common\Src\General\FlightController\IncomingPIDTuningStatusMessage;
use Volante\SkyBukkit\Common\Src\General\FlightController\PIDTuningStatusCollection;
use Volante\SkyBukkit\Common\Src\General\FlightController\PIDTuningStatusMessageFactory;
use Volante\SkyBukkit\Common\Src\Server\Messaging\IncomingMessage;
use Volante\SkyBukkit\Common\Src\Server\Network\NetworkRawMessage;
use Volante\SkyBukkit\Common\Tests\Server\General\MessageFactoryTestCase;

/**
 * Class PIDTuningStatusMessageFactoryTest
 *
 * @package Volante\SkyBukkit\Common\Tests\General\FlightController
 */
class PIDTuningStatusMessageFactoryTest extends MessageFactoryTestCase
{
    /**
     * @var PIDTuningStatusMessageFactory
     */
    private $factory;

    protected function setUp()
    {
        parent::setUp();
        $this->factory = new PIDTuningStatusMessageFactory();
    }

    /**
     * @return string
     */
    protected function getMessageType(): string
    {
        return PIDTuningStatusCollection::TYPE;
    }

    /**
     * @param NetworkRawMessage $rawMessage
     *
     * @return IncomingPIDTuningStatusMessage|IncomingMessage
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
            'yaw' => ['Kp' => 1.1, 'Ki' => 2.1, 'Kd' => 3.1],
            'roll' => ['Kp' => 1.2, 'Ki' => 2.2, 'Kd' => 3.2],
            'pitch' => ['Kp' => 1.3, 'Ki' => 2.3, 'Kd' => 3.3],
        ];
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

    public function test_create_yawNotArray()
    {
        $this->validateNotArray('yaw');
    }

    public function test_create_pitchNotArray()
    {
        $this->validateNotArray('roll');
    }

    public function test_create_rollNotArray()
    {
        $this->validateNotArray('pitch');
    }

    public function test_create_KpMissing()
    {
        foreach (['yaw', 'pitch', 'roll'] as $type) {
            $this->expectException(\InvalidArgumentException::class);
            $this->expectExceptionMessage('Invalid pidTuningStatus message: Kp key is missing');

            $data = $this->getCorrectMessageData();
            unset($data[$type]['Kp']);

            $this->callFactory($this->getRawMessage($data));
        }
    }

    public function test_create_KiMissing()
    {
        foreach (['yaw', 'pitch', 'roll'] as $type) {
            $this->expectException(\InvalidArgumentException::class);
            $this->expectExceptionMessage('Invalid pidTuningStatus message: Ki key is missing');

            $data = $this->getCorrectMessageData();
            unset($data[$type]['Ki']);

            $this->callFactory($this->getRawMessage($data));
        }
    }

    public function test_create_KdMissing()
    {
        foreach (['yaw', 'pitch', 'roll'] as $type) {
            $this->expectException(\InvalidArgumentException::class);
            $this->expectExceptionMessage('Invalid pidTuningStatus message: Kd key is missing');

            $data = $this->getCorrectMessageData();
            unset($data[$type]['Kd']);

            $this->callFactory($this->getRawMessage($data));
        }
    }

    public function test_create_KpNotNumeric()
    {
        foreach (['yaw', 'pitch', 'roll'] as $type) {
            $this->expectException(\InvalidArgumentException::class);
            $this->expectExceptionMessage('Invalid pidTuningStatus message: value of key Kp is not numeric');

            $data = $this->getCorrectMessageData();
            $data[$type]['Kp'] = 'abc';

            $this->callFactory($this->getRawMessage($data));
        }
    }

    public function test_create_KiNotNumeric()
    {
        foreach (['yaw', 'pitch', 'roll'] as $type) {
            $this->expectException(\InvalidArgumentException::class);
            $this->expectExceptionMessage('Invalid pidTuningStatus message: value of key Ki is not numeric');

            $data = $this->getCorrectMessageData();
            $data[$type]['Ki'] = 'abc';

            $this->callFactory($this->getRawMessage($data));
        }
    }

    public function test_create_KdNotNumeric()
    {
        foreach (['yaw', 'pitch', 'roll'] as $type) {
            $this->expectException(\InvalidArgumentException::class);
            $this->expectExceptionMessage('Invalid pidTuningStatus message: value of key Kd is not numeric');

            $data = $this->getCorrectMessageData();
            $data[$type]['Kd'] = 'abc';

            $this->callFactory($this->getRawMessage($data));
        }
    }

    public function test_create_correct()
    {
        $result = $this->callFactory($this->getRawMessage($this->getCorrectMessageData()));

        self::assertInstanceOf(IncomingPIDTuningStatusMessage::class, $result);
        self::assertEquals(1.1, $result->getStatus()->getYawStatus()->getKp());
        self::assertEquals(2.1, $result->getStatus()->getYawStatus()->getKi());
        self::assertEquals(3.1, $result->getStatus()->getYawStatus()->getKd());

        self::assertEquals(1.2, $result->getStatus()->getRollStatus()->getKp());
        self::assertEquals(2.2, $result->getStatus()->getRollStatus()->getKi());
        self::assertEquals(3.2, $result->getStatus()->getRollStatus()->getKd());

        self::assertEquals(1.3, $result->getStatus()->getPitchStatus()->getKp());
        self::assertEquals(2.3, $result->getStatus()->getPitchStatus()->getKi());
        self::assertEquals(3.3, $result->getStatus()->getPitchStatus()->getKd());
    }
}