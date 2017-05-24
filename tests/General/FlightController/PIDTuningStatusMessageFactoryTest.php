<?php
namespace Volantus\FlightBase\Tests\General\FlightController;

use Volantus\FlightBase\Src\General\FlightController\IncomingPIDTuningStatusMessage;
use Volantus\FlightBase\Src\General\FlightController\PIDTuningMessageFactory;
use Volantus\FlightBase\Src\General\FlightController\PIDTuningStatusCollection;
use Volantus\FlightBase\Src\General\FlightController\PIDTuningStatusMessageFactory;

/**
 * Class PIDTuningStatusMessageFactoryTest
 *
 * @package Volantus\FlightBase\Tests\General\FlightController
 */
class PIDTuningStatusMessageFactoryTest extends PIDTuningMessageFactoryTest
{
    /**
     * @return string
     */
    protected function getMessageType(): string
    {
        return PIDTuningStatusCollection::TYPE;
    }

    /**
     * @return PIDTuningMessageFactory
     */
    protected function createFactory(): PIDTuningMessageFactory
    {
        return new PIDTuningStatusMessageFactory();
    }

    /**
     * @return string
     */
    protected function getExpectedMessageClass(): string
    {
        return IncomingPIDTuningStatusMessage::class;
    }
}