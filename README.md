# php 图片服务
1, 采用内存框架swoole，将服务常驻内存
2，追加缓存层，把静态数据全部缓存到内存中
3，添加模板，将渲染好的内容通过html传给渲染进程

目前有两种方案来管理渲染进程：
1. 采用php管理node进程，详见App\components\browserShot\BrowserPool
2. 采用nodejs管理连接池，php直接调用nodejs服务

目前两种方案都不能稳定工作，以待后续优化
