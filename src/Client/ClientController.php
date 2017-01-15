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
    private $loop;

    /**
     * @var ClientService
     */
    private $service;

    /**
     * @var array
     */
    private $connections = [];

    /**
     * Controller constructor.
     * @param OutputInterface $output
     * @param ClientService $service
     */
    public function __construct(OutputInterface $output, ClientService $service = null)
    {
        $this->output = $output;
        $this->loop = Factory::create();
        $this->service = $service ?: new $service();
    }

    public function run()
    {
        $this->writeInfoLine('Controller', 'Starting event loop ...');

        $this->loop->addPeriodicTimer(1, function () {
            $this->checkConnections();
        });
        $this->loop->run();
    }

    /**
     * @param string $role
     * @param string $address
     */
    protected function registerConnection(string $role, string $address)
    {
        $this->connections[$role] = $address;
    }

    /**
     * @param string $address
     * @param string $role
     */
    private function connect(string $address, string $role)
    {
        $this->writeInfoLine('Controller', 'Connecting to server ' . $role . ' => ' . $address);

        $connector = new Connector($this->loop);
        $connector($address)
            ->then(function (WebSocket $conn) use ($address, $role) {
                $server = new Server($conn, $role);
                $conn->on('close', function ($code = null, $reason = null) use ($server, $address, $role) {
                    $this->service->removeServer($server);
                    $this->writeErrorLine('Controller', "Connection to server " . $server->getRole() . " closed.");
                });

                $conn->on('message', function($msg) use ($conn) {
                    echo "Received: {$msg}\n";
                    $conn->close();
                });

                $this->writeInfoLine('Controller', 'Connection to server ' . $role . ' was successful.');
                $this->service->addServer($server);
            }, function (\Exception $e) use ($address, $role) {
                $this->writeErrorLine('Controller', "Unable to connect to server " . $address . ": " . $e->getMessage());
            });
    }

    private function checkConnections()
    {
        foreach ($this->connections as $role => $address) {
            if (!$this->service->isConnected($role)) {
                $this->connect($address, $role);
            }
        }
    }
}