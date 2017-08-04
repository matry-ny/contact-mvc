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
    const CONSOLE = 'CONSOLE';

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
    }

    public function run()
    {
        try {
            $dispatcher = APP_TYPE == self::WEB ? new WebDispatcher() : new ConsoleDispatcher();
            $answer = (new Router($dispatcher))->run();
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
}