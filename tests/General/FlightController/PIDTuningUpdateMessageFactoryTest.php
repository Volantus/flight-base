<?php
namespace Volante\SkyBukkit\Common\Tests\General\FlightController;

use Volante\SkyBukkit\Common\Src\General\FlightController\IncomingPIDTuningUpdateMessage;
use Volante\SkyBukkit\Common\Src\General\FlightController\PIDTuningMessageFactory;
use Volante\SkyBukkit\Common\Src\General\FlightController\PIDTuningUpdateCollection;
use Volante\SkyBukkit\Common\Src\General\FlightController\PIDTuningUpdateMessageFactory;

/**
 * Class PIDTuningUpdateMessageFactoryTest
 *
 * @package Volante\SkyBukkit\Common\Tests\General\FlightController
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