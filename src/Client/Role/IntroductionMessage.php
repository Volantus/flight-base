<?php
namespace Volante\SkyBukkit\Common\Src\Client\Role;

use Volante\SkyBukkit\Common\Src\Client\Network\Message;

/**
 * Class IntroductionMessage
 * @package Volante\SkyBukkit\StatusBroker\Src\Role
 */
class IntroductionMessage extends Message
{
    /**
     * @var string
     */
    protected $type = 'introduction';

    /**
     * @var string
     */
    protected $messageTitle = 'Introduction';

    /**
     * @var int
     */
    private $role;

    /**
     * IntroductionMessage constructor.
     * @param int $role
     */
    public function __construct(int $role)
    {
        $this->role = $role;
    }

    /**
     * @return int
     */
    public function getRole(): int
    {
        return $this->role;
    }

    /**
     * @return array
     */
    protected function getRawData(): array
    {
        return [
            'role' => $this->role
        ];
    }
}