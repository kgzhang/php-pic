<?php

namespace App\facades;

class View extends AbstractFacade
{
    protected static function getAccessor()
    {
        return \App\components\View::create();
    }
}
