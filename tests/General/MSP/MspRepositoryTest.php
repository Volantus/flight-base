<?php
namespace Volantus\FlightBase\Src\Tests\MSP;
use Ratchet\Client\WebSocket;
use Volantus\FlightBase\Src\Client\Server;
use Volantus\FlightBase\Src\General\MSP\MspRepository;
use Volantus\FlightBase\Src\General\MSP\MSPRequestMessage;
use Volantus\FlightBase\Src\General\MSP\MSPResponseMessage;
use Volantus\MSPProtocol\Src\Protocol\Request\Request;
use Volantus\MSPProtocol\Src\Protocol\Response\Response;

/**
 * Class MspRepositoryTest
 *
 * @package Volantus\FlightBase\Src\Tests\MSP
 */
abstract class MspRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var WebSocket|\PHPUnit_Framework_MockObject_MockObject
     */
    private $connectionA;

    /**
     * @var Server
     */
    private $serverA;

    /**
     * @var WebSocket|\PHPUnit_Framework_MockObject_MockObject
     */
    private $connectionB;

    /**
     * @var Server
     */
    private $serverB;

    /**
     * @var MspRepository
     */
    private $repository;

    protected function setUp()
    {
        $this->connectionA = $this->getMockBuilder(WebSocket::class)->disableOriginalConstructor()->getMock();
        $this->connectionB = $this->getMockBuilder(WebSocket::class)->disableOriginalConstructor()->getMock();
        $this->serverA = new Server($this->connectionA, Server::ROLE_RELAY_SERVER_A);
        $this->serverB = new Server($this->connectionB, Server::ROLE_RELAY_SERVER_B);

        $this->repository = $this->createRepository();
    }

    /**
     * @return MspRepository
     */
    protected abstract function createRepository(): MspRepository;

    /**
     * @return int
     */
    protected abstract function getExpectedPriority(): int;

    /**
     * @return Request
     */
    protected abstract function getExpectedMspRequest(): Request;

    /**
     * @return Response
     */
    protected abstract function getCorrectMspResponse(): Response;

    /**
     * @return mixed
     */
    protected abstract function getExpectedDecodedResult();

    public function test_fetchGyroStatus_mspRequestCorrect()
    {
        $callback = function (string $data) {
            $data = json_decode($data, true);
            self::assertArrayHasKey('data', $data);
            self::assertNotEmpty($data['data']);

            /** @var MSPRequestMessage $mspMessage */
            $mspMessage = unserialize($data['data'][0]);
            self::assertInstanceOf(MSPRequestMessage::class, $mspMessage);
            self::assertEquals($this->getExpectedMspRequest(), $mspMessage->getMspRequest());
            self::assertEquals($this->getExpectedPriority(), $mspMessage->getPriority());
        };

        $this->connectionA->expects(self::once())
            ->method('send')
            ->willReturnCallback($callback);

        $this->connectionB->expects(self::once())
            ->method('send')
            ->willReturnCallback($callback);

        $this->repository->sendRequests();
    }

    public function test_fetchGyroStatus_noConnection()
    {
        $this->repository->removeServer($this->serverA);

        $this->connectionA->expects(self::never())->method('send');
        $this->repository->sendRequests();
    }

    public function test_fetchGyroStatus_requestInProgress_bothConnections()
    {
        $this->repository->sendRequests();
        $this->connectionA->expects(self::never())->method('send');
        $this->connectionB->expects(self::never())->method('send');
        $this->repository->sendRequests();
    }

    public function test_sendRequests_requestInProgress_oneConnections()
    {
        $message = new MSPResponseMessage('test', $this->getCorrectMspResponse());

        $this->repository->sendRequests();
        $this->repository->onMspResponse($this->serverB, $message);

        $this->connectionA->expects(self::never())->method('send');
        $this->connectionB->expects(self::once())->method('send');
        $this->repository->sendRequests();
    }

    public function test_onMspResponse_decodedCorrectly()
    {
        $message = new MSPResponseMessage('test', $this->getCorrectMspResponse());
        $result = $this->repository->onMspResponse($this->serverA, $message);
        self::assertEquals($this->getExpectedDecodedResult(), $result);
    }

    public function test_onMspResponse_requestLockFreed()
    {
        $this->repository->sendRequests();

        $message = new MSPResponseMessage('test', $this->getCorrectMspResponse());
        $this->repository->onMspResponse($this->serverA, $message);

        $this->connectionA->expects(self::once())->method('send');

        $this->repository->sendRequests();
    }
}