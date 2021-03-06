<?php
namespace Volantus\FlightBase\Tests\Client;

use Ratchet\Client\WebSocket;
use Symfony\Component\Console\Tests\Fixtures\DummyOutput;
use Volantus\FlightBase\Src\Client\ClientService;
use Volantus\FlightBase\Src\Client\Server;
use Volantus\FlightBase\Src\General\GeoPosition\GeoPosition;
use Volantus\FlightBase\Src\General\GeoPosition\IncomingGeoPositionMessage;
use Volantus\FlightBase\Src\Server\Messaging\MessageService;

/**
 * Class ClientServiceTest
 * @package Volantus\FlightBase\Tests\Client
 */
class ClientServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ClientService
     */
    protected $service;

    /**
     * @var MessageService|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $messageService;

    /**
     * @var WebSocket|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $connection;

    /**
     * @var DummyOutput|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $dummyOutput;

    /**
     * @var Server
     */
    protected $server;

    protected function setUp()
    {
        /** @var WebSocket $connection */
        $this->connection = $this->getMockBuilder(WebSocket::class)->disableOriginalConstructor()->getMock();
        $this->messageService = $this->getMockBuilder(MessageService::class)->disableOriginalConstructor()->getMock();
        $this->dummyOutput = $this->getMockBuilder(DummyOutput::class)->disableOriginalConstructor()->getMock();
        $this->server = new Server($this->connection, 99);

        $this->service = $this->createService();
    }

    /**
     * @return ClientService
     */
    protected function createService() : ClientService
    {
        return new ClientService($this->dummyOutput, $this->messageService);
    }

    public function test_addServer_connected()
    {
        $this->service->addServer($this->server);
        self::assertTrue($this->service->isConnected($this->server->getRole()));
    }

    public function test_addServer_authenticationSend()
    {
        $this->connection->expects(self::at(0))
            ->method('send')->with('{"type":"authentication","title":"Authentication","data":{"token":"correctToken"}}');

        $this->service->addServer($this->server);
    }

    public function test_addServer_introductionSend()
    {
        $this->connection->expects(self::at(1))
            ->method('send')->with('{"type":"introduction","title":"Introduction","data":{"role":' . $this->getExpectedClientRole() . '}}');

        $this->service->addServer($this->server);
    }

    public function test_removeServer_notConnected()
    {
        $this->service->addServer($this->server);
        $this->service->removeServer($this->server);
        self::assertFalse($this->service->isConnected($this->server->getRole()));
    }

    public function test_isConnected_false()
    {
        self::assertFalse($this->service->isConnected($this->server->getRole()));
    }

    public function test_newMessage_serverNotConnected()
    {
        $outputLog = null;
        $this->dummyOutput->expects(self::once())
            ->method('writeLn')->willReturnCallback(function ($messages, $options = 0) use ($outputLog) {
                self::assertStringEndsWith('[<fg=cyan;options=bold>ClientService</>] <error>No connected server found!</error>', $messages);
            });

        $this->service->newMessage($this->connection, '123');
    }

    public function test_newMessage_messageServiceCalled()
    {
        $this->messageService->expects(self::once())
            ->method('handle')
            ->with($this->server, 'correct')->willReturn(new IncomingGeoPositionMessage($this->server, new GeoPosition(1, 2, 3)));

        $this->service->addServer($this->server);
        $this->service->newMessage($this->connection, 'correct');
    }

    /**
     * @return int
     */
    protected function getExpectedClientRole() : int
    {
        return -1;
    }
}