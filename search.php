<?php
if($_POST['title']=='') header("Location:video.php");
include_once("config.php");
makeheader('搜索结果.');
?>
<div align="center">
<h2><?php echo URLdecode($_POST['title'])?>搜索结果</h2>

<?php
	$keys=explode(' ',$_POST['title']);
	$sql="select videoid,title from videos_description where";
	$i=0;
	foreach($keys as $key)
	{
		if($i==0)
			$sql=$sql." title like '%$key%'";
		else
			$sql=$sql." and title like '%$key%'";
		$i++;
	}
	$result=$db->Execute($sql);
	while($row=mysql_fetch_row($result))
	{
		echo '<p><a href="video.php?id='.$row[0].'" target="_blank">'.$row[1].'</a></p>';
	}
?>

</div>
</body>
</html>