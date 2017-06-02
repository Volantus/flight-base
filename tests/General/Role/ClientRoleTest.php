<?php
namespace Volantus\FlightBase\Tests\General\Role;

use Volantus\FlightBase\Src\General\Role\ClientRole;

/**
 * Class ClientRoleTest
 * @package Volantus\FlightBase\Tests\Role
 */
class ClientRoleTest extends \PHPUnit_Framework_TestCase
{
    public function test_getSupportedRoles_correct()
    {
        self::assertEquals([ClientRole::OPERATOR, ClientRole::MANUAL_CONTROL_SERVICE, ClientRole::GYRO_STATUS_SERVICE, ClientRole::MOTOR_STATUS_SERVICE, ClientRole::ORIENTATION_CONTROL_SERVICE], ClientRole::getSupportedRoles());
    }

    public function test_getTitle_correct()
    {
        self::assertEquals('OPERATOR', ClientRole::getTitle(ClientRole::OPERATOR));
        self::assertEquals('MANUAL_CONTROL_SERVICE', ClientRole::getTitle(ClientRole::MANUAL_CONTROL_SERVICE));
        self::assertEquals('GYRO_STATUS_SERVICE', ClientRole::getTitle(ClientRole::GYRO_STATUS_SERVICE));
    }
}