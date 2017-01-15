<?php
namespace Volante\SkyBukkit\Common\Src\Client;

use Volante\SkyBukkit\Common\Src\General\Role\ClientRole;

/**
 * Class ClientService
 * @package Volante\SkyBukkit\Common\Src\Client
 */
class ClientService
{
    /**
     * @var Server[]
     */
    private $servers = [];

    public function addServer(Server $server)
    {
        $this->servers[$server->getRole()] = $server;
        $this->initServer($server);
    }

    /**
     * @param Server $server
     */
    public function removeServer(Server $server)
    {
        unset($this->servers[$server->getRole()]);
    }

    /**
     * @param string $serverRole
     * @return bool
     */
    public function isConnected(string $serverRole) : bool
    {
        return array_key_exists($serverRole, $this->servers);
    }

    /**
     * @param Server $server
     */
    private function initServer(Server $server)
    {
        $authentication = (new AuthenticationMessage(getenv('AUTH_TOKEN')))->toRawMessage();
        $server->getConnection()->send((json_encode($authentication)));

        $introduction = (new IntroductionMessage(ClientRole::STATUS_BROKER))->toRawMessage();
        $server->getConnection()->send(json_encode($introduction));
    }
}