<?php
namespace Volante\SkyBukkit\Common\Tests\General\Network;

use Volante\SkyBukkit\Common\Src\General\Network\BaseRawMessage;

/**
 * Class RawMessageFactory
 * @package Volante\SkyBukkit\RleayServer\Tests\Network
 */
class RawMessageFactory extends \Volante\SkyBukkit\Common\Src\General\Network\RawMessageFactory
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