<?php
namespace Volante\SkyBukkit\Common\Src\General\GyroStatus;

use Volante\SkyBukkit\Common\Src\Server\Messaging\IncomingMessage;
use Volante\SkyBukkit\Common\Src\Server\Messaging\Sender;

/**
 * Class IncomingGeoPositionMessage
 * @package Volante\SkyBukkit\Common\Src\General\GeoPosition
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