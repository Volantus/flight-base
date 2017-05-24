<?php
namespace Volantus\FlightBase\Tests\General\FlightController;

use Volantus\FlightBase\Src\General\FlightController\IncomingPIDFrequencyStatus;
use Volantus\FlightBase\Src\General\FlightController\PIDFrequencyStatus;
use Volantus\FlightBase\Src\General\FlightController\PIDFrequencyStatusMessageFactory;
use Volantus\FlightBase\Src\Server\Messaging\IncomingMessage;
use Volantus\FlightBase\Src\Server\Network\NetworkRawMessage;
use Volantus\FlightBase\Tests\Server\General\MessageFactoryTestCase;

/**
 * Class PIDFrequencyStatusMessageFactoryTest
 *
 * @package Volantus\FlightBase\Tests\General\FlightController
 */
class PIDFrequencyStatusMessageFactoryTest extends MessageFactoryTestCase
{
    /**
     * @var PIDFrequencyStatusMessageFactory
     */
    private $factory;

    protected function setUp()
    {
        parent::setUp();
        $this->factory = new PIDFrequencyStatusMessageFactory();
    }

    /**
     * @return string
     */
    protected function getMessageType(): string
    {
        return PIDFrequencyStatus::TYPE;
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
            'desired' => 1000,
            'current' => 958.13
        ];
    }

    public function test_create_desiredKeyMissing()
    {
        $this->validateMissingKey('desired');
    }

    public function test_create_currentKeyMissing()
    {
        $this->validateMissingKey('current');
    }

    public function test_create_desiredKeyNotNumeric()
    {
        $this->validateNotNumeric('desired');
    }

    public function test_create_currentKeyNotNumeric()
    {
        $this->validateNotNumeric('current');
    }

    public function test_create_correct()
    {
        /** @var IncomingPIDFrequencyStatus $result */
        $result = $this->callFactory($this->getRawMessage($this->getCorrectMessageData()));

        self::assertInstanceOf(IncomingPIDFrequencyStatus::class, $result);
        self::assertEquals(1000, $result->getFrequencyStatus()->getDesiredFrequency());
        self::assertEquals(958.13, $result->getFrequencyStatus()->getCurrentFrequency());
    }
}