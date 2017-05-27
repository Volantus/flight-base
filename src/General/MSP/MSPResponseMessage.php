<?php
namespace Volantus\FlightBase\Src\General\MSP;

use Volantus\MSPProtocol\Src\Protocol\Response\Response;

/**
 * Class MSPResponseMessage
 *
 * @package Volantus\FlightBase\Src\General\MSP
 */
class MSPResponseMessage
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var Response
     */
    private $mspResponse;

    /**
     * MSPResponseMessage constructor.
     *
     * @param string   $id
     * @param Response $mspResponse
     */
    public function __construct(string $id, Response $mspResponse)
    {
        $this->id = $id;
        $this->mspResponse = $mspResponse;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return Response
     */
    public function getMspResponse(): Response
    {
        return $this->mspResponse;
    }
}