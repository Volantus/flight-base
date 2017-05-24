<?php
namespace Volantus\FlightBase\Src\Server\Role;

use Volantus\FlightBase\Src\Server\Messaging\IncomingMessage;
use Volantus\FlightBase\Src\Server\Network\Client;

/**
 * Class IntroduceMessage
 * @package Volantus\FlightBase\Src\Server\Role
 */
class IntroductionMessage extends IncomingMessage
{
    const TYPE = 'introduction';

    /**
     * @var int
     */
    private $role;

    /**
     * IntroductionMessage constructor.
     * @param Client $sender
     * @param int $role
     */
    public function __construct(Client $sender, int $role)
    {
        parent::__construct($sender);
        $this->role = $role;
    }

    /**
     * @return int
     */
    public function getRole(): int
    {
        return $this->role;
    }
}