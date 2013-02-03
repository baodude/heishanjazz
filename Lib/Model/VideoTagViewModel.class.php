<?php
class VideoTagViewModel extends ViewModel {
	public $viewFields = array(
		'VideoTag'=>array('videoid'),
		'VideoDescription'=>array('title', '_on'=>'VideoTag.videoid=VideoDescription.videoid'),
	);
}
?>