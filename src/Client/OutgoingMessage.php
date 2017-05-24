<?php
namespace Volantus\FlightBase\Src\Client;

use Volantus\FlightBase\Src\General\Network\BaseRawMessage;

/**
 * Class OutgoingMessage
 * @package Volante\SkyBukkit\StatusBroker\Src\Network
 */
abstract class OutgoingMessage
{
    /**
     * @var string
     */
    protected $type = 'undefined';

    /**
     * @var string
     */
    protected $messageTitle = 'undefined';

    /**
     * @return \Volantus\FlightBase\Src\General\Network\BaseRawMessage
     */
    public function toRawMessage() : BaseRawMessage
    {
        return new BaseRawMessage($this->type, $this->messageTitle, $this->getRawData());
    }

    /**
     * @return array
     */
    public abstract function getRawData() : array;
}