<?php
namespace Volante\SkyBukkit\Common\Src\General\FlightController;

use Volante\SkyBukkit\Common\Src\Server\Messaging\IncomingMessage;
use Volante\SkyBukkit\Common\Src\Server\Messaging\Sender;

/**
 * Class IncomingPIDFrequencyStatus
 *
 * @package Volante\SkyBukkit\Common\Src\General\FlightController
 */
class IncomingPIDFrequencyStatus extends IncomingMessage
{
    /**
     * @var PIDFrequencyStatus
     */
    private $frequencyStatus;

    /**
     * IncomingPIDFrequencyStatus constructor.
     *
     * @param Sender             $sender
     * @param PIDFrequencyStatus $frequencyStatus
     */
    public function __construct(Sender $sender, PIDFrequencyStatus $frequencyStatus)
    {
        parent::__construct($sender);
        $this->frequencyStatus = $frequencyStatus;
    }

    /**
     * @return PIDFrequencyStatus
     */
    public function getFrequencyStatus(): PIDFrequencyStatus
    {
        return $this->frequencyStatus;
    }
}