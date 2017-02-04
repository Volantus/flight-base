<?php
namespace Volante\SkyBukkit\Common\Src\General\Motor;

use Volante\SkyBukkit\Common\Src\Server\Messaging\IncomingMessage;
use Volante\SkyBukkit\Common\Src\Server\Messaging\Sender;

/**
 * Class IncomingMotorStatusMessage
 * @package Volante\SkyBukkit\Common\Src\General\Motor
 */
class IncomingMotorStatusMessage extends IncomingMessage
{
    /**
     * @var MotorStatus
     */
    protected $motorStatus;

    /**
     * IncomingMotorStatusMessage constructor.
     *
     * @param Sender      $sender
     * @param MotorStatus $motorStatus
     */
    public function __construct(Sender $sender, MotorStatus $motorStatus)
    {
        parent::__construct($sender);
        $this->motorStatus = $motorStatus;
    }

    /**
     * @return MotorStatus
     */
    public function getMotorStatus(): MotorStatus
    {
        return $this->motorStatus;
    }
}