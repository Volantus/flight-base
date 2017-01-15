<?php
namespace Volante\SkyBukkit\Common\Tests\Client;

use Ratchet\Client\WebSocket;
use Symfony\Component\Console\Tests\Fixtures\DummyOutput;
use Volante\SkyBukkit\Common\Src\Client\ClientService;
use Volante\SkyBukkit\Common\Src\Client\Server;
use Volante\SkyBukkit\Common\Src\General\GeoPosition\GeoPosition;
use Volante\SkyBukkit\Common\Src\General\GeoPosition\IncomingGeoPositionMessage;
use Volante\SkyBukkit\Common\Src\Server\Messaging\MessageService;

/**
 * Class ClientServiceTest
 * @package Volante\SkyBukkit\Common\Tests\Client
 */
class ClientServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ClientService
     */
    private $service;

    /**
     * @var MessageService|\PHPUnit_Framework_MockObject_MockObject
     */
    private $messageService;

    /**
     * @var WebSocket|\PHPUnit_Framework_MockObject_MockObject
     */
    private $connection;

    /**
     * @var DummyOutput|\PHPUnit_Framework_MockObject_MockObject
     */
    private $dummyOutput;

    /**
     * @var Server
     */
    private $server;

    protected function setUp()
    {
        /** @var WebSocket $connection */
        $this->connection = $this->getMockBuilder(WebSocket::class)->disableOriginalConstructor()->getMock();
        $this->messageService = $this->getMockBuilder(MessageService::class)->disableOriginalConstructor()->getMock();
        $this->dummyOutput = $this->getMockBuilder(DummyOutput::class)->disableOriginalConstructor()->getMock();

        $this->service = new ClientService($this->dummyOutput, $this->messageService);
        $this->server = new Server($this->connection, 'test');
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
            ->method('send')->with('{"type":"introduction","title":"Introduction","data":{"role":3}}');

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
}