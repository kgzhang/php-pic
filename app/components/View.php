<?php

namespace App\components;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class View
{
    protected static $instance;

    private $view;
    private $config;
    private $cache;

    public static function create()
    {
        if (self::$instance instanceof self) {
            return self::$instance;
        }
        return self::$instance = new self();
    }

    public function __construct()
    {
        $this->config = Config::get('template.templates_path');
        $this->cache = Config::get('template.templates_cache');
        $this->view = $this->createView();
    }

    public function createView()
    {
        $loader = new FilesystemLoader((string) $this->config);
//        return self::$instance = new Environment($loader, [
//            'cache' => $this->cache
//        ]);

        return self::$instance = new Environment($loader);
    }

    public function render($template, $context)
    {
        $name = $template . '.html.twig';
        return $this->view->render($name, $context);
    }
}
