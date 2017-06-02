<?php
namespace Volantus\FlightBase\Src\Client;

use Symfony\Component\Console\Output\OutputInterface;
use Volantus\FlightBase\Src\General\MSP\MspServerBased;
use Volantus\FlightBase\Src\Server\Messaging\MessageService;

/**
 * Class MspClientService
 *
 * @package Volantus\FlightBase\Src\Client
 */
class MspClientService extends ClientService
{
    /**
     * @var MspServerBased[]
     */
    protected $mspRepositories = [];

    /**
     * MspClientService constructor.
     *
     * @param OutputInterface  $output
     * @param MessageService   $messageService
     * @param MspServerBased[] $mspRepositories List of MSP based services for easier connection management
     */
    public function __construct(OutputInterface $output, MessageService $messageService, array $mspRepositories = [])
    {
        parent::__construct($output, $messageService);

        $this->mspRepositories = $mspRepositories;
    }

    /**
     * @param Server $server
     */
    public function addServer(Server $server)
    {
        parent::addServer($server);

        if ($server->isMspServer()) {
            foreach ($this->mspRepositories as $repository) {
                $repository->addServer($server);
            }
        }
    }

    /**
     * @param Server $server
     */
    public function removeServer(Server $server)
    {
        parent::removeServer($server);

        if ($server->isMspServer()) {
            foreach ($this->mspRepositories as $repository) {
                $repository->removeServer($server);
            }
        }
    }
}