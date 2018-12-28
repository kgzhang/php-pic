<?php

namespace App\services;

use App\components\Request;
use App\components\Response;
use App\facades\BrowserShot;
use App\facades\Pic;
use Nesk\Puphpeteer\Puppeteer;
use Swlib\SaberGM;
use App\facades\View;

class DemoService extends BaseService
{
    public function ping()
    {
        return Response::output('pong');
    }

    public function http()
    {
        $res = SaberGM::get('http://news.baidu.com/widget?ajax=json&id=ad');
        return Response::json($res->getBody());
    }

    public function html()
    {
        $data = [
            [
                'template' => 'christ',
                'data' => '{"name":"我是一个小测试2","bg":"love_1","tag":"偶尔情绪性进食"}'
            ],
            [
                'template' => 'christ',
                'data' => '{"name":"我是一个小测试2","bg":"coffee_1","tag":"偶尔情绪性进食"}'
            ],
            [
                'template' => 'christ',
                'data' => '{"name":"我是一个小测试2","bg":"emoeat_1","tag":"偶尔情绪性进食"}'
            ],
            [
                'template' => 'christ',
                'data' => '{"name":"我是一个小测试2","bg":"hair_1","tag":"偶尔情绪性进食"}'
            ],
            [
                'template' => 'christ',
                'data' => '{"name":"我是一个小测试2","bg":"loneliness_1","tag":"偶尔情绪性进食"}'
            ],
            [
                'template' => 'christ',
                'data' => '{"name":"我是一个小测试2","bg":"love_0","tag":"偶尔情绪性进食"}'
            ],
            [
                'template' => 'christ',
                'data' => '{"name":"我是一个小测试2","bg":"coffee_0","tag":"偶尔情绪性进食"}'
            ],
            [
                'template' => 'christ',
                'data' => '{"name":"我是一个小测试2","bg":"emoeat_0","tag":"偶尔情绪性进食"}'
            ],
            [
                'template' => 'christ',
                'data' => '{"name":"我是一个小测试2","bg":"hair_0","tag":"偶尔情绪性进食"}'
            ],
            [
                'template' => 'christ',
                'data' => '{"name":"我是一个小测试2","bg":"loneliness_0","tag":"偶尔情绪性进食"}'
            ],
        ];

        $stime = microtime(true);

//        $data = $request->get('data');
        $screenShots = [];
        if (is_array($data)) {
            foreach ($data as $da) {
                $screenShot = Pic::loadData($da['template'], $da['data'])->generate();
                $screenShots[] = $screenShot;
            }
        }
//        $screenShot = Pic::loadData('christ', '{"name":"我是一个小测试2","bg":"love_1","tag":"偶尔情绪性进食"}')->generate();
        $etime = microtime(true);
        return Response::json([
            'code' => 0,
            'msg' => 'ok',
            'data' => $screenShot,
            'time' => $etime - $stime
        ]);
    }

    public function redis()
    {
        $params = $this->getRequest()->all();
        $key = $params['key'];
//        unlink('redis://' . $params['key']);
//        file_put_contents('redis://' . $key, $params['value']);

        $result = file_get_contents('redis://' . $key);
//        file_put_contents('log://error', 'test error');

        return Response::json([
            'code' => 0,
            'msg' => 'ok',
            'data' => $result
        ]);
    }

    public function browser()
    {
//        $browser = BrowserShot::pick();
//        dump(BrowserShot::countPool());
//        dump($browser);

        $puppeteer = new Puppeteer;
        $browser = $puppeteer->launch();

        $page = $browser->newPage();
        $page->goto('https://www.baidu.com');
        $page->screenshot(['path' => 'baidu.png']);

        $browser->close();
    }
}
