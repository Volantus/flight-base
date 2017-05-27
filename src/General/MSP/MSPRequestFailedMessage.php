<?php
namespace Volantus\FlightBase\Src\General\MSP;

/**
 * Class MSPRequestFailedMessage
 *
 * @package Volantus\FlightBase\Src\General\MSP
 */
class MSPRequestFailedMessage
{
    /**
     * @var string
     */
    private $id;

    /**
     * MSPRequestFailedMessage constructor.
     *
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
}