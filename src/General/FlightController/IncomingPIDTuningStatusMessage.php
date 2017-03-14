<?php
namespace Volante\SkyBukkit\Common\Src\General\FlightController;

use Volante\SkyBukkit\Common\Src\Server\Messaging\IncomingMessage;
use Volante\SkyBukkit\Common\Src\Server\Messaging\Sender;

/**
 * Class IncomingPIDTuningStatusMessage
 *
 * @package Volante\SkyBukkit\Common\Src\General\FlightController
 */
class IncomingPIDTuningStatusMessage extends IncomingMessage
{
    /**
     * @var PIDTuningStatusCollection
     */
    private $statusCollection;

    /**
     * IncomingPIDTuningStatusMessage constructor.
     *
     * @param Sender                    $sender
     * @param PIDTuningStatusCollection $status
     */
    public function __construct(Sender $sender, PIDTuningStatusCollection $status)
    {
        parent::__construct($sender);
        $this->statusCollection = $status;
    }

    /**
     * @return PIDTuningStatusCollection
     */
    public function getStatus(): PIDTuningStatusCollection
    {
        return $this->statusCollection;
    }
}