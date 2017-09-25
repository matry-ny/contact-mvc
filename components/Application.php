<?php

namespace components;

use helpers\Config;
use components\console\Dispatcher as ConsoleDispatcher;
use components\web\Dispatcher as WebDispatcher;

/**
 * Class Application
 * @package components
 */
abstract class Application
{
    const WEB = 'WEB';
    const ADMIN = 'ADMIN';
    const CONSOLE = 'CONSOLE';
    const API = 'API';

    /**
     * Application constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        Config::getInstance()->set($config);

        Registry::set('db', new Database(
            Config::getInstance()->get('db.host'),
            Config::getInstance()->get('db.user'),
            Config::getInstance()->get('db.password'),
            Config::getInstance()->get('db.name')
        ));

        $router = new Router($this->getDispatcher());
        Registry::set('router', $router);
    }

    public function run()
    {
        try {
            $answer = Registry::get('router')->run();
            if (is_string($answer)) {
                echo $answer;
            } else {
                throw new \Exception('Unexpected data processed');
            }
        } catch (\Exception $exception) {
            echo $exception->getMessage();
        }

        exit;
    }

    /**
     * @return ConsoleDispatcher|WebDispatcher
     */
    private function getDispatcher()
    {
        switch (APP_TYPE) {
            case self::CONSOLE:
                return new ConsoleDispatcher();
            default:
                return new WebDispatcher();
        }
    }
}