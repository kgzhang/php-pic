<?php

namespace App\components\browserShot;

/**
 * Class BrowserWrapper
 * @package App\components\browserShot
 */
class BrowserWrapper
{
    /**
     * @var
     */
    private $browser;
    /**
     * @var
     */
    private $needRelease;

    /**
     * @return mixed
     */
    public function getBrowser()
    {
        return $this->browser;
    }


    /**
     * @param $browser
     * @return $this
     */
    public function setBrowser($browser)
    {
        $this->browser = $browser;
        return $this;
    }

    /**
     * @param $name
     * @param $args
     * @return mixed
     */
    public function callBrowser($name, $args)
    {
        return call_user_func_array([$this->browser, $name], $args);
    }

    /**
     * @param $name
     * @param $args
     * @return mixed|null
     */
    public function __call($name, $args)
    {

        if (method_exists($this->browser, $name)) {
            return $this->callBrowser($name, $args);
        }
        return  null;
    }

    /**
     * @return bool
     */
    public function isNeedRelease()
    {
        return $this->needRelease;
    }

    /**
     * @param bool $needRelease
     * @return $this
     */
    public function setNeedRelease($needRelease = true)
    {
        $this->needRelease = $needRelease;
        return $this;
    }
}
