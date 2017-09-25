<?php

namespace api\components;

/**
 * Class Security
 * @package api\components
 */
class Security
{
    public function generateHash($key, array $data)
    {
        return password_hash($this->getDataString($key, $data), PASSWORD_DEFAULT);
    }

    /**
     * @param string $hash
     * @param string $key
     * @param array $data
     * @return bool
     */
    public function validateHash($hash, $key, array $data)
    {
        return password_verify($this->getDataString($key, $data), $hash);
    }

    /**
     * @param string $key
     * @param array $data
     * @return string
     */
    private function getDataString($key, array $data)
    {
        return serialize($data) . $key;
    }
}
