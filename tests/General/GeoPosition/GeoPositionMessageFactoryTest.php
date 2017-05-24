<?php
namespace Volantus\FlightBase\Tests\General\GeoPosition;

use Volantus\FlightBase\Src\General\GeoPosition\GeoPosition;
use Volantus\FlightBase\Src\General\GeoPosition\GeoPositionMessageFactory;
use Volantus\FlightBase\Src\General\GeoPosition\IncomingGeoPositionMessage;
use Volantus\FlightBase\Src\Server\Messaging\IncomingMessage;
use Volantus\FlightBase\Src\Server\Network\NetworkRawMessage;
use Volantus\FlightBase\Tests\Server\General\MessageFactoryTestCase;

/**
 * Class GeoPositionMessageFactoryTest
 * @package Volantus\FlightBase\Tests\General\GeoPosition
 */
class GeoPositionMessageFactoryTest extends MessageFactoryTestCase
{
    /**
     * @var GeoPositionMessageFactory
     */
    private $factory;

    protected function setUp()
    {
        parent::setUp();
        $this->factory = new GeoPositionMessageFactory();
    }

    public function test_create_latitudeMissing()
    {
        $this->validateMissingKey('latitude');
    }

    public function test_create_longitudeMissing()
    {
        $this->validateMissingKey('altitude');
    }

    public function test_create_altitudeMissing()
    {
        $this->validateMissingKey('altitude');
    }

    public function test_create_latitudeNotNumeric()
    {
        $this->validateNotNumeric('latitude');
    }

    public function test_create_longitudeNotNumeric()
    {
        $this->validateNotNumeric('altitude');
    }

    public function test_create_altitudeNotNumeric()
    {
        $this->validateNotNumeric('altitude');
    }

    public function test_create_correct()
    {
        $message = $this->getRawMessage($this->getCorrectMessageData());
        $result = $this->factory->create($message);

        self::assertInstanceOf(IncomingGeoPositionMessage::class, $result);
        self::assertEquals(1.123991, $result->getGeoPosition()->getLatitude());
        self::assertEquals(40.123123, $result->getGeoPosition()->getLongitude());
        self::assertEquals(400.13, $result->getGeoPosition()->getAltitude());
    }

    /**
     * @return string
     */
    protected function getMessageType(): string
    {
        return GeoPosition::TYPE;
    }

    /**
     * @param NetworkRawMessage $rawMessage
     * @return mixed
     */
    protected function callFactory(NetworkRawMessage $rawMessage): IncomingMessage
    {
        return $this->factory->create($rawMessage);
    }

    /**
     * @return array
     */
    protected function getCorrectMessageData(): array
    {
        return [
            'latitude' => 1.123991,
            'longitude' => 40.123123,
            'altitude' => 400.13
        ];
    }
}