<?php
namespace Volantus\FlightBase\Src\Client;

/**
 * Class IntroductionMessage
 * @package Volante\SkyBukkit\StatusBroker\Src\Role
 */
class IntroductionMessage extends OutgoingMessage
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
    public function getRawData(): array
    {
        return [
            'role' => $this->role
        ];
    }
}