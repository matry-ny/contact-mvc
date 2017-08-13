<?php

namespace components\web;

/**
 * Interface Authorizable
 * @package components\web
 */
interface Authorizable
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @param string $token
     */
    public function setAuthToken($token);

    /**
     * @return string
     */
    public function getAuthToken();
}