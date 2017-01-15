<?php
namespace Volante\SkyBukkit\Common\Src\General\GeoPosition;

use Volante\SkyBukkit\Common\Src\Server\Authentication\AuthenticationMessageFactory;
use Volante\SkyBukkit\Common\Src\Server\Messaging\MessageService;
use Volante\SkyBukkit\Common\Src\Server\Network\RawMessageFactory;
use Volante\SkyBukkit\Common\Src\Server\Role\IntroductionMessageFactory;

/**
 * Class GeoPositionMessageService
 * @package Volante\SkyBukkit\Common\Src\General\GeoPosition
 */
class GeoPositionMessageService extends MessageService
{
    /**
     * MessageService constructor.
     * @param RawMessageFactory|null $rawMessageFactory
     * @param IntroductionMessageFactory|null $introductionMessageFactory
     * @param AuthenticationMessageFactory|null $authenticationMessageFactory
     * @param GeoPositionMessageFactory $geoPositionMessageFactory
     */
    public function __construct(RawMessageFactory $rawMessageFactory = null, IntroductionMessageFactory $introductionMessageFactory = null, AuthenticationMessageFactory $authenticationMessageFactory = null, GeoPositionMessageFactory $geoPositionMessageFactory = null)
    {
        parent::__construct($rawMessageFactory, $introductionMessageFactory, $authenticationMessageFactory);
        $this->registerFactory($geoPositionMessageFactory ?: new GeoPositionMessageFactory());
    }
}