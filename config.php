<?php
//黑山爵士音乐网配置文件
$setting['db_host'] = "127.0.0.1";											//数据库地址
$setting['db_user'] = "root";												//数据库用户名
$setting['db_pass'] = "";													//数据库密码
$setting['db_base'] = "db_heishanjazz";										//数据库名

$setting['base_url']="http://127.0.0.1/";									//网站地址 后面一定要加"/"
$setting['manage_password'] = "admin";										//管理密码

$setting['sitename'] = "黑山爵士音乐网";									//网站名称
$setting['keywords']="黑山,爵士,音乐,流行,乐理,和声,节奏,旋律,即兴";		//网站关键字

require_once("function.php");
require_once("db.class.php");
?>