<?php
namespace Volantus\FlightBase\Src\Server\Authentication;

use Volantus\FlightBase\Src\Server\Messaging\IncomingMessage;
use Volantus\FlightBase\Src\Server\Network\Client;

/**
 * Created by PhpStorm.
 * User: marius
 * Date: 13.01.17
 * Time: 17:35
 */
class AuthenticationMessage extends IncomingMessage
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