<?php
namespace Volante\SkyBukkit\Common\Tests\Client;

use Ratchet\Client\WebSocket;
use Volante\SkyBukkit\Common\Src\Client\ClientService;
use Volante\SkyBukkit\Common\Src\Client\Server;

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
     * @var WebSocket|\PHPUnit_Framework_MockObject_MockObject
     */
    private $connection;

    /**
     * @var Server
     */
    private $server;

    protected function setUp()
    {
        $this->service = new ClientService();
        /** @var WebSocket $connection */
        $this->connection = $this->getMockBuilder(WebSocket::class)->disableOriginalConstructor()->getMock();
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
}