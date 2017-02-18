<?php
namespace Volante\SkyBukkit\Common\Src\General\Motor;

use Volante\SkyBukkit\Common\Src\Server\Messaging\IncomingMessage;
use Volante\SkyBukkit\Common\Src\Server\Messaging\Sender;

/**
 * Class IncomingManualMotorControlMessage
 *
 * @package Volante\SkyBukkit\Common\Src\General\Motor
 */
class IncomingMotorControlMessage extends IncomingMessage
{
    /**
     * @var MotorControlMessage
     */
    private $motorControl;

    /**
     * IncomingMotorControlMessage constructor.
     *
     * @param Sender              $sender
     * @param MotorControlMessage $motorControl
     */
    public function __construct(Sender $sender, MotorControlMessage $motorControl)
    {
        parent::__construct($sender);
        $this->motorControl = $motorControl;
    }

    /**
     * @return MotorControlMessage
     */
    public function getMotorControl(): MotorControlMessage
    {
        return $this->motorControl;
    }
}