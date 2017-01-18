<?php
namespace Volante\SkyBukkit\Common\Src\Server\Messaging;

/**
 * Interface Sender
 * @package Volante\SkyBukkit\Common\Src\Server\Messaging
 */
interface Sender
{

    public function setAuthenticated();

    /**
     * @return bool
     */
    public function isAuthenticated(): bool;

    /**
     * @return int|string
     */
    public function getRole();

    /**
     * @param int|string $role
     */
    public function setRole($role);

    /**
     * @return int
     */
    public function getId();

    /**
     * @param string $data
     */
    public function send(string $data);

    public function disconnect();
}