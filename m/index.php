<?php
session_start();
if(isset($_SESSION['login']))
	header("Location:list.php");
if(isset($_GET['login'])&&isset($_POST['name'])&&isset($_POST['password'])){
	if((md5($_POST['name'])=='6f4df3cd0194b03f8760b036434cb230')&&(md5($_POST['password'])=='1c9203a4dd3f1669d8746b3a552636ed')){
		$_SESSION['login']=true;
		header("Location:list.php");
	}else
		header("Location:../index.php");
}
if(isset($_GET['logout'])){
	unset($_SESSION['login']);
	header("Location:../index.php");
}
include_once("../config.php");
htmlheader("管理.");
?>
<body><?php /*echo md5('admin');*/?>
<form method="post" action="index.php?login">
	<table id="large" cellspacing="0" align="center">
		<thead>
			<tr>
				<th>黑山爵士音乐网管理</th>
			</tr>
		</thead>
		<tbody>
			<tr><td><input type="text" id="name" name="name" value="heishan" /></td></tr>
			<tr><td><input type="password" id="password" name="password" value="ilovemusic" /></td></tr>
			<tr><td><input type="submit" id="submit" value="登录" /></td></tr>
		</tbody>
	</table>
</form>
</body>
</html>