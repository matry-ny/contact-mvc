<?php

namespace components\api;

use api\components\Security;
use components\Registry;
use Exception;
use helpers\ArrayHelper;
use helpers\Behaviors;
use helpers\Request;

/**
 * Class Controller
 * @package components\api
 */
abstract class Controller extends \components\Controller
{
    public function __construct()
    {
        $protocols = ArrayHelper::getValue($this->behaviors(), Behaviors::PROTOCOLS, []);
        $requiredMethod = ArrayHelper::getValue($protocols, $this->getCalledMethod()) ?: Request::GET;

        if (strtolower($requiredMethod) !== strtolower($_SERVER['REQUEST_METHOD'])) {
            throw new Exception('Wrong request method used');
        }

        $userId = Request::getHeader('UserId');
        if (empty($userId)) {
            throw new Exception('User is not detected');
        }

        $userKey = $this->getConfig()->get("users.{$userId}");
        if (empty($userKey)) {
            throw new Exception('User is not valid');
        }

        $userHash = Request::getHeader('SecurityHash');
        $isValidHash = $this->getSecurity()->validateHash($userHash, $userKey, $this->getRouter()->getDispatcher()->getParams());
        if (!$isValidHash) {
            throw new Exception('Not valid request');
        }
    }

    /**
     * @return array
     */
    protected function behaviors()
    {
        return [];
    }

    /**
     * @return \components\Session
     */
    protected function getSession()
    {
        return Registry::get('session');
    }

    /**
     * @return Security
     */
    protected function getSecurity()
    {
        return new Security();
    }
}
