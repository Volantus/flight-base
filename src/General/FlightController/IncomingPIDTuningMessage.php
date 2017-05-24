<?php
namespace Volantus\FlightBase\Src\General\FlightController;

use Volantus\FlightBase\Src\Server\Messaging\IncomingMessage;
use Volantus\FlightBase\Src\Server\Messaging\Sender;

/**
 * Class IncomingPIDTuningMessage
 *
 * @package Volantus\FlightBase\Src\General\FlightController
 */
abstract class IncomingPIDTuningMessage extends IncomingMessage
{
    /**
     * @var PIDTuningCollection
     */
    private $statusCollection;

    /**
     * IncomingPIDTuningStatusMessage constructor.
     *
     * @param Sender              $sender
     * @param PIDTuningCollection $status
     */
    public function __construct(Sender $sender, PIDTuningCollection $status)
    {
        parent::__construct($sender);
        $this->statusCollection = $status;
    }

    /**
     * @return PIDTuningCollection
     */
    public function getStatus(): PIDTuningCollection
    {
        return $this->statusCollection;
    }
}