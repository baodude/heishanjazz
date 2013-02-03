<?php
class BookAction extends Action{
    public function index(){
		$this->assign('title','黑山教材');
		$this->display('index');
    }
	public function book(){
		if(isset($_GET['id']))
		{
			$bookid=$_GET['id'];
			$bookview=M('BookDescription');
			$where['bookid']=$bookid;
			$data=$bookview->where($where)->find();
			$this->assign('data',$data);
			$this->assign('title',$data['bookname'].' - 黑山教材');
			$this->display();
		}
		else
		{
			$this->index();
		}
	}
}
?>