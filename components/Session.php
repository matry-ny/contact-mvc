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
     * @param mixed $value
     */
    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * @param string $key
     * @param null|mixed $default
     * @return null|mixed
     */
    public function get($key, $default = null)
    {
        return array_key_exists($key, $_SESSION) ? $_SESSION[$key] : $default;
    }

    /**
     * @param string $key
     */
    public function delete($key)
    {
        if (array_key_exists($key, $_SESSION)) {
            unset($_SESSION[$key]);
        }
    }

    /**
     * @param string $key
     * @param string $message
     */
    public function addFlash($key, $message)
    {
        $this->set($key, $message);
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
            $flash = $this->get($key);

            if ($clear) {
                $this->delete($key);
            }
        }

        return $flash;
    }
}