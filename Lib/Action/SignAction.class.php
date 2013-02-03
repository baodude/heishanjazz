<?php
class SignAction extends Action{
    public function index(){
			if(isset($_GET['in']))
				$this->assign('redirect',$_GET['in']);
			$this->assign('title','登录');
			$this->display("index");
	}
	public function in(){
		if(($_POST['userid']!='')&&($_POST['pass']!=''))
		{
			$condition=Array(); 
			$condition['userid']=$_POST['userid'];
			$condition['password']=$_POST['pass'];
			$User=M('UserDescription');    
			$data=$User->where($condition)->find();
			if(empty($data))
			{
				$operation['time']=date(YmdHis);
				$operation['userid']=$_POST['userid'];
				$operation['operation']='wrongpassword';
				$operation['parameter']=$_POST['pass'].'@'.$this->GetIP();
				M('UserOperation')->add($operation);
				$this->assign('hi','<font color="red">请输入正确的编号或密码</font>');
				if(isset($_GET['in']))
					$this->assign('redirect',$_GET['in']);
				$this->assign('userid',$_POST['userid']);
				$this->assign('password',$_POST['pass']);
				$this->assign('title','登录');
				$this->display("index");
			}else
			{
				$_SESSION['userid']=$data['userid'];
				$_SESSION['username']=$data['username'];
				M('UserDescription')->where("userid='".$_SESSION['userid']."'")->setField('lastip',$this->GetIP());
				M('UserDescription')->where("userid='".$_SESSION['userid']."'")->setField('lasttime',date(YmdHis));
				$save['count']=array('exp',$data['count']+1);
				M('UserDescription')->where("userid='".$_SESSION['userid']."'")->save($save);
				$operation['time']=date(YmdHis);
				$operation['userid']=$_SESSION['userid'];
				$operation['operation']='signin';
				$operation['parameter']=$this->GetIP();
				M('UserOperation')->add($operation);
				if(isset($_SESSION['userid'])&&($_SESSION['userid']=='c021'||$_SESSION['userid']=='c007'||$_SESSION['userid']=='admin'))
					$_SESSION['admin']='admin';
				if($data['count']=='0')
				{
					$this->assign('hi','<font color="red">第一次登录，请先修改密码</font>');
					$this->assign('title','修改密码');
					$this->display("member:newpassword");
					exit();
				}
				if(isset($_GET['in']))
					redirect(base64_decode($_GET['in']));
				else
					$this->redirect('member/index', array(), 1,'登录成功...');
			}
		}else
		{
			$this->index();
		}
	}
	public function out(){
		session_unset();
		session_destroy();
		if(isset($_GET['out']))
			redirect(base64_decode($_GET['out']));
		else
			$this->redirect("index/");
	}
	private function GetIP(){
		if(!empty($_SERVER["HTTP_CLIENT_IP"]))
			$cip = $_SERVER["HTTP_CLIENT_IP"];
		else if(!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))
			$cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		else if(!empty($_SERVER["REMOTE_ADDR"]))
			$cip = $_SERVER["REMOTE_ADDR"];
		else
			$cip = "0.0.0.0";
		return $cip;
	}
}
?>