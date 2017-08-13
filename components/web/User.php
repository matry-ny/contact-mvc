<?php

namespace components\web;

use components\Registry;

/**
 * Class User
 * @package components\web
 */
class User
{
    /**
     * @return bool
     */
    public function getIsGuest()
    {
        return empty(Registry::get('session')->get('user'));
    }

    /**
     * @return Authorizable|null
     */
    public function getModel()
    {
        return Registry::get('session')->get('user');
    }

    /**
     * @param Authorizable $user
     */
    public function authenticate(Authorizable $user)
    {
        $user->setAuthToken(self::generateAuthToken($user->getId()));
        Registry::get('session')->set('user', $user);
    }

    public function logOut()
    {
        Registry::get('session')->delete('user');
    }

    /**
     * @param string $password
     * @param string $hash
     * @return bool
     */
    public static function isValidPassword($password, $hash)
    {
        return $hash === self::generatePasswordHash($password);
    }

    /**
     * @param string $password
     * @return string
     */
    public static function generatePasswordHash($password)
    {
        return md5($password);
    }

    /**
     * @param int $userId
     * @return string
     */
    public static function generateAuthToken($userId)
    {
        return md5(uniqid() . $userId . time());
    }
}
