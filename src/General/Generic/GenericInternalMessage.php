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
     * @var object
     */
    private $payload;

    /**
     * GenericInternalMessage constructor.
     *
     * @param object $payload
     */
    public function __construct(object $payload)
    {
        $this->payload = $payload;
    }

    /**
     * @return object
     */
    public function getPayload(): object
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