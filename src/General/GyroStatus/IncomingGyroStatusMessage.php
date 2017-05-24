<?php
namespace Volantus\FlightBase\Src\General\GyroStatus;

use Volantus\FlightBase\Src\Server\Messaging\IncomingMessage;
use Volantus\FlightBase\Src\Server\Messaging\Sender;

/**
 * Class IncomingGeoPositionMessage
 * @package Volantus\FlightBase\Src\General\GeoPosition
 */
class IncomingGyroStatusMessage extends IncomingMessage
{
    /**
     * @var GyroStatus
     */
    private $gyroStatus;

    /**
     * IncomingGeoPositionMessage constructor.
     *
     * @param Sender     $sender
     * @param GyroStatus $gyroStatus
     */
    public function __construct(Sender $sender, GyroStatus $gyroStatus)
    {
        parent::__construct($sender);
        $this->gyroStatus = $gyroStatus;
    }

    /**
     * @return GyroStatus
     */
    public function getGyroStatus(): GyroStatus
    {
        return $this->gyroStatus;
    }
}