<?php
namespace Volantus\FlightBase\Src\General\Motor;

use Volantus\FlightBase\Src\Client\OutgoingMessage;
use Volantus\FlightBase\Src\General\GyroStatus\GyroStatus;

/**
 * Class ManualMotorControlMessage
 *
 * @package Volantus\FlightBase\Src\General\Motor
 */
class MotorControlMessage extends OutgoingMessage
{
    const TYPE = 'motorControl';

    /**
     * @var string
     */
    protected $type = self::TYPE;

    /**
     * @var string
     */
    protected $messageTitle = 'Motor control';

    /**
     * @var GyroStatus
     */
    private $desiredPosition;

    /**
     * @var float
     */
    private $horizontalThrottle;

    /**
     * @var float
     */
    private $verticalThrottle;

    /**
     * @var bool
     */
    private $motorsStarted;

    /**
     * ManualMotorControlMessage constructor.
     *
     * @param GyroStatus $desiredPosition
     * @param float      $horizontalThrottle
     * @param float      $verticalThrottle
     * @param bool       $motorsStarted
     */
    public function __construct(GyroStatus $desiredPosition, float $horizontalThrottle, float $verticalThrottle, bool $motorsStarted)
    {
        $this->desiredPosition = $desiredPosition;
        $this->horizontalThrottle = $horizontalThrottle;
        $this->verticalThrottle = $verticalThrottle;
        $this->motorsStarted = $motorsStarted;
    }

    /**
     * @return GyroStatus
     */
    public function getDesiredPosition(): GyroStatus
    {
        return $this->desiredPosition;
    }

    /**
     * @return float
     */
    public function getHorizontalThrottle(): float
    {
        return $this->horizontalThrottle;
    }

    /**
     * @return float
     */
    public function getVerticalThrottle(): float
    {
        return $this->verticalThrottle;
    }

    /**
     * @return bool
     */
    public function areMotorsStarted(): bool
    {
        return $this->motorsStarted;
    }

    /**
     * @return array
     */
    public function getRawData(): array
    {
        return [
            'desiredPosition'    => $this->desiredPosition,
            'horizontalThrottle' => $this->horizontalThrottle,
            'verticalThrottle'   => $this->verticalThrottle,
            'motorsStarted'      => $this->motorsStarted
        ];
    }
}