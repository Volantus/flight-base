<?php
namespace Volantus\FlightBase\Tests\General\Network;

use Volantus\FlightBase\Src\General\Network\BaseRawMessage;

/**
 * Class MessageFactoryTest
 *
 * @package Volante\SkyBukkit\Monitor\Tests\Message
 */
class MessageFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RawMessageFactory
     */
    private $factory;

    protected function setUp()
    {
        $this->factory = new RawMessageFactory();
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid message format: invalid json format
     */
    public function test_create_invalidJson()
    {
        $this->factory->createFromJson('abc');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid message format: attribute <type> missing
     */
    public function test_create_typeMissing()
    {
        $data = $this->getCorrectMessage();
        unset($data['type']);
        $this->factory->createFromJson(json_encode($data));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid message format: attribute <title> missing
     */
    public function test_create_titleMissing()
    {
        $data = $this->getCorrectMessage();
        unset($data['title']);
        $this->factory->createFromJson(json_encode($data));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid message format: attribute <data> missing
     */
    public function test_create_dataMissing()
    {
        $data = $this->getCorrectMessage();
        unset($data['data']);
        $this->factory->createFromJson(json_encode($data));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid message format: attribute <type> is empty
     */
    public function test_create_typeEmpty()
    {
        $data = $this->getCorrectMessage();
        $data['type'] = '';
        $this->factory->createFromJson(json_encode($data));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid message format: attribute <title> is empty
     */
    public function test_create_titleEmpty()
    {
        $data = $this->getCorrectMessage();
        $data['title'] = '';
        $this->factory->createFromJson(json_encode($data));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid message format: attribute <type> is not a string
     */
    public function test_create_typeNoString()
    {
        $data = $this->getCorrectMessage();
        $data['type'] = [1];
        $this->factory->createFromJson(json_encode($data));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid message format: attribute <title> is not a string
     */
    public function test_create_titleNoString()
    {
        $data = $this->getCorrectMessage();
        $data['title'] = [1];
        $this->factory->createFromJson(json_encode($data));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid message format: attribute <data> is not an array
     */
    public function test_create_dataNotArray()
    {
        $data = $this->getCorrectMessage();
        $data['data'] = 'abc';
        $this->factory->createFromJson(json_encode($data));
    }

    public function test_create_correctMessage()
    {
        $data = $this->getCorrectMessage();
        $data = json_encode($data);
        $message = $this->factory->createFromJson($data);

        self::assertInstanceOf(BaseRawMessage::class, $message);
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