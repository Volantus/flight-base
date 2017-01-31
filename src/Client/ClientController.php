<?php
namespace Volante\SkyBukkit\Common\Src\Client;

use Ratchet\Client\Connector;
use Ratchet\Client\WebSocket;
use React\EventLoop\ExtEventLoop;
use React\EventLoop\Factory;
use Symfony\Component\Console\Output\OutputInterface;
use Volante\SkyBukkit\Common\Src\General\CLI\OutputOperations;

class ClientController
{
    use OutputOperations;

    /**
     * @var ExtEventLoop
     */
    protected $loop;

    /**
     * @var ClientService
     */
    protected $service;

    /**
     * @var array
     */
    protected $connections = [];

    /**
     * Controller constructor.
     * @param OutputInterface $output
     * @param ClientService $service
     */
    public function __construct(OutputInterface $output, ClientService $service = null)
    {
        $this->output = $output;
        $this->loop = Factory::create();
        $this->service = $service;
    }

    public function run()
    {
        $this->writeInfoLine('Controller', 'Starting event loop ...');

        foreach ($this->connections as $role => $address) {
            $this->connect($address, $role);
        }
        $this->loop->run();
    }

    /**
     * @param int $role
     * @param string $address
     */
    protected function registerConnection(int $role, string $address)
    {
        $this->connections[$role] = $address;
    }

    /**
     * @param string $address
     * @param int $role
     */
    private function connect(string $address, int $role)
    {
        $this->writeInfoLine('Controller', 'Connecting to server ' . $role . ' => ' . $address);

        $connector = new Connector($this->loop);
        $connector($address)
            ->then(function (WebSocket $conn) use ($address, $role) {
                $server = new Server($conn, $role);
                $conn->on('close', function ($code = null, $reason = null) use ($server, $address, $role) {
                    $this->service->removeServer($server);
                    $this->writeErrorLine('Controller', "Connection to server " . $server->getRole() . " closed.");
                    $this->connect($address, $role);
                });

                $conn->on('message', function($msg) use ($conn) {
                    $this->service->newMessage($conn, $msg);
                });

                $this->writeInfoLine('Controller', 'Connection to server ' . $role . ' was successful.');
                $this->service->addServer($server);
            }, function (\Exception $e) use ($address, $role) {
                $this->writeErrorLine('Controller', "Unable to connect to server " . $address . ": " . $e->getMessage());
                $this->loop->addTimer(1, function() use ($address, $role) {$this->connect($address, $role);});
            });
    }
}