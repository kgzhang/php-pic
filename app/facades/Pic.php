<?php

namespace App\facades;

/**
 * Class File
 *
 * @method static string loadDara($template, $data = [])
 * @package App\facades
 */

class Pic extends AbstractFacade
{
    protected static function getAccessor()
    {
        return \App\components\Pic::create();
    }
}
