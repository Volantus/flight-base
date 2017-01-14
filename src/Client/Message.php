<?php
namespace Volante\SkyBukkit\Common\Src\Client;

use Volante\SkyBukkit\Common\Src\General\Network\RawMessage;

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
     * @return \Volante\SkyBukkit\Common\Src\General\Network\RawMessage
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