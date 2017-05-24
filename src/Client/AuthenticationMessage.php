<?php
namespace Volantus\FlightBase\Src\Client;

/**
 * Class AuthenticationMessage
 * @package Volantus\FlightBase\Src\Client
 */
class AuthenticationMessage extends OutgoingMessage
{
    /**
     * @var string
     */
    protected $type = 'authentication';

    /**
     * @var string
     */
    protected $messageTitle = 'Authentication';

    /**
     * @var string
     */
    private $token;

    /**
     * AuthenticationMessage constructor.
     * @param string $token
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @return array
     */
    public function getRawData(): array
    {
        return [
            'token' => $this->token
        ];
    }
}