<?php
include_once("config.php");
makeheader('所有关键字.');
?>
<center>
<h1><font color="red">所有关键字</font></h1>

<?php
	$result=$db->Execute("select distinct keyword from videos_keyword");
	while($row=mysql_fetch_row($result))
	{
		echo '<a href="bkey.php?key='.urlencode($row[0]).'" target="_blank">'.$row[0].'</a> ';
	}
?>

</center>
</body>
</html>