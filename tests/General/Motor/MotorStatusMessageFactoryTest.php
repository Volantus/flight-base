<?php
namespace Volantus\FlightBase\Tests\General\Motor\FlightControllerTest;

use Volantus\FlightBase\Src\General\Motor\IncomingMotorStatusMessage;
use Volantus\FlightBase\Src\General\Motor\Motor;
use Volantus\FlightBase\Src\General\Motor\MotorStatus;
use Volantus\FlightBase\Src\General\Motor\MotorStatusMessageFactory;
use Volantus\FlightBase\Src\Server\Messaging\IncomingMessage;
use Volantus\FlightBase\Src\Server\Network\NetworkRawMessage;
use Volantus\FlightBase\Tests\Server\General\MessageFactoryTestCase;

/**
 * Class MotorStatusMessageFactoryTest
 *
 * @package Volantus\FlightBase\Tests\General\Motor\FlightControllerTest
 */
class MotorStatusMessageFactoryTest extends MessageFactoryTestCase
{
    /**
     * @var MotorStatusMessageFactory
     */
    private $factory;

    /**
     * @var Motor[]
     */
    private $motors;

    protected function setUp()
    {
        parent::setUp();
        $this->motors = [
            new Motor(1, Motor::ZERO_LEVEL, 5),
            new Motor(2, Motor::FULL_LEVEL, 22)
        ];

        $this->factory = new MotorStatusMessageFactory();
    }

    public function test_create_motorsKeyMissing()
    {
        $this->validateMissingKey('motors');
    }

    public function test_create_motorsNotArray()
    {
        $this->validateNotArray('motors');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid motorStatus message: id key is missing
     */
    public function test_create_motorIdMissing()
    {
        $data = $this->getCorrectMessageData();
        unset($data['motors'][0]['id']);

        $this->callFactory($this->getRawMessage($data));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid motorStatus message: power key is missing
     */
    public function test_create_motorPowerMissing()
    {
        $data = $this->getCorrectMessageData();
        unset($data['motors'][0]['power']);

        $this->callFactory($this->getRawMessage($data));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid motorStatus message: pin key is missing
     */
    public function test_create_motorPinMissing()
    {
        $data = $this->getCorrectMessageData();
        unset($data['motors'][0]['pin']);

        $this->callFactory($this->getRawMessage($data));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid motorStatus message: value of key id is not numeric
     */
    public function test_create_motorIdNotNumeric()
    {
        $data = $this->getCorrectMessageData();
        $data['motors'][0]['id'] = 'abc';

        $this->callFactory($this->getRawMessage($data));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid motorStatus message: value of key pin is not numeric
     */
    public function test_create_motorPinNotNumeric()
    {
        $data = $this->getCorrectMessageData();
        $data['motors'][0]['pin'] = 'abc';

        $this->callFactory($this->getRawMessage($data));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid motorStatus message: value of key power is not numeric
     */
    public function test_create_motorPowerNotNumeric()
    {
        $data = $this->getCorrectMessageData();
        $data['motors'][0]['power'] = 'abc';

        $this->callFactory($this->getRawMessage($data));
    }

    public function test_create_correct()
    {
        /** @var IncomingMotorStatusMessage $result */
        $result = $this->callFactory($this->getRawMessage($this->getCorrectMessageData()));

        self::assertInstanceOf(IncomingMotorStatusMessage::class, $result);
        self::assertInstanceOf(MotorStatus::class, $result->getMotorStatus());
        self::assertCount(2, $result->getMotorStatus()->getMotors());
        self::assertEquals($this->motors, $result->getMotorStatus()->getMotors());
    }

    /**
     * @return string
     */
    protected function getMessageType(): string
    {
        return MotorStatus::TYPE;
    }

    /**
     * @param NetworkRawMessage $rawMessage
     *
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
        return ['motors' => [
            $this->motors[0]->jsonSerialize(),
            $this->motors[1]->jsonSerialize()
        ]];
    }
}