<?php
namespace Volante\SkyBukkit\RleayServer\Tests\Messaging;

use Symfony\Component\Console\Tests\Fixtures\DummyOutput;
use Volante\SkyBukkit\Common\Src\Server\Authentication\AuthenticationMessage;
use Volante\SkyBukkit\Common\Src\Server\Messaging\MessageServerService;
use Volante\SkyBukkit\Common\Src\Server\Messaging\MessageService;
use Volante\SkyBukkit\Common\Src\Server\Network\Client;
use Volante\SkyBukkit\Common\Src\Server\Network\ClientFactory;
use Volante\SkyBukkit\Common\Src\General\Role\ClientRole;
use Volante\SkyBukkit\Common\Src\Server\Role\IntroductionMessage;
use Volante\SkyBukkit\Common\Tests\Server\General\DummyConnection;

/**
 * Class MessageServerServiceTest
 * @package Volante\SkyBukkit\RleayServer\Tests
 */
class MessageServerServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MessageServerService
     */
    protected $messageServerService;

    /**
     * @var MessageService|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $messageService;

    /**
     * @var ClientFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $clientFactory;

    /**
     * @var DummyConnection
     */
    protected $connection;

    /**
     * @var DummyOutput|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $dummyOutput;

    protected function setUp()
    {
        $this->connection = new DummyConnection();
        $this->clientFactory = $this->getMockBuilder(ClientFactory::class)->disableOriginalConstructor()->getMock();
        $this->messageService = $this->getMockBuilder(MessageService::class)->disableOriginalConstructor()->getMock();

        $this->dummyOutput = $this->getMockBuilder(DummyOutput::class)->disableOriginalConstructor()->getMock();
        $this->messageServerService = $this->createService();
    }

    /**
     * @return MessageServerService
     */
    protected function createService() : MessageServerService
    {
        return new MessageServerService($this->dummyOutput, $this->messageService, $this->clientFactory);
    }

    public function test_newClient_factoryCalled()
    {
        $this->clientFactory->expects(self::once())
            ->method('get')->with($this->connection)
            ->willReturn(new Client(1, $this->connection, -1));

        $this->messageServerService->newClient($this->connection);
    }

    public function test_removeClient_disconnected()
    {
        $this->clientFactory->expects(self::once())
            ->method('get')->with($this->connection)
            ->willReturn(new Client(1, $this->connection, -1));

        $this->messageServerService->newClient($this->connection);
        $this->messageServerService->removeClient($this->connection);

        self::assertTrue($this->connection->isConnectionClosed());
    }

    public function test_newMessage_clientNotConnected()
    {
        $outputLog = null;
        $this->dummyOutput->expects(self::once())
            ->method('writeLn')->willReturnCallback(function ($messages, $options = 0) use ($outputLog) {
                self::assertStringEndsWith('[<fg=cyan;options=bold>MessageServerService</>] <error>No connected client found!</error>', $messages);
            });

        $this->messageServerService->newMessage($this->connection, '123');
    }

    public function test_newMessage_messageServiceCalled()
    {
        $client = new Client(1, $this->connection, -1);
        $client->setAuthenticated();
        $this->clientFactory->method('get')->willReturn($client);

        $this->messageService->expects(self::once())
            ->method('handle')
            ->with($client, 'correct')->willReturn(new IntroductionMessage(new Client(1, $this->connection, -1), 99));

        $this->messageServerService->newClient($this->connection);
        $this->messageServerService->newMessage($this->connection, 'correct');
    }

    public function test_newMessage_introductionMessageHandledCorrectly()
    {
        $client = new Client(1, $this->connection, -1);
        $client->setAuthenticated();
        $this->clientFactory->method('get')->willReturn($client);

        $this->messageService->expects(self::once())
            ->method('handle')
            ->with($client, 'correct')->willReturn(new IntroductionMessage($client, ClientRole::OPERATOR));

        $this->messageServerService->newClient($this->connection);
        $this->messageServerService->newMessage($this->connection, 'correct');
        self::assertEquals(ClientRole::OPERATOR, $client->getRole());
    }

    public function test_newMessage_noAuthentication()
    {
        $client = new Client(1, $this->connection, -1);
        $this->clientFactory->method('get')->willReturn($client);

        $this->messageService->expects(self::once())
            ->method('handle')
            ->with($client, 'correct')->willReturn(new IntroductionMessage($client, ClientRole::OPERATOR));

        $this->messageServerService->newClient($this->connection);
        $this->messageServerService->newMessage($this->connection, 'correct');
        self::assertTrue($this->connection->isConnectionClosed());
    }

    public function test_newMessage_authenticationMessageHandledCorrectly_tokenWrong()
    {
        $client = new Client(1, $this->connection, -1);
        $this->clientFactory->method('get')->willReturn($client);

        $this->messageService->expects(self::once())
            ->method('handle')
            ->with($client, 'correct')->willReturn(new AuthenticationMessage($client, 'wrongToken'));

        $this->messageServerService->newClient($this->connection);
        $this->messageServerService->newMessage($this->connection, 'correct');
        self::assertFalse($client->isAuthenticated());
        self::assertTrue($this->connection->isConnectionClosed());
    }

    public function test_newMessage_authenticationMessageHandledCorrectly_tokenCorrect()
    {
        $client = new Client(1, $this->connection, -1);
        $this->clientFactory->method('get')->willReturn($client);

        $this->messageService->expects(self::once())
            ->method('handle')
            ->with($client, 'correct')->willReturn(new AuthenticationMessage($client, 'correctToken'));

        $this->messageServerService->newClient($this->connection);
        $this->messageServerService->newMessage($this->connection, 'correct');
        self::assertTrue($client->isAuthenticated());
    }
}