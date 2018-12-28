<?php

namespace App\components;

use Spatie\Browsershot\Browsershot;
//use App\components\browser\src\Browsershot;
use App\facades\View as FacadeView;

class Pic {
    protected static $instance;


    private $bg = null;
    private $template;
    private $data = [];
    private $hash = '';
    private $content = '';
    private $public_path;


    public static function create()
    {
        if (self::$instance instanceof self) {
            return self::$instance;
        }

        return self::$instance = new self();
    }

    public function __construct()
    {
        $this->public_path = Config::get('screenshots.public_path');
        $this->pic_bgs = Config::get('screenshots.pic_bgs');
    }

    public function loadData($template, $data)
    {
        $this->template = $template;

        if ($template) {
            if (!empty($data)) {
                $this->hash = md5($data);
                $this->data = json_decode($data, true);

                if (key_exists('bg', $this->data)) {
                    $bg = $this->data['bg'];
                    $cacheKey = $bg . '_bgs';
                    if (file_exists('redis://' . $bg)) {
                        $bg_image = file_get_contents('redis://' . $cacheKey);
                    } else {
                        $bg_image = 'data:image/svg+xml;base64,' . base64_encode(file_get_contents($this->pic_bgs . $bg . '.svg'));
                        file_put_contents('redis://' . $cacheKey, $bg_image);
                    }
                    $this->bg = $bg_image;
                }
            }
        }

        return $this;
    }
    /*
    * 生成图片
    * */
    public function generate()
    {
        if (file_exists('redis://' . $this->hash)) {
            $screenShot = file_get_contents('redis://' . $this->hash);
        } else {
            $render = FacadeView::render($this->template, [
                'data' => $this->data,
                'bg' => $this->bg
            ]);

            $this->content = (string) $render;
            $screenShot = $this->hash . '.jpg';
            Browsershot::html($this->content)
                ->noSandbox()
                ->setNodeModulePath(env('NODE_MODULE_PATH'))
                ->setScreenshotType('jpeg', 20)
                ->setNodeBinary(env('NODE_PATH'))
                ->setNpmBinary(env('NPM_PATH'))
                ->fullPage()
                ->setDelay(1000)
                ->windowSize(375, 200)
                ->deviceScaleFactor(3)
                ->save($this->public_path . $screenShot);
            file_put_contents('redis://' . $this->hash, $screenShot);
        }

        return $screenShot;
    }
}
