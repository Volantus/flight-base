<?php
namespace Volantus\FlightBase\Src\General\Role;

/**
 * Class ClientRole
 * @package Volante\SkyBukkit\RelayServer\Src\Role
 */
abstract class ClientRole
{
    const OPERATOR               = 1;
    const MANUAL_CONTROL_SERVICE = 2;
    const GYRO_STATUS_SERVICE    = 3;
    const MOTOR_STATUS_SERVICE   = 4;

    /**
     * @return array
     */
    public static function getSupportedRoles(): array
    {
        return [self::OPERATOR, self::MANUAL_CONTROL_SERVICE, self::GYRO_STATUS_SERVICE];
    }

    /**
     * @param int $clientRole
     * @return string
     */
    public static function getTitle(int $clientRole) : string
    {
        switch ($clientRole) {
            case self::OPERATOR:
                return 'OPERATOR';
                break;
            case self::MANUAL_CONTROL_SERVICE:
                return 'MANUAL_CONTROL_SERVICE';
                break;
            case self::GYRO_STATUS_SERVICE:
                return 'GYRO_STATUS_SERVICE';
                break;
            case self::MOTOR_STATUS_SERVICE:
                return 'MOTOR_STATUS_SERVICE';
                break;
        }

        return 'UNDEFINED';
    }
}