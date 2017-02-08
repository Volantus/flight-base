<?php
namespace Volante\SkyBukkit\Common\Src\General\Motor;

use Volante\SkyBukkit\Common\Src\Client\OutgoingMessage;

/**
 * Class MotorStatus
 * @package Volante\SkyBukkit\Common\Src\General\Motor
 */
class MotorStatus extends OutgoingMessage
{
    const TYPE = 'motorStatus';

    /**
     * @var string
     */
    protected $type = self::TYPE;

    /**
     * @var string
     */
    protected $messageTitle = 'Motor status';

    /**
     * @var Motor[]
     */
    private $motors;

    /**
     * MotorStatus constructor.
     * @param Motor[] $motors
     */
    public function __construct(array $motors)
    {
        $this->motors = $motors;
    }

    /**
     * @return array
     */
    public function getRawData(): array
    {
        return [
            'motors' => $this->motors
        ];
    }

    /**
     * @return Motor[]
     */
    public function getMotors(): array
    {
        return $this->motors;
    }
}