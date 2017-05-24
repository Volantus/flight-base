<?php
namespace Volantus\FlightBase\Tests\General\FlightController;

use Volantus\FlightBase\Src\General\FlightController\PIDTuningStatus;

/**
 * Class PIDTuningStatusTest
 *
 * @package Volantus\FlightBase\Tests\General\FlightController
 */
class PIDTuningStatusTest extends \PHPUnit_Framework_TestCase
{
    public function test_jsonSerialize_correct()
    {
        $status = new PIDTuningStatus(1.1, 2.2, 3.3);

        self::assertEquals([
            'Kp' => 1.1,
            'Ki' => 2.2,
            'Kd' => 3.3
        ], $status->jsonSerialize());
    }
}