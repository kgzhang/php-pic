<?php

namespace App\facades;

/**
 * Class File
 *
 * @method static string loadDara($template, $data = [])
 * @package App\facades
 */

class BrowserShot extends AbstractFacade
{
    protected static function getAccessor()
    {
        return \App\components\browserShot\BrowserPool::create();
    }
}
