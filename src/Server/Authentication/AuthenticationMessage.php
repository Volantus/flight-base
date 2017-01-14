<?php
namespace Volante\SkyBukkit\Common\Src\Server\Authentication;

use Volante\SkyBukkit\Common\Src\Server\Messaging\Message;
use Volante\SkyBukkit\Common\Src\Server\Network\Client;

/**
 * Created by PhpStorm.
 * User: marius
 * Date: 13.01.17
 * Time: 17:35
 */
class AuthenticationMessage extends Message
{
    const TYPE = 'authentication';

    /**
     * @var string
     */
    private $token;

    /**
     * AuthenticationMessage constructor.
     * @param Client $sender
     * @param string $token
     */
    public function __construct(Client $sender, string $token)
    {
        parent::__construct($sender);
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }
}