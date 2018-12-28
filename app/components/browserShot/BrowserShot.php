<?php

/**
 * 对browserShot的更改，主要实现的内容有
 * 1， 实现进程池，方便随时调用
 * 2， 复用之前的接口逻辑，最小的php代码改动
 */

namespace App\components\browserShot;

class BrowserShot
{
    /**
     * 启动多进程puppeteer，这个需要在项目创建的时候就启动
     * */
    public function launch()
    {
        return $this;
    }


    /**
     * 挑出队列的最后一个渲染进程，目前应该是由js端完成
     */
    public function pick()
    {

    }

    /**
     * 保存为图片
     */
    public function save()
    {

    }
}
