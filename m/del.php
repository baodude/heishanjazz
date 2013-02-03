<?php
session_start();
if(!isset($_SESSION['login']))
	header("Location:../index.php");
else{
	if($_GET['id']=='')
		header("Location:../index.php");
	include_once("../config.php");
	htmlheader("删除.");

?>
<body>
<?php
if($_POST['yes']=='yes'){

$result=$db->Execute("delete from videos_description where videoid='".$_GET['id']."'");
if($result!=true)
	die('<font color="red">删除失败</font>');

$result=$db->Execute("delete from videos_url where videoid='".$_GET['id']."'");
if($result!=true)
	die('<font color="red">删除失败</font>');

$result=$db->Execute("delete from videos_related where videoid='".$_GET['id']."'");
if($result!=true)
	die('<font color="red">删除失败</font>');

$result=$db->Execute("delete from videos_keyword where videoid='".$_GET['id']."'");
if($result!=true)
	die('<font color="red">删除失败</font>');

echo '<center><font color="red">删除成功</center><meta http-equiv="refresh" content="1; url=list.php">';

}else{?>
<form id="form1" name="form1" method="post" action="del.php?id=<?php echo $_GET['id'];?>">
	<center><p><font color="red">确实要删除该视频吗，与此相关的记录将全部删除</font></p>
	<input type="hidden" name="yes" id="yes" value="yes" />
	<input type="submit" name="delbutton" id="delbutton" value="删除" />　　<input type="button" name="backbutton" id="backbutton" value="返回" onClick="history.back();" /></center>
</form>
<?php }?>
<?php }?>
</body>
</html>