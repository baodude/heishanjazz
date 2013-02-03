<?php

function htmlheader($title=''){
Global $setting;
$htmlheader='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>'.$title.$setting["sitename"].'</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="'.$setting["keywords"].'" />
	<link rel="stylesheet" type="text/css" href="'.$setting['base_url'].'m/style.css" media="all" />
</head>';
echo $htmlheader;
}

function makeheader($title=''){
Global $setting;
$htmlheader='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>'.$title.$setting["sitename"].'</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="'.$setting["keywords"].'" />
	<link rel="stylesheet" type="text/css" href="'.$setting['base_url'].'style.css" media="all" />
</head>
<body>
<div id="header">
	<h1>'.$setting["sitename"].'</h1>
	<h2>节奏、和声、旋律、编曲、即兴、钢琴……</h2>
</div>
<div id="menu">
	<ul>
		<li><a href="'.$setting['base_url'].'index.php">首页</a></li>
		<li><a href="'.$setting['base_url'].'video.php">谈音说乐</a></li>
		<li><a href="'.$setting['base_url'].'books.php">黑山教材</a></li>
		<li><a href="'.$setting['base_url'].'acquaint.php">黑山简介</a></li>
		<li><a href="http://bbs.heishanjazz.com" target="_blank">音乐论坛</a></li>
	</ul>
</div>';
echo $htmlheader;
}

function makefooter(){
$htmlfooter='<div id="footer">
	<p>Copyright(C) 2009 heishanjazz.com.</p>
</div>
</body>
</html>';
echo $htmlfooter;
}
?>