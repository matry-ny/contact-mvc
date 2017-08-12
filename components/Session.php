<?php

namespace components;

/**
 * Class Session
 * @package components
 */
class Session
{
    /**
     * Session constructor.
     */
    public function __construct()
    {
        $sessionId = session_id();
        if (empty($sessionId)) {
            session_start();
        }
    }

    /**
     * @param string $key
     * @param string $message
     */
    public function addFlash($key, $message)
    {
        $_SESSION[$key] = $message;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function hasFlash($key)
    {
        return array_key_exists($key, $_SESSION);
    }

    /**
     * @param string $key
     * @param bool $clear
     * @return string|null
     */
    public function getFlash($key, $clear = true)
    {
        $flash = null;
        if ($this->hasFlash($key)) {
            $flash = $_SESSION[$key];

            if ($clear) {
                unset($_SESSION[$key]);
            }
        }

        return $flash;
    }
}