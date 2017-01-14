<?php
namespace Volante\SkyBukkit\Common\Tests\General\Role;

use Volante\SkyBukkit\Common\Src\General\Role\ClientRole;

/**
 * Class ClientRoleTest
 * @package Volante\SkyBukkit\Common\Tests\Role
 */
class ClientRoleTest extends \PHPUnit_Framework_TestCase
{
    public function test_getSupportedRoles_correct()
    {
        self::assertEquals([ClientRole::OPERATOR, ClientRole::FLIGHT_CONTROLLER, ClientRole::STATUS_BROKER], ClientRole::getSupportedRoles());
    }

    public function test_getTitle_correct()
    {
        self::assertEquals('OPERATOR', ClientRole::getTitle(ClientRole::OPERATOR));
        self::assertEquals('FLIGHT_CONTROLLER', ClientRole::getTitle(ClientRole::FLIGHT_CONTROLLER));
        self::assertEquals('STATUS_BROKER', ClientRole::getTitle(ClientRole::STATUS_BROKER));
    }
}