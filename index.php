<?php
include_once("config.php");
makeheader('首页.');
?>
<div id="content">
	<div id="left">
		<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=10,0,0,0" width="540" height="405" id="index" align="middle">
		<param name="allowScriptAccess" value="sameDomain" />
		<param name="allowFullScreen" value="false" />
		<param name="movie" value="index.swf" />
		<param name="quality" value="high" />
		<param name="bgcolor" value="#ffffff" />
		<embed src="index.swf" quality="high" bgcolor="#ffffff" width="540" height="405" name="index" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.adobe.com/go/getflashplayer_cn" />
		</object>
	</div>

	<div id="right">
	<h2>黑山音乐教学简介</h2>
	<p>Hi，欢迎来学爵士、流行音乐~~~</p>
	<p>本站是翟黑山老师（可以亲切成为黑山老师）的学生们为了宣传、推广黑山老师毕生流行音乐研究成果而设计的。</p>
	<p>假如您在国内有志于投入流行、爵士音乐的学习而寻师无门的话，就请立即在本网站开始您的音乐之旅，一定不会让您失望。</p>
	<p>在不了解黑山老师前，您有理由怀疑老师的功力，请看“<a href="bkey.php?key=%E6%8C%91%E6%88%98%E9%9F%B3%E4%B9%90%E7%A4%BA%E8%8C%83" target="_blank">挑战音乐示范</a>”相关视频及<a href="acquaint.php" target="_blank">黑山老师简介</a>。</p>
	<p>本站并非商业网站，如果您想购买黑山老师教材（共130门之多），只收取成本费，请看<a href="books.php" target="_blank">黑山教材</a>版块。</p>
	</div>
</div>
<?php makefooter();?>