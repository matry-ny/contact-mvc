<?php

namespace components\web;

use components\Registry;
use helpers\Url;

/**
 * Class Controller
 * @package components\web
 */
abstract class Controller extends \components\Controller
{
    /**
     * @param string $view
     * @param array $variables
     * @param null|string $layout
     * @return string
     */
    protected function render($view, array $variables = [], $layout = null)
    {
        /** @var Template $template */
        $template = Registry::get('template');
        if ($layout) {
            $template->layout = $layout;
        }

        $view = $this->getCalledController() . '/' . $view;
        return $template->render($view, $variables);
    }

    /**
     * @param string $url
     * @param int $code
     * @param bool $terminate
     */
    protected function redirect($url, $code = 301, $terminate = true)
    {
        $url = Url::prepare($url);
        header("Location: {$url}", true, $code);
        if ($terminate) {
            exit;
        }
    }

    /**
     * @return \components\Session
     */
    protected function getSession()
    {
        return Registry::get('session');
    }
}
