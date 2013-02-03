<?php
session_start();
if(!isset($_SESSION['login']))
	header("Location:../index.php");
else{
	if($_GET['id']=='')
		header("Location:../index.php");
	include_once("../config.php");
	htmlheader("添加关键字.");

?>
<body>
<?php
if($_GET['delcount']!=''){
$result=$db->Execute("delete from videos_keyword where videoid='".$_GET['id']."' and count='". $_GET['delcount']."'");
if($result!=true)
	die('<font color="red">删除失败</font>');
echo '<center><font color="red">删除成功</center><meta http-equiv="refresh" content="1; url=keyword.php?id='.$_GET['id'].'">';
echo '</body>';
echo '</html>';
die();
}

if(isset($_GET['add'])&&$_POST['keyword']!=''){
$result=$db->Execute("select max(count) from videos_keyword where videoid='".$_GET['id']."'");
if(mysql_num_rows($result)!=0)
	$row=mysql_fetch_row($result);

$result=$db->Execute("insert into videos_keyword (videoid, count, keyword) values ('".$_GET['id']."','".++$row[0]."','".$_POST['keyword']."')");
if($result!=true)
	die('<font color="red">添加失败</font>');
echo '<center><font color="red">添加成功</center><meta http-equiv="refresh" content="1; url=keyword.php?id='.$_GET['id'].'">';
echo '</body>';
echo '</html>';
die();
}?>
	<body>
	<table id="large" cellspacing="0" align="center">
		<thead>
			<tr>
				<th>已有关键字</th>
				<th>关键字名称</th>
				<th>删除</th>
			</tr>
		</thead>
		<tbody>
<?php
$result=$db->Execute("select count,keyword from videos_keyword where videoid='".$_GET['id']."' order by count asc");
while($row=mysql_fetch_row($result))
{
	echo '<tr><td>'.$row[0].'</td><td><a href="../bkey.php?key='.URLencode($row[1]).'" target="_blank">'.$row[1].'</a></td><td><a href="keyword.php?id='.$_GET['id'].'&delcount='.$row[0].'">删除</a></td></tr>';
}
?>
			</tbody>
		</table>
<form id="form1" name="form1" method="post" action="keyword.php?id=<?php echo $_GET['id']?>&add=1">
	<table id="large" cellspacing="0" align="center">
		<thead>
			<tr>
				<th>新增关键字</th>
				<th>关键字名称</th>
			</tr>
		</thead>
		<tbody>
		<tr><td>关键字</td><td><input name="keyword" type="text" id="keyword" size="32" /></td></tr>
		</tbody>
	</table>
	<center><input type="submit" name="addbutton" id="addbutton" value="添加" />　　　<a href="list.php">返回</a></center>
</form>
<?php }?>
</body>
</html>