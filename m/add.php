<?php
session_start();
if(!isset($_SESSION['login']))
	die('<font color="red">未登录</font><br />');
if($_POST["videoid"]=="")
	die('<font color="red">视频id为空，请填写</font><br />');
if(!is_numeric($_POST["videoid"])||strpos($_POST["videoid"],'.')||$_POST["videoid"]<0)
	die('<font color="red">视频id必须为整数</font><br />');
if($_POST["title"]=="")
	die('<font color="red">视频标题为空，请填写</font><br />');
if($_POST["description"]=="")
	die('<font color="red">视频描述为空，请填写</font><br />');
if($_POST["urlsina"]=="")
	die('<font color="red">请填写新浪视频的地址</font>');

include_once("../config.php");
//插入描述
date_default_timezone_set("Asia/Shanghai");
$result=$db->Execute("insert into videos_description (videoid, title, description, time) values ('".$_POST["videoid"]."', '".$_POST["title"]."', '".$_POST["description"]."','".date("Y-m-d H:i:s")."')");
if($result!=true)
	die('<font color="red">插入失败请确认视频编号是否已经存在</font>');
//插入sina


$result=$db->Execute("insert into videos_url (videoid, site, url) values ('".$_POST["videoid"]."', 'sina', '".$_POST["urlsina"]."')");
if($result!=true)
	die('<font color="red">插入失败请确认视频编号是否已经存在</font>');


echo 'true';
?>