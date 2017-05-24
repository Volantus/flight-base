<?php
namespace Volantus\FlightBase\Tests\General\Network;

use Volantus\FlightBase\Src\General\Network\BaseRawMessage;

/**
 * Class RawMessageFactory
 * @package Volante\SkyBukkit\RleayServer\Tests\Network
 */
class RawMessageFactory extends \Volantus\FlightBase\Src\General\Network\RawMessageFactory
{
    /**
     * @param string $json
     * @return BaseRawMessage
     */
    public function createFromJson(string $json): BaseRawMessage
    {
        return parent::createFromJson($json);
    }
}