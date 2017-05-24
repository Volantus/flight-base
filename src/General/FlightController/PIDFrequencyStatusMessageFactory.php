<?php
namespace Volantus\FlightBase\Src\General\FlightController;

use Volantus\FlightBase\Src\Server\Messaging\IncomingMessage;
use Volantus\FlightBase\Src\Server\Messaging\MessageFactory;
use Volantus\FlightBase\Src\Server\Network\NetworkRawMessage;

/**
 * Class PIDFrequencyStatusMessageFactory
 *
 * @package Volantus\FlightBase\Src\General\FlightController
 */
class PIDFrequencyStatusMessageFactory extends MessageFactory
{
    /**
     * @var string
     */
    protected $type = PIDFrequencyStatus::TYPE;

    /**
     * @param NetworkRawMessage $rawMessage
     *
     * @return IncomingPIDFrequencyStatus|IncomingMessage
     */
    public function create(NetworkRawMessage $rawMessage): IncomingMessage
    {
        $data = $rawMessage->getData();
        $this->validateNumeric($data, 'desired');
        $this->validateNumeric($data, 'current');

        return new IncomingPIDFrequencyStatus($rawMessage->getSender(), new PIDFrequencyStatus($data['desired'], $data['current']));
    }
}