<?php
namespace Volante\SkyBukkit\Common\Tests\General\Network;

use Volante\SkyBukkit\Common\Src\General\Network\RawMessage;

/**
 * Class RawMessageFactory
 * @package Volante\SkyBukkit\RleayServer\Tests\Network
 */
class RawMessageFactory extends \Volante\SkyBukkit\Common\Src\General\Network\RawMessageFactory
{
    /**
     * @param string $json
     * @return RawMessage
     */
    public function createFromJson(string $json): RawMessage
    {
        return parent::createFromJson($json);
    }
}