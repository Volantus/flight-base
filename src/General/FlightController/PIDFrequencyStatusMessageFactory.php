<?php
namespace Volante\SkyBukkit\Common\Src\General\FlightController;

use Volante\SkyBukkit\Common\Src\Server\Messaging\IncomingMessage;
use Volante\SkyBukkit\Common\Src\Server\Messaging\MessageFactory;
use Volante\SkyBukkit\Common\Src\Server\Network\NetworkRawMessage;

/**
 * Class PIDFrequencyStatusMessageFactory
 *
 * @package Volante\SkyBukkit\Common\Src\General\FlightController
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