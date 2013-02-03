<?php
if($_GET['key']=='') header("Location:key.php");
include_once("config.php");
makeheader('关键字.');
?>
<div align="center">
<h2>关键字为<?php echo URLdecode($_GET['key'])?>的视频</h2>

<?php
	$result=$db->Execute("select videos_description.videoid,title from videos_keyword,videos_description where keyword='".$_GET['key']."' and videos_description.videoid=videos_keyword.videoid");
	while($row=mysql_fetch_row($result))
	{
		echo '<p><a href="video.php?id='.$row[0].'" target="_blank">'.$row[1].'</a></p>';
	}
?>

</div>
</body>
</html>