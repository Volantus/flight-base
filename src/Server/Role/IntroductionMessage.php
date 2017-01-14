<?php
namespace Volante\SkyBukkit\Common\Src\Server\Role;

use Volante\SkyBukkit\Common\Src\Server\Messaging\Message;
use Volante\SkyBukkit\Common\Src\Server\Network\Client;

/**
 * Class IntroduceMessage
 * @package Volante\SkyBukkit\Common\Src\Server\Role
 */
class IntroductionMessage extends Message
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