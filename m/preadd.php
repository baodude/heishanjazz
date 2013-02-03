<?php
session_start();
if(!isset($_SESSION['login']))
	header("Location:../index.php");
	include_once("../config.php");
	$result=$db->Execute("select max(videoid) from videos_description");
	if(mysql_num_rows($result)!=0)
		$row=mysql_fetch_row($result);
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
 
function addVideo() {
	var videoid=document.getElementById("videoid").value;
	var title=document.getElementById("title").value;
	var description=document.getElementById("description").value;
	var urlsina=document.getElementById("urlsina").value;
	var postStr="videoid="+videoid+"&title="+title+"&description="+description+"&urlsina="+escape(urlsina);
	xmlHttp.open("POST", "add.php", true);//这里的true代表是异步请求
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
				document.getElementById("addState").innerHTML = '<p><font color="red">添加成功</font></p> <a href="related.php?id='+document.getElementById("videoid").value+'" target="_blank">添加黑山推荐</a> <a href="keyword.php?id='+document.getElementById("videoid").value+'" target="_blank">添加关键字</a> <a href="../video.php?id='+document.getElementById("videoid").value+'" target="_blank">查看视频</a> <a href="preedit.php?id='+document.getElementById("videoid").value+'" target="_blank">修改视频</a> <a href="preadd.php">继续添加视频</a> <a href="list.php">返回列表</a>';
			}
		else
			document.getElementById("addState").innerHTML = response;
}
}
</script>
</head>
<body>
<table cellspacing="0" align="center">
	<thead>
		<tr>
			<th>添加视频</th>
		</tr>
	</thead>
	<tbody>
		<tr><td>视频编号已经给出 完成添加后可以添加推荐资源</td></tr>
	</tbody>
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
			<tr><td>视频编号</td><td><input name="videoid" type="text" id="videoid" size="100" value="<?php echo $row[0]+1;?>" /></td></tr>
			<tr><td>视频名称</td><td><input name="title" type="text" id="title" size="100" /></td></tr>
			<tr><td>视频描述</td><td><input name="description" type="text" id="description" size="100" /></td></tr>
			<tr><td>新浪地址</td><td><input name="urlsina" type="text" id="urlsina" size="100" /></td></tr>
			</tbody>
		</table>
		<div id="addState" align="center"></div>
		<br />
		<div id="submit" align="center"><input type="button" name="addbutton" id="addbutton" value="添加" onClick="addVideo();" />　　　<a href="list.php">返回</a></div>
	</form>
</body>
</html>