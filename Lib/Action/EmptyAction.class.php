<?php
Class EmptyAction extends Action{
	Public function _empty(){
		$this->redirect("index/index");
	}
}
?>