<?php
include_once("config.php");
makeheader('黑山谈音说乐.');

$videoid=$_GET["id"];
if($videoid=="")
{
	$result=$db->Execute("select max(videoid) from videos_description");
	if(mysql_num_rows($result)!=0)
	{
	$row=mysql_fetch_row($result);
	$videoid=$row[0];
	}
}else
{
	if(!preg_match('/^\d{1,4}$/',$videoid))
		die('<div align="center">崩溃</div>');
}

$result=$db->Execute("select videoid,url from videos_url where videoid='".$videoid."' and site='sina'");
if(mysql_num_rows($result)!=0)
{
	$row=mysql_fetch_row($result);
	$videoid=$row[0];
	$videourl=$row[1];
}else die("<center>无此视频</center>");

$result=$db->Execute("select title,description,time from videos_description where videoid='".$videoid."'");
if(mysql_num_rows($result)!=0)
{
	$row=mysql_fetch_row($result);
	$title=$row[0];
	$description=$row[1];
	$time=$row[2];
}
?>

<div id="content">
	<div id="left">
		<?php echo '<h3>'.$videoid.'.'.$title.'</h3>';?>
		<object id='ssss' width='480' height='370'>
			<param name='allowScriptAccess' value='always' />
			<embed pluginspage='http://www.macromedia.com/go/getflashplayer' src='<?php echo $videourl ?>' type='application/x-shockwave-flash' name='ssss' allowFullScreen='true' allowScriptAccess='always' width='480' height='370'>
			</embed>
		</object>
		<?php echo '<p>'.$description.'</p>'?>
	</div>

	<div id="right">
		<h2>黑山老师推荐</h2>
		<div id="related">
		<?php
			$result=$db->Execute("select description,url,isheishanvideo from videos_related where videoid='$videoid'");
			while($row=mysql_fetch_row($result))
			{
				echo '<p>'.$row[0].'<br />';
				if($row[2])
					echo '<a href="video.php?id='.$row[1].'" target="_blank">相关链接</a></p>';
				else
					echo '<a href="'.$row[1].'" target="_blank">相关链接</a></p>';
			}
		?>
		</div>
		<form method=post ACTION="search.php" target="_blank">
			<label for="title">视频搜索：</label>
			<input type="text" id="title" name="title" />
			<input type="submit" value="搜索" />
		</form>

		<p><a href="key.php" target="_blank">关键字</a>>>><?php
			$result=$db->Execute("select keyword from videos_keyword where videoid='".$videoid."'");
			while($row=mysql_fetch_row($result))
			{
				echo '<a href="bkey.php?key='.urlencode($row[0]).'" target="_blank">'.$row[0].'</a> ';
			}
		?>
		</p>
		<p><a href="all.php">所有视频</a></p>
	</div>
</div>
<?php makefooter();?>