<?php

return [
    //Router
    'router' => [
        'single' => [
            ['GET', '/ping', [\App\services\DemoService::class, 'ping']],
            ['GET', '/http', [\App\services\DemoService::class, 'http']],
            ['GET', '/html', [\App\services\DemoService::class, 'html']],
            ['GET', '/redis', [\App\services\DemoService::class, 'redis', [\App\middlewares\Cors::class]]],
            ['GET', '/browser', [\App\services\DemoService::class, 'browser']],
        ],
        'group' => []
    ],

    // Twig templates
    'template' => [
        'templates_path' => \App\components\Helper::env('TEMPLATES_PATH', __DIR__ . '/../templates/'),
        'templates_cache' => \App\components\Helper::env('TEMPLATES_CACHE', __DIR__ . '/../runtime/cache/'),
    ],
    //Server
    'server' => [
        'host' => \App\components\Helper::env('SERVER_HOST', '0.0.0.0'),
        'port' => \App\components\Helper::envInt('SERVER_PORT', 9501),
        'reactor_num' => \App\components\Helper::envInt('SERVER_REACTOR_NUM', 8),
        'worker_num' => \App\components\Helper::envInt('SERVER_WORKER_NUM', 32),
        'daemonize' => \App\components\Helper::envBool('SERVER_DAEMONIZE', false),
        'backlog' => \App\components\Helper::envInt('SERVER_BACKLOG', 128),
        'max_request' => \App\components\Helper::envInt('SERVER_MAX_REQUEST', 0),
        'dispatch_mode' => \App\components\Helper::envInt('SERVER_DISPATCH_MODE', 2),
    ],

    //Redis
    'redis' => [
        'host' => \App\components\Helper::env('REDIS_HOST', '127.0.0.1'),
        'port' => \App\components\Helper::envInt('REDIS_PORT', 6379),
        'timeout' => \App\components\Helper::envDouble('REDIS_TIMEOUT', 1),
        'pool_size' => \App\components\Helper::envInt('REDIS_POOL_SIZE', 5),
        'passwd' => \App\components\Helper::env('REDIS_PASSWD', null),
        'db' => \App\components\Helper::envInt('REDIS_DB', 0),
        'switch' => \App\components\Helper::envInt('REDIS_SWITCH', 0),
        'prefix' => \App\components\Helper::env('REDIS_PREFIX', 'gese-pic:'),
        'pool_change_event' => \App\components\Helper::envInt('REDIS_POOL_CHANGE_EVENT', 0),
        'report_pool_change' => \App\components\Helper::envInt('REDIS_REPORT_POOL_CHANGE', 0),
    ],

    //Middleware
    'middleware' => [
        //\App\middlewares\Cors::class,
    ],

    //Cors
    'cors' => [
        'origin' => \App\components\Helper::env('CORS_ORIGIN', ''),
        'switch' => \App\components\Helper::envInt('CORS_SWITCH', 0),
    ],

    //Timezone
    'timezone' => \App\components\Helper::env('TIMEZONE', 'PRC'),

    // Screenshots
    'screenshots' => [
        'public_path' => \App\components\Helper::env('SCREENSHOTS_PATH', __DIR__ . '/../screenshots/'),
        'pic_bgs' => \App\components\Helper::env('PIC_BGS', null),
        'pool_size' => \App\components\Helper::envInt('POOL_SIZE', 10),
    ],
];
