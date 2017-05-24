<?php
namespace Volantus\FlightBase\Src\General\Motor;

use Volantus\FlightBase\Src\Server\Messaging\IncomingMessage;
use Volantus\FlightBase\Src\Server\Messaging\Sender;

/**
 * Class IncomingManualMotorControlMessage
 *
 * @package Volantus\FlightBase\Src\General\Motor
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