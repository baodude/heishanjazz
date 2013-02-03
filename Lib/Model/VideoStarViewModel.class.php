<?php
class VideoStarViewModel extends ViewModel {
	public $viewFields = array(
		'VideoStar'=>array('videoid'),
		'VideoDescription'=>array('title', '_on'=>'VideoStar.videoid=VideoDescription.videoid'),
	);
}
?>