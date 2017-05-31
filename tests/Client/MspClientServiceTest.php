<?php
namespace Volantus\FlightBase\Tests\Client;

use Volantus\FlightBase\Src\Client\Server;
use Volantus\FlightBase\Src\General\MSP\MspRepository;

/**
 * Class MspClientServiceTest
 *
 * @package Volantus\FlightBase\Tests\Client
 */
abstract class MspClientServiceTest extends ClientServiceTest
{
    /**
     * @var MspRepository[]|\PHPUnit_Framework_MockObject_MockObject[]
     */
    protected $mspRepositories = [];

    public function test_addServer_mspServer_addedToRepository()
    {
        $server = new Server($this->connection, Server::ROLE_MSP_BROKER_A);

        foreach ($this->mspRepositories as $repository) {
            $repository->expects(self::once())
                ->method('addServer')
                ->with(self::equalTo($server));
        }

        $this->service->addServer($server);
    }

    public function test_addServer_relayServer_notAddedToRepository()
    {
        $server = new Server($this->connection, Server::ROLE_RELAY_SERVER_A);

        foreach ($this->mspRepositories as $repository) {
            $repository->expects(self::never())
                ->method('addServer');
        }

        $this->service->addServer($server);
    }

    public function test_removeServer_mspServer_removedFromRepository()
    {
        $server = new Server($this->connection, Server::ROLE_MSP_BROKER_A);

        foreach ($this->mspRepositories as $repository) {
            $repository->expects(self::once())
                ->method('removeServer')
                ->with(self::equalTo($server));
        }

        $this->service->removeServer($server);
    }

    public function test_removeServer_relayServer_repositoryNotCalled()
    {
        $server = new Server($this->connection, Server::ROLE_RELAY_SERVER_A);

        foreach ($this->mspRepositories as $repository) {
            $repository->expects(self::never())
                ->method('removeServer');
        }

        $this->service->removeServer($server);
    }
}