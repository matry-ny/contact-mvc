<?php

namespace components\web;

use helpers\Config;

/**
 * Class Template
 * @package components\web
 */
class Template
{
    /**
     * @var string
     */
    public $layout = 'main';

    /**
     * @param string $template
     * @param array $variables
     * @return string
     * @throws \Exception
     */
    public function render($template, array $variables = [])
    {
        $templateRout = Config::getInstance()->get('template.templatesDir') . '/' . $template . '.php';
        if (!file_exists($templateRout)) {
            throw new \Exception("Template '{$template}' is not exists");
        }

        extract($variables);
        ob_start();
        require_once $templateRout;
        $content = ob_get_clean();

        $layoutRout = Config::getInstance()->get('template.layoutDir') . '/' . $this->layout . '.php';
        if (!file_exists($layoutRout)) {
            throw new \Exception("Layout '{$this->layout}' is not exists");
        }

        ob_start();
        require_once $layoutRout;
        return ob_get_clean();
    }
}
