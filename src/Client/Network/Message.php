<?php
namespace Volante\SkyBukkit\Common\Src\Client\Network;

use Volante\SkyBukkit\Common\Src\Network\RawMessage;

/**
 * Class Message
 * @package Volante\SkyBukkit\StatusBroker\Src\Network
 */
abstract class Message
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
     * @return RawMessage
     */
    public function toRawMessage() : RawMessage
    {
        return new RawMessage($this->type, $this->messageTitle, $this->getRawData());
    }

    /**
     * @return array
     */
    protected abstract function getRawData() : array;
}