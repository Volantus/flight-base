<?php
namespace Volantus\FlightBase\Src\General\Generic;

use Volantus\FlightBase\Src\Client\OutgoingMessage;

/**
 * Class GenericInternalMessage
 *
 * @package Volantus\FlightBase\Src\General\Network
 */
class GenericInternalMessage extends OutgoingMessage
{
    const TYPE = 'genericInternalMessage';

    /**
     * @var string
     */
    protected $type = self::TYPE;

    /**
     * @var string
     */
    protected $messageTitle = 'Generic internal message';

    /**
     * @var mixed
     */
    private $payload;

    /**
     * GenericInternalMessage constructor.
     *
     * @param mixed $payload
     */
    public function __construct($payload)
    {
        $this->payload = $payload;
    }

    /**
     * @return mixed
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @return array
     */
    public function getRawData(): array
    {
        return [serialize($this->payload)];
    }
}