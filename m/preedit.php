<?php
session_start();
if((!isset($_SESSION['login']))||($_GET['id']==''))
	header("Location:../index.php");
	include_once("../config.php");
	$result=$db->Execute("select title,description from videos_description where videoid='".$_GET['id']."'");
	if(mysql_num_rows($result)!=0)
	{
	$row=mysql_fetch_row($result);
	$title=$row[0];
	$description=$row[1];
	}
	else
		die("无此视频");
	$result=$db->Execute("select site,url from videos_url where videoid='".$_GET['id']."'");
	while($row=mysql_fetch_row($result))
	{
	if($row[0]=='sina'){$urlsina=$row[1];continue;}
	if($row[0]=='56'){$url56=$row[1];continue;}
	if($row[0]=='tudou'){$urltudou=$row[1];continue;}
	if($row[0]=='youku'){$urlyouku=$row[1];continue;}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>添加.黑山爵士音乐网</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="黑山,爵士,音乐,流行,乐理,和声,节奏,旋律,即兴" />
	<link rel="stylesheet" type="text/css" href="style.css" media="all" />
<script language="javascript">
var relatedcount=1;
var xmlHttp=false;
try {
	xmlHttp = new XMLHttpRequest();
} catch (trymicrosoft) {
	try {
		xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (othermicrosoft) {
		try {
			xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (failed) {
			xmlHttp = false;
		}
	}
}
if (!xmlHttp){
	alert("无法创建 XMLHttpRequest 对象！");
}
 
function editVideo() {
	var title=document.getElementById("title").value;
	var description=document.getElementById("description").value;
	var urlsina=document.getElementById("urlsina").value;
	var postStr="videoid="+<?php echo $_GET['id']?>+"&title="+title+"&description="+description+"&urlsina="+escape(urlsina);
	xmlHttp.open("POST", "edit.php", true);//这里的true代表是异步请求
	xmlHttp.onreadystatechange = updatePage;
	xmlHttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded"); 
	xmlHttp.send(postStr);
}
 
function updatePage(){
	if (xmlHttp.readyState == 4) {
		var response = xmlHttp.responseText;
		if(response=='true')
			{
				document.getElementById("submit").style.display="none";
				document.getElementById("editState").innerHTML = '<p><font color="red">修改成功</font></p> <a href="related.php?id='+<?php echo $_GET['id']?>+'" target="_blank">修改黑山推荐</a> <a href="keyword.php?id='+<?php echo $_GET['id']?>+'" target="_blank">修改关键字</a> <a href="../video.php?id='+<?php echo $_GET['id']?>+'" target="_blank">查看本视频</a> <a href="list.php">返回列表</a>';
			}
		else
			document.getElementById("editState").innerHTML = response;
}
}
</script>
</head>
<body>
<table cellspacing="0" align="center">
	<thead>
		<tr>
			<th>修改视频</th>
		</tr>
	</thead>
</table>
<form id="form1" name="form1" method="post" action="#">
	<table id="large" cellspacing="0" align="center">
		<thead>
			<tr>
				<th>名称</th>
				<th>属性</th>
			</tr>
		</thead>
		<tbody>
		<tr><td>视频编号</td><td><?php echo $_GET['id'];?></td></tr>
		<tr><td>视频名称</td><td><input name="title" type="text" id="title" size="100" value="<?php echo $title;?>" /></td></tr>
		<tr><td>视频描述</td><td><input name="description" type="text" id="description" size="100" value="<?php echo $description;?>" /></td></tr>
		<tr><td>新浪地址</td><td><input name="urlsina" type="text" id="urlsina" size="100" value="<?php echo $urlsina;?>" /></td></tr>
		</tbody>
	</table>
	<div id="editState" align="center"></div>
	<br />
	<div id="submit" align="center"><input type="button" name="editbutton" id="editbutton" value="修改" onClick="editVideo();" />　　　<a href="list.php">返回</a></div>
</form>
</body>
</html>