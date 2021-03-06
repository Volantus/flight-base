<?php
namespace Volantus\FlightBase\Tests\General\Motor\FlightControllerTest;

use Volantus\FlightBase\Src\General\Motor\MotorControlMessage;
use Volantus\FlightBase\Src\General\Motor\MotorControlMessageFactory;
use Volantus\FlightBase\Src\Server\Messaging\IncomingMessage;
use Volantus\FlightBase\Src\Server\Network\NetworkRawMessage;
use Volantus\FlightBase\Tests\Server\General\MessageFactoryTestCase;

/**
 * Class MotorControlMessageFactoryTest
 *
 * @package Volantus\FlightBase\Tests\General\Motor\FlightControllerTest
 */
class MotorControlMessageFactoryTest extends MessageFactoryTestCase
{
    /**
     * @var MotorControlMessageFactory
     */
    private $factory;

    protected function setUp()
    {
        parent::setUp();
        $this->factory = new MotorControlMessageFactory();
    }

    public function test_create_desiredPositionMissing()
    {
        $this->validateMissingKey('desiredPosition');
    }

    public function test_create_desiredPositionNotArray()
    {
        $this->validateNotArray('desiredPosition');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid motorControl message: yaw key is missing
     */
    public function test_create_yawMissing()
    {
        $data = $this->getCorrectMessageData();
        unset($data['desiredPosition']['yaw']);

        $this->callFactory($this->getRawMessage($data));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid motorControl message: roll key is missing
     */
    public function test_create_pitchMissing()
    {
        $data = $this->getCorrectMessageData();
        unset($data['desiredPosition']['roll']);

        $this->callFactory($this->getRawMessage($data));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid motorControl message: pitch key is missing
     */
    public function test_create_motorPinMissing()
    {
        $data = $this->getCorrectMessageData();
        unset($data['desiredPosition']['pitch']);

        $this->callFactory($this->getRawMessage($data));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid motorControl message: value of key yaw is not numeric
     */
    public function test_create_motorIdNotNumeric()
    {
        $data = $this->getCorrectMessageData();
        $data['desiredPosition']['yaw'] = 'abc';

        $this->callFactory($this->getRawMessage($data));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid motorControl message: value of key roll is not numeric
     */
    public function test_create_rollNotNumeric()
    {
        $data = $this->getCorrectMessageData();
        $data['desiredPosition']['roll'] = 'abc';

        $this->callFactory($this->getRawMessage($data));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid motorControl message: value of key pitch is not numeric
     */
    public function test_create_pitchNotNumeric()
    {
        $data = $this->getCorrectMessageData();
        $data['desiredPosition']['pitch'] = 'abc';

        $this->callFactory($this->getRawMessage($data));
    }

    public function test_create_horizontalThrottleMissing()
    {
        $this->validateMissingKey('horizontalThrottle');
    }

    public function test_create_verticalThrottleMissing()
    {
        $this->validateMissingKey('verticalThrottle');
    }

    public function test_create_horizontalThrottleNotNumeric()
    {
        $this->validateNotNumeric('horizontalThrottle');
    }

    public function test_create_verticalThrottleNotNumeric()
    {
        $this->validateNotNumeric('verticalThrottle');
    }

    public function test_create_motorStartedMissing()
    {
        $this->validateMissingKey('motorsStarted');
    }

    public function test_create_motorStartedNotBool()
    {
        $this->validateNotBool('motorsStarted');
    }

    /**
     * @return string
     */
    protected function getMessageType(): string
    {
        return MotorControlMessage::TYPE;
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
        return [
            'desiredPosition'    => [
                'yaw'   => 1,
                'pitch' => 2,
                'roll'  => 3
            ],
            'horizontalThrottle' => 0.5,
            'verticalThrottle'   => 0.3
        ];
    }
}