<?php
class VideoAction extends Action{
    public function index(){
		$this->assign("data",M("UserOperation")->order('operationid desc')->findAll());
		$this->assign('title','聚合');
		$this->display('index');
	}
}
?>