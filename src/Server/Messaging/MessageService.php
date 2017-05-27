<?php
namespace Volantus\FlightBase\Src\Server\Messaging;

use Volantus\FlightBase\Src\General\FlightController\PIDFrequencyStatusMessageFactory;
use Volantus\FlightBase\Src\General\FlightController\PIDTuningStatusMessageFactory;
use Volantus\FlightBase\Src\General\FlightController\PIDTuningUpdateMessageFactory;
use Volantus\FlightBase\Src\General\Generic\GenericInternalMessageFactory;
use Volantus\FlightBase\Src\General\GeoPosition\GeoPositionMessageFactory;
use Volantus\FlightBase\Src\General\GyroStatus\GyroStatusMessageFactory;
use Volantus\FlightBase\Src\General\Motor\MotorControlMessageFactory;
use Volantus\FlightBase\Src\General\Motor\MotorStatusMessageFactory;
use Volantus\FlightBase\Src\Server\Authentication\AuthenticationMessageFactory;
use Volantus\FlightBase\Src\Server\Network\RawMessageFactory;
use Volantus\FlightBase\Src\Server\Role\IntroductionMessageFactory;

/**
 * Class MessageService
 * @package Volantus\FlightBase\Src\Server
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
     * @param GenericInternalMessageFactory|null $genericInternalMessageFactory
     */
    public function __construct(RawMessageFactory $rawMessageFactory = null, IntroductionMessageFactory $introductionMessageFactory = null, AuthenticationMessageFactory $authenticationMessageFactory = null, GeoPositionMessageFactory $geoPositionMessageFactory = null, GyroStatusMessageFactory $gyroStatusMessageFactory = null, MotorStatusMessageFactory $motorStatusMessageFactory = null, PIDFrequencyStatusMessageFactory $PIDFrequencyStatusMessageFactory = null, MotorControlMessageFactory $motorControlMessageFactory = null, PIDTuningStatusMessageFactory $PIDTuningStatusMessageFactory = null, PIDTuningUpdateMessageFactory $PIDTuningUpdateMessageFactory = null, GenericInternalMessageFactory $genericInternalMessageFactory = null)
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
        $this->registerFactory($genericInternalMessageFactory ?: new GenericInternalMessageFactory());
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