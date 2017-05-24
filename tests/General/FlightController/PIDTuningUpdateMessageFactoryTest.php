<?php
namespace Volantus\FlightBase\Tests\General\FlightController;

use Volantus\FlightBase\Src\General\FlightController\IncomingPIDTuningUpdateMessage;
use Volantus\FlightBase\Src\General\FlightController\PIDTuningMessageFactory;
use Volantus\FlightBase\Src\General\FlightController\PIDTuningUpdateCollection;
use Volantus\FlightBase\Src\General\FlightController\PIDTuningUpdateMessageFactory;

/**
 * Class PIDTuningUpdateMessageFactoryTest
 *
 * @package Volantus\FlightBase\Tests\General\FlightController
 */
class PIDTuningUpdateMessageFactoryTest extends PIDTuningMessageFactoryTest
{
    /**
     * @return string
     */
    protected function getMessageType(): string
    {
        return PIDTuningUpdateCollection::TYPE;
    }

    /**
     * @return PIDTuningMessageFactory
     */
    protected function createFactory(): PIDTuningMessageFactory
    {
        return new PIDTuningUpdateMessageFactory();
    }

    /**
     * @return string
     */
    protected function getExpectedMessageClass(): string
    {
        return IncomingPIDTuningUpdateMessage::class;
    }
}