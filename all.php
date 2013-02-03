<?php
include_once("config.php");
makeheader('所有视频.');
?>
<center>
<h1><font color="red">所有视频</font></h1>

<table width="90%" border="1" align="center">
<?php
	$result=$db->Execute("select videoid,title from videos_description order by videoid desc");
	$j=mysql_num_rows($result);
	for($i=1;$i<=$j;$i++)
	{
		$row=mysql_fetch_row($result);
		if($i%2==1)
			echo '<tr><td width="50%"><a href="video.php?id='.$row[0].'" target="_blank">'.$row[0].'.'.$row[1].'</a></td>
		';
		else
			echo '<td width="50%"><a href="video.php?id='.$row[0].'" target="_blank">'.$row[0].'.'.$row[1].'</a></td></tr>
		';
	}
	if($i%2==0) echo '<td>&nbsp;</td></tr>';
?>
</table>
</center>
<?php makefooter();?>