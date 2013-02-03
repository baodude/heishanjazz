<?php
session_start();
if(!isset($_SESSION['login']))
	header("Location:../index.php");
else{
	include_once("../config.php");
	htmlheader("列表.");
?>
<body>
<table cellspacing="0" align="center">
	<thead>
		<tr>
			<th>HeishanJazz视频管理</th>
		</tr>
	</thead>
</table>
<center><a href="preadd.php" target="_blank"><font color="red">添加视频</font></a></center>
	<table id="large" cellspacing="0" align="center">
		<thead>
			<tr>
				<th>视频id</th>
				<th>视频名称</th>
				<th>查看</th>
				<th>修改</th>
				<th>黑山推荐</th>
				<th>关键字</th>
				<th>删除</th>
			</tr>
		</thead>
		<tbody>
<?php
$result=$db->Execute("select videoid,title from videos_description order by videoid asc");
while($row=mysql_fetch_row($result))
{
	echo '<tr><td>'.$row[0].'</td><td>'.$row[1].'</td><td><a href="../video.php?id='.$row[0].'" target=_blank>查看</a></td><td><a href="preedit.php?id='.$row[0].'">修改</a></td><td><a href="related.php?id='.$row[0].'">修改推荐</a></td><td><a href="keyword.php?id='.$row[0].'">修改关键字</a></td><td><a href="del.php?id='.$row[0].'">删除</a></td></tr>'."\n";
}
?>
		</tbody>
	</table>
	<center><a href="index.php?logout">退出</a></center>
</body>
</html>
<?php }?>