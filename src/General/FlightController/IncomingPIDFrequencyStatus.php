<?php
namespace Volantus\FlightBase\Src\General\FlightController;

use Volantus\FlightBase\Src\Server\Messaging\IncomingMessage;
use Volantus\FlightBase\Src\Server\Messaging\Sender;

/**
 * Class IncomingPIDFrequencyStatus
 *
 * @package Volantus\FlightBase\Src\General\FlightController
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