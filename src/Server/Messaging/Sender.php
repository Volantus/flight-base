<?php
namespace Volante\SkyBukkit\Common\Src\Server\Messaging;

/**
 * Interface Sender
 * @package Volante\SkyBukkit\Common\Src\Server\Messaging
 */
interface Sender
{
    /**
     * @return bool
     */
    public function isAuthenticated(): bool;

    /**
     * @return int|string
     */
    public function getRole();

    /**
     * @return int
     */
    public function getId();

    /**
     * @param string $data
     * @return mixed
     */
    public function send(string $data);
}