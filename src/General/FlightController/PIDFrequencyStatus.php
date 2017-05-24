<?php
namespace Volantus\FlightBase\Src\General\FlightController;

use Volantus\FlightBase\Src\Client\OutgoingMessage;

/**
 * Class PIDFrequencyStatus
 *
 * @package Volantus\FlightBase\Src\General
 */
class PIDFrequencyStatus extends OutgoingMessage
{
    const TYPE = 'PIDFrequencyStatus';

    /**
     * @var string
     */
    protected $type = self::TYPE;

    /**
     * @var string
     */
    protected $messageTitle = 'Current PID frequency';

    /**
     * @var float
     */
    protected $desiredFrequency;

    /**
     * @var float
     */
    protected $currentFrequency;

    /**
     * PIDFrequencyStatus constructor.
     *
     * @param float $desiredFrequency
     * @param float $currentFrequency
     */
    public function __construct(float $desiredFrequency, float $currentFrequency)
    {
        $this->desiredFrequency = $desiredFrequency;
        $this->currentFrequency = $currentFrequency;
    }

    /**
     * @return float
     */
    public function getDesiredFrequency(): float
    {
        return $this->desiredFrequency;
    }

    /**
     * @return float
     */
    public function getCurrentFrequency(): float
    {
        return $this->currentFrequency;
    }

    /**
     * @return array
     */
    public function getRawData(): array
    {
        return [
            'desired' => $this->desiredFrequency,
            'current' => $this->currentFrequency
        ];
    }
}