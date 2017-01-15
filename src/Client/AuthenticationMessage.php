<?php
namespace Volante\SkyBukkit\Common\Src\Client;

/**
 * Class AuthenticationMessage
 * @package Volante\SkyBukkit\Common\Src\Client
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
    protected function getRawData(): array
    {
        return [
            'token' => $this->token
        ];
    }
}