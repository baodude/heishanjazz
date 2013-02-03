<?php
class MAction extends Action{
	public function _initialize()
	{
		if($_SESSION['admin']!='admin')
		{
			$this->redirect("index/index");
		}
	}
	public function index(){
		$this->assign('title','管理首页');
		$this->display();
    }
	public function query(){
		$Model=new Model();
		$result=$Model->query("select * from video_star");
		dump($result);
	}
	public function listvideo(){
		$videomodel=M("VideoDescription");
		$data=$videomodel->order('videoid desc')->field('videoid,title,count')->findAll();
		$this->assign("count",$videomodel->sum('count'));
		$this->assign("data",$data);
		$this->assign('title','视频管理');
		$this->display('listvideo');
	}
	public function modifyvideo(){
		if(isset($_GET['id']))
		{
			$id=$_GET['id'];
			$this->assign('title','修改视频');
			$this->display('modifyvideo');
		}
	}
	public function gather(){
		$this->assign("data",M("UserOperation")->order('operationid desc')->findAll());
		$this->assign('title','操作信息');
		$this->display('gather');
	}
	public function addvideo(){
		if($_POST['id']!=''&&$_POST['title']!=''&&$_POST['urlsina']!=''&&$_POST['urlyouku']!=''&&$_POST['url56']!=''&&$_POST['urltudou']!=''&&$_POST['description']!='')
		{
			$data['id']=$_POST['id'];
			$data['title']=$_POST['title'];
			$data['urlsina']=$_POST['urlsina'];
			$data['urlyouku']=$_POST['urlyouku'];
			$data['url56']=$_POST['url56'];
			$data['urltudou']=$_POST['urltudou'];
			$data['description']=$_POST['description'];
			M(VideoDescription)->add($data);
		}
		else
		{
			$this->assign('title','添加视频');
			$this->display('addvideo');
		}
	}
	public function deletevideo(){
		if(isset($_GET['id'])&&isset($_GET['del']))
		{
			$id=$_GET['id'];
			M("VideoDescription")->where('videoid='.$id)->delete();
			M("VideoRelated")->where('videoid='.$id)->delete();
			M("VideoRelated")->where('relatedid='.$id)->delete();
			M("VideoTag")->where('videoid='.$id)->delete();
			$this->redirect("m/listvideo");
		}
	}
	public function ship(){
		$this->assign('title','发货管理');
		$this->display();
	}
	public function user(){
		$usermodel=M("UserDescription");
		$data=$usermodel->order('userid desc')->findAll();
		$this->assign("data",$data);
		$this->assign('title','用户管理');
		$this->display();
	}
}
?>