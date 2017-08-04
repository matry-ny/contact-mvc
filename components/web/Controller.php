<?php

namespace components\web;

use components\Registry;

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
}
