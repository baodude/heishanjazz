<?php
    // 定义ThinkPHP路径
    define('THINK_PATH','./ThinkPHP');
    // 定义项目名称
    define('APP_NAME','HeishanJazz');
    // 定义项目路径
    define('APP_PATH','.');
    // 加载入口文件
    require(THINK_PATH.'/ThinkPHP.php');
    // 实例化这个项目
    $App = new App();
    // 执行初始化
    $App->run();
?>