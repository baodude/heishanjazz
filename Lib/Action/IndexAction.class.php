<?php
class IndexAction extends Action{
    public function index(){
		$this->assign("data",M("NewsDescription")->order('newsid desc')->limit('3')->findAll());
		$this->assign('title','首页');
		$this->display();
    }
}
?>