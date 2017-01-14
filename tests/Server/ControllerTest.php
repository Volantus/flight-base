<?php
namespace Volante\SkyBukkit\Common\Tests\Server;

use Symfony\Component\Console\Tests\Fixtures\DummyOutput;
use Volante\SkyBukkit\Common\Src\Server\Controller;
use Volante\SkyBukkit\Common\Src\Server\Messaging\MessageServerService;
use Volante\SkyBukkit\Common\Tests\Server\General\DummyConnection;

/**
 * Class ControllerTest
 * @package Volante\SkyBukkit\Common\Tests\Server
 */
class ControllerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MessageServerService|\PHPUnit_Framework_MockObject_MockObject
     */
    private $relayService;

    /**
     * @var Controller
     */
    private $controller;

    protected function setUp()
    {
        $this->relayService = $this->getMockBuilder(MessageServerService::class)->disableOriginalConstructor()->getMock();
        $this->controller = new Controller(new DummyOutput(), $this->relayService);
    }

    public function test_onOpen_serviceCalled()
    {
        $connection = new DummyConnection();
        $this->relayService->expects(self::once())
            ->method('newClient')->with($connection);

        $this->controller->onOpen($connection);
    }

    public function test_onMessage_serviceCalled()
    {
        $connection = new DummyConnection();
        $this->relayService->expects(self::once())
            ->method('newMessage')->with($connection, 'correct');

        $this->controller->onMessage($connection, 'correct');
    }

    public function test_onClose_serviceCalled()
    {
        $connection = new DummyConnection();
        $this->relayService->expects(self::once())
            ->method('removeClient')->with($connection);

        $this->controller->onClose($connection);
    }

    public function test_onError_serviceCalled()
    {
        $connection = new DummyConnection();
        $this->relayService->expects(self::once())
            ->method('removeClient')->with($connection);

        $this->controller->onError($connection, new \RuntimeException('test'));
    }
}