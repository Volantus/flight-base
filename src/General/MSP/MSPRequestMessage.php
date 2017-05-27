<?php
namespace Volantus\FlightBase\Src\General\MSP;

use Volantus\MSPProtocol\Src\Protocol\Request\Request;

/**
 * Class MSPRequestMessage
 *
 * @package Volantus\FlightBase\Src\General\MSP
 */
class MSPRequestMessage
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var int
     */
    private $priority;

    /**
     * @var Request
     */
    private $mspRequest;

    /**
     * MSPRequestMessage constructor.
     *
     * @param int     $priority
     * @param Request $mspRequest
     */
    public function __construct($priority, Request $mspRequest)
    {
        $this->id = uniqid();
        $this->priority = $priority;
        $this->mspRequest = $mspRequest;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority;
    }

    /**
     * @return Request
     */
    public function getMspRequest(): Request
    {
        return $this->mspRequest;
    }
}