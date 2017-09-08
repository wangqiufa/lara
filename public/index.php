<?php

use Illuminate\Database\Capsule\Manager; // 数据库管理类
use Illuminate\Support\Fluent;

/**
 * 入口文件
 */

// 调用自动加载文件，添加自动加载文件函数
require __DIR__ . '/../vendor/autoload.php';

// 实例化服务容器、注册事件、路由服务提供者
$app = new \Illuminate\Container\Container();
// 把服务容器实例设置为静态属性
\Illuminate\Container\Container::setInstance($app);

with(new \Illuminate\Events\EventServiceProvider($app))->register();
with(new \Illuminate\Routing\RoutingServiceProvider($app))->register();

// 启动Eloquent ORM 模块 并 进行相关配置
$manager = new Manager();
$manager->addConnection(require '../config/database.php');
$manager->bootEloquent();

// 将服务名称“config” 与 Fluent实例绑定在一起
$app->instance('config', new Fluent());
$app['config']['view.compiled'] = "E:\\phpStudy\\WWW\\lara\\storage\\framework\\views\\";
$app['config']['view.paths'] = ["E:\\phpStudy\\WWW\\lara\\resources\\views\\"];
with(new \Illuminate\View\ViewServiceProvider($app))->register();
with(new \Illuminate\Filesystem\FilesystemServiceProvider($app))->register();

// 加载路由
require __DIR__ . '/../app/Http/routes.php';

// 实例化请求 并 分发处理请求
$request = \Illuminate\Http\Request::createFromGlobals();
$response = $app['router']->dispatch($request);

// 返回请求响应
$response->send();
