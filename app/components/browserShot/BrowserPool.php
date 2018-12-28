<?php

namespace App\components\browserShot;

use App\components\Config;
use Nesk\Puphpeteer\Puppeteer;

class BrowserPool
{
    protected static $instance;

    private $browserPool = [];

    private $pool_size = 1;

    public static function create()
    {
        if (self::$instance instanceof self) {
            return self::$instance;
        }
        return self::$instance = new self();
    }

    public function __construct()
    {
        $this->pool_size = Config::get('screenshots.pool_size');

        for($i = 0; $i < $this->pool_size; ++$i) {
            $this->browserPool[] = $this->getConnect();
        }
    }

    public function pick()
    {
        $browser = array_pop($this->browserPool);
        if (!$browser) {
            $browser = $this->getConnect(false);
        }
        return $browser;
    }

    /**
     * @param BrowserWrapper $browser
     */
    public function release($browser)
    {
        if ($browser->isNeedRelease()) {
            $this->browserPool[] = $browser;
        }
    }

    public function __destruct()
    {
        foreach ($this->browserPool as $browser) {
            $browser->close();
        }
    }


    public function getConnect($needRelease = true)
    {
//       TODO 可以在这里做一些puppeteer初始化的工作
        $puppeteer = new Puppeteer;
        $browser = $puppeteer->launch();
//        $browser = $puppeteer->newPage();
//        $browser = new Puppeteer;
        return (new BrowserWrapper())->setBrowser($browser)->setNeedRelease($needRelease);
    }

    public function countPool ()
    {
        return count($this->browserPool);
    }

}
