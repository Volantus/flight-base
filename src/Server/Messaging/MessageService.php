<?php
namespace Volante\SkyBukkit\Common\Src\Server\Messaging;

use Volante\SkyBukkit\Common\Src\Server\Authentication\AuthenticationMessage;
use Volante\SkyBukkit\Common\Src\Server\Authentication\AuthenticationMessageFactory;
use Volante\SkyBukkit\Common\Src\Server\Network\Client;
use Volante\SkyBukkit\Common\Src\Server\Network\RawMessageFactory;
use Volante\SkyBukkit\Common\Src\Server\Role\IntroductionMessage;
use Volante\SkyBukkit\Common\Src\Server\Role\IntroductionMessageFactory;

/**
 * Class MessageService
 * @package Volante\SkyBukkit\Common\Src\Server
 */
class MessageService
{
    /**
     * @var RawMessageFactory
     */
    private $rawMessageFactory;

    /**
     * @var IntroductionMessageFactory
     */
    private $introductionMessageFactory;

    /**
     * @var AuthenticationMessageFactory
     */
    private $authenticationMessageFactory;

    /**
     * MessageService constructor.
     * @param RawMessageFactory $rawMessageFactory
     * @param IntroductionMessageFactory $introductionMessageFactory
     * @param AuthenticationMessageFactory $authenticationMessageFactory
     */
    public function __construct(RawMessageFactory $rawMessageFactory = null, IntroductionMessageFactory $introductionMessageFactory = null, AuthenticationMessageFactory $authenticationMessageFactory = null)
    {
        $this->rawMessageFactory = $rawMessageFactory ?: new RawMessageFactory();
        $this->introductionMessageFactory = $introductionMessageFactory ?: new IntroductionMessageFactory();
        $this->authenticationMessageFactory = $authenticationMessageFactory ?: new AuthenticationMessageFactory();
    }

    /**
     * @param Client $sender
     * @param string $message
     * @return Message
     */
    public function handle(Client $sender, string $message) : Message
    {
        $rawMessage = $this->rawMessageFactory->create($sender, $message);

        switch ($rawMessage->getType()) {
            case IntroductionMessage::TYPE:
                return $this->introductionMessageFactory->create($rawMessage);
            case AuthenticationMessage::TYPE:
                return $this->authenticationMessageFactory->create($rawMessage);
            default:
                throw new \InvalidArgumentException('Unable to handle message: given type <' . $rawMessage->getType() . '> is unknown');
        }
    }
}