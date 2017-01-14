<?php
namespace Volante\SkyBukkit\Common\Src\Server\Authentication;

use Guzzle\Common\Exception\RuntimeException;

/**
 * Class UnauthorizedException
 * @package Volante\SkyBukkit\Common\Src\Server\Authentication
 */
class UnauthorizedException extends RuntimeException
{
    /**
     * UnauthorizedException constructor.
     * @param string $message
     */
    public function __construct($message = "")
    {
        parent::__construct($message);
    }
}