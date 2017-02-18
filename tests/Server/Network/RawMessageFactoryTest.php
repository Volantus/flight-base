<?php
namespace Volante\SkyBukkit\RleayServer\Tests\Message;

use Volante\SkyBukkit\Common\Src\Server\Network\Client;
use Volante\SkyBukkit\Common\Src\Server\Network\NetworkRawMessage;
use Volante\SkyBukkit\Common\Src\Server\Network\RawMessageFactory;
use Volante\SkyBukkit\Common\Tests\Server\General\DummyConnection;

/**
 * Class MessageFactoryTest
 *
 * @package Volante\SkyBukkit\Monitor\Tests\Message
 */
class RawMessageFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RawMessageFactory
     */
    private $factory;

    /**
     * @var Client
     */
    private $sender;

    protected function setUp()
    {
        $this->factory = new RawMessageFactory();
        $this->sender = new Client(1, new DummyConnection(), 99);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid message format: invalid json format
     */
    public function test_create_invalidJson()
    {
        $this->factory->create($this->sender, 'abc');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid message format: attribute <type> missing
     */
    public function test_create_typeMissing()
    {
        $data = $this->getCorrectMessage();
        unset($data['type']);
        $this->factory->create($this->sender, json_encode($data));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid message format: attribute <title> missing
     */
    public function test_create_titleMissing()
    {
        $data = $this->getCorrectMessage();
        unset($data['title']);
        $this->factory->create($this->sender, json_encode($data));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid message format: attribute <data> missing
     */
    public function test_create_dataMissing()
    {
        $data = $this->getCorrectMessage();
        unset($data['data']);
        $this->factory->create($this->sender, json_encode($data));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid message format: attribute <type> is empty
     */
    public function test_create_typeEmpty()
    {
        $data = $this->getCorrectMessage();
        $data['type'] = '';
        $this->factory->create($this->sender, json_encode($data));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid message format: attribute <title> is empty
     */
    public function test_create_titleEmpty()
    {
        $data = $this->getCorrectMessage();
        $data['title'] = '';
        $this->factory->create($this->sender, json_encode($data));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid message format: attribute <type> is not a string
     */
    public function test_create_typeNoString()
    {
        $data = $this->getCorrectMessage();
        $data['type'] = [1];
        $this->factory->create($this->sender, json_encode($data));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid message format: attribute <title> is not a string
     */
    public function test_create_titleNoString()
    {
        $data = $this->getCorrectMessage();
        $data['title'] = [1];
        $this->factory->create($this->sender, json_encode($data));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid message format: attribute <data> is not an array
     */
    public function test_create_dataNotArray()
    {
        $data = $this->getCorrectMessage();
        $data['data'] = 'abc';
        $this->factory->create($this->sender, json_encode($data));
    }

    public function test_create_correctMessage()
    {
        $data = $this->getCorrectMessage();
        $data = json_encode($data);
        $message = $this->factory->create($this->sender, $data);

        self::assertInstanceOf(NetworkRawMessage::class, $message);
        self::assertEquals('dummyMessage', $message->getType());
        self::assertEquals('This is a dummy message', $message->getTitle());
        self::assertEquals(['key01' => '123'], $message->getData());
    }

    /**
     * @return array
     */
    private function getCorrectMessage() : array
    {
        return [
            'type'  => 'dummyMessage',
            'title' => 'This is a dummy message',
            'data' => [
                'key01' => '123'
            ]
        ];
    }
}