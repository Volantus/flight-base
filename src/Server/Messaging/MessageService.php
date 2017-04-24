<?php
namespace Volante\SkyBukkit\Common\Src\Server\Messaging;

use Volante\SkyBukkit\Common\Src\General\FlightController\PIDFrequencyStatusMessageFactory;
use Volante\SkyBukkit\Common\Src\General\FlightController\PIDTuningStatusMessageFactory;
use Volante\SkyBukkit\Common\Src\General\FlightController\PIDTuningUpdateMessageFactory;
use Volante\SkyBukkit\Common\Src\General\GeoPosition\GeoPositionMessageFactory;
use Volante\SkyBukkit\Common\Src\General\GyroStatus\GyroStatusMessageFactory;
use Volante\SkyBukkit\Common\Src\General\Motor\MotorControlMessageFactory;
use Volante\SkyBukkit\Common\Src\General\Motor\MotorStatusMessageFactory;
use Volante\SkyBukkit\Common\Src\Server\Authentication\AuthenticationMessageFactory;
use Volante\SkyBukkit\Common\Src\Server\Network\RawMessageFactory;
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
     * @var MessageFactory[]
     */
    private $factories = [];

    /**
     * MessageService constructor.
     *
     * @param RawMessageFactory|null             $rawMessageFactory
     * @param IntroductionMessageFactory|null    $introductionMessageFactory
     * @param AuthenticationMessageFactory|null  $authenticationMessageFactory
     * @param GeoPositionMessageFactory          $geoPositionMessageFactory
     * @param GyroStatusMessageFactory           $gyroStatusMessageFactory
     * @param MotorStatusMessageFactory          $motorStatusMessageFactory
     * @param PIDFrequencyStatusMessageFactory   $PIDFrequencyStatusMessageFactory
     * @param MotorControlMessageFactory         $motorControlMessageFactory
     * @param PIDTuningStatusMessageFactory|null $PIDTuningStatusMessageFactory
     * @param PIDTuningUpdateMessageFactory      $PIDTuningUpdateMessageFactory
     */
    public function __construct(RawMessageFactory $rawMessageFactory = null, IntroductionMessageFactory $introductionMessageFactory = null, AuthenticationMessageFactory $authenticationMessageFactory = null, GeoPositionMessageFactory $geoPositionMessageFactory = null, GyroStatusMessageFactory $gyroStatusMessageFactory = null, MotorStatusMessageFactory $motorStatusMessageFactory = null, PIDFrequencyStatusMessageFactory $PIDFrequencyStatusMessageFactory = null, MotorControlMessageFactory $motorControlMessageFactory = null, PIDTuningStatusMessageFactory $PIDTuningStatusMessageFactory = null, PIDTuningUpdateMessageFactory $PIDTuningUpdateMessageFactory = null)
    {
        $this->rawMessageFactory = $rawMessageFactory ?: new RawMessageFactory();
        $this->registerFactory($introductionMessageFactory ?: new IntroductionMessageFactory());
        $this->registerFactory($authenticationMessageFactory ?: new AuthenticationMessageFactory());
        $this->registerFactory($geoPositionMessageFactory ?: new GeoPositionMessageFactory());
        $this->registerFactory($gyroStatusMessageFactory ?: new GyroStatusMessageFactory());
        $this->registerFactory($motorStatusMessageFactory ?: new MotorStatusMessageFactory());
        $this->registerFactory($PIDFrequencyStatusMessageFactory ?: new PIDFrequencyStatusMessageFactory());
        $this->registerFactory($motorControlMessageFactory ?: new MotorControlMessageFactory());
        $this->registerFactory($PIDTuningStatusMessageFactory ?: new PIDTuningStatusMessageFactory());
        $this->registerFactory($PIDTuningUpdateMessageFactory ?: new PIDTuningUpdateMessageFactory());
    }

    /**
     * @param Sender $sender
     * @param string $message
     * @return IncomingMessage
     */
    public function handle(Sender $sender, string $message) : IncomingMessage
    {
        $rawMessage = $this->rawMessageFactory->create($sender, $message);

        if (isset($this->factories[$rawMessage->getType()])) {
            return $this->factories[$rawMessage->getType()]->create($rawMessage);
        }

        throw new \InvalidArgumentException('Unable to handle message: given type <' . $rawMessage->getType() . '> is unknown');
    }

    /**
     * @param MessageFactory $factory
     */
    protected function registerFactory(MessageFactory $factory)
    {
        $this->factories[$factory->getType()] = $factory;
    }
}