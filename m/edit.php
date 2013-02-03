<?php
session_start();
if(!isset($_SESSION['login']))
	header("Location:../index.php");
if($_POST["videoid"]=="")
	die('<font color="red">视频id为空</font><br />');
if(!is_numeric($_POST["videoid"])||strpos($_POST["videoid"],'.')||$_POST["videoid"]<0)
	die('<font color="red">视频id必须为整数</font><br />');
if($_POST["title"]=="")
	die('<font color="red">视频标题为空，请填写</font><br />');
if($_POST["description"]=="")
	die('<font color="red">视频描述为空，请填写</font><br />');
if($_POST["urlsina"]=="")
	die('<font color="red">请填写新浪视频的地址</font>');

include_once("../config.php");

$result=$db->Execute("update videos_description set title='".$_POST["title"]."',description='".$_POST["description"]."' where videoid='".$_POST["videoid"]."'");
if($result!=true)
	die('<font color="red">更新失败</font>');

$result=$db->Execute("update videos_url set url='".$_POST["urlsina"]."' where videoid='".$_POST["videoid"]."' and site='sina'");
if($result!=true)
	die('<font color="red">更新失败</font>');


echo 'true';
?>