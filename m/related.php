<?php
session_start();
if(!isset($_SESSION['login']))
	header("Location:../index.php");
else{
	if($_GET['id']=='')
		header("Location:../index.php");
	include_once("../config.php");
	htmlheader("添加黑山推荐.");

?>
<body>
<?php
if($_GET['delcount']!=''){
$result=$db->Execute("delete from videos_related where videoid='".$_GET['id']."' and count='". $_GET['delcount']."'");
if($result!=true)
	die('<font color="red">删除失败</font>');
echo '<center><font color="red">删除成功</center><meta http-equiv="refresh" content="1; url=related.php?id='.$_GET['id'].'">';
echo '</body>';
echo '</html>';
die();
}

if(isset($_GET['add'])&&$_POST['realteddes']!=''&&$_POST['relatedurl']!=''){

$result=$db->Execute("select max(count) from videos_related where videoid='".$_GET['id']."'");
if(mysql_num_rows($result)!=0)
	$row=mysql_fetch_row($result);

if($_POST['isheishanvideo']=='')
	$isheishanvideo=0;
else
	$isheishanvideo=$_POST['isheishanvideo'];

if($isheishanvideo&&(!is_numeric($_POST["relatedurl"])||strpos($_POST["relatedurl"],'.')||$_POST["relatedurl"]<0))
	die("黑山视频编号必须是整数");

$result=$db->Execute("insert into videos_related (videoid, count, description, url ,isheishanvideo) values ('".$_GET['id']."','".++$row[0]."','".$_POST['realteddes']."','".$_POST['relatedurl']."','".$isheishanvideo."')");
if($result!=true)
	die('<font color="red">添加失败</font>');
echo '<center><font color="red">添加成功</center><meta http-equiv="refresh" content="1; url=related.php?id='.$_GET['id'].'">';
echo '</body>';
echo '</html>';
die();
}?>
	<body>
	<table cellspacing="0" align="center">
		<thead>
			<tr>
				<th>黑山推荐</th>
			</tr>
		</thead>
		<tbody>
			<tr><td>要更改已有推荐请先删除再添加</td></tr>
			<tr><td>要链接到现有视频先勾选“本站视频”然后在资源网址中填写视频编号</td></tr>
		</tbody>
	</table>
		<table id="large" cellspacing="0" align="center">
			<thead>
				<tr>
					<th>已有推荐</th>
					<th>描述</th>
					<th>删除</th>
				</tr>
			</thead>
			<tbody>
<?php
$result=$db->Execute("select count,description,url,isheishanvideo from videos_related where videoid='".$_GET['id']."' order by count asc");
while($row=mysql_fetch_row($result))
{
	echo '<tr><td>'.$row[0].'</td><td><a href="';
	if($row[3])
		echo '../video.php?id=';
	echo $row[2].'" target="_blank">'.$row[1].'</a></td><td><a href="related.php?id='.$_GET['id'].'&delcount='.$row[0].'">删除</a></td></tr>';
}
?>
			</tbody>
		</table>
<form id="form1" name="form1" method="post" action="related.php?id=<?php echo $_GET['id']?>&add=1">
	<table id="large" cellspacing="0" align="center">
		<thead>
			<tr>
				<th>新增推荐</th>
				<th>属性</th>
			</tr>
		</thead>
		<tbody>
		<tr><td>推荐描述</td><td><input name="realteddes" type="text" id="realteddes" size="100" /></td></tr>
		<tr><td>资源网址</td><td><input name="relatedurl" type="text" id="relatedurl" size="100" /></td></tr>
		<tr><td>本站视频</td><td><input name="isheishanvideo" type="checkbox" id="isheishanvideo" value="1" />本站视频（资源网址请填写黑山视频编号）</td></tr>
		</tbody>
	</table>
	<center><input type="submit" name="addbutton" id="addbutton" value="添加" />　　　<a href="list.php">返回</a></center>
</form>
<?php }?>
</body>
</html>