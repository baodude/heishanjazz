<?php
class MemberAction extends Action{
	public function _initialize()
	{
		if(!isset($_SESSION['userid'])||$_SESSION['userid']=='guest')
		{
			$this->assign('redirect',base64_encode("http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']));
			$this->assign('title','登录');
			$this->display("sign:index");
			exit();
		}
	}
    public function index(){
		$this->assign('stardata',D('VideoStarView')->where('userid="'.$_SESSION['userid'].'"')->findAll());
		$this->assign('userdata',M('UserDescription')->where('userid="'.$_SESSION['userid'].'"')->find());
		$this->assign('title',$_SESSION['userid'].'的账户');
		$this->display('index');
    }
	public function modify(){
		if(($_POST['phone']!='')||($_POST['email']!='')||($_POST['address']!=''))
		{
			if($_POST['phone']!='') M('UserDescription')->where("userid='".$_SESSION['userid']."'")->setField('phone',$_POST['phone']);
			if($_POST['email']!='') M('UserDescription')->where("userid='".$_SESSION['userid']."'")->setField('email',$_POST['email']);
			if($_POST['address']!='') M('UserDescription')->where("userid='".$_SESSION['userid']."'")->setField('address',$_POST['address']);
			$oldinfo=M('UserDescription')->where('userid="'.$_SESSION['userid'].'"')->field('phone,email,address')->find();
			$operation['time']=date(YmdHis);
			$operation['userid']=$_SESSION['userid'];
			$operation['operation']='newcontactinfo';
			$operation['parameter']=$oldinfo['phone'].'###'.$oldinfo['email'].'###'.$oldinfo['address'].'--->>>'.$_POST['phone'].'###'.$_POST['email'].'###'.$_POST['address'];
			M('UserOperation')->add($operation);
			$this->assign('hi','<font color="red">联系资料修改成功</font>');
			$this->index();
		}else
		{
			$this->assign('userdata',M('UserDescription')->where('userid="'.$_SESSION['userid'].'"')->find());
			$this->assign('hi','修改联系信息，留空则为不修改');
			$this->assign('title','修改联系信息');
			$this->display("modify");
		}


	}
	public function newpassword(){
		if(($_POST['newpass']!='')&&($_POST['newpassconfirm']!=''))
		{
			if($_POST['newpass']!=$_POST['newpassconfirm'])
			{
				$this->assign('hi','<font color="red">请确认两次输入的密码相同</font>');
				$this->assign('pass',$_POST['pass']);
				$this->assign('newpass',$_POST['newpass']);
				$this->assign('newpassconfirm',$_POST['newpassconfirm']);
				$this->assign('title','修改密码');
				$this->display("newpassword");
				exit();
			}
			$pass=M('UserDescription')->where("userid='".$_SESSION['userid']."'")->field('password')->find();
			M('UserDescription')->where("userid='".$_SESSION['userid']."'")->setField('password',$_POST['newpass']);
			$operation['time']=date(YmdHis);
			$operation['userid']=$_SESSION['userid'];
			$operation['operation']='newpassword';
			$operation['parameter']=$pass['password'].'--->'.$_POST['newpass'];
			M('UserOperation')->add($operation);
			$this->assign('hi','<font color="red">密码修改成功</font>');
			$this->index();
		}else
		{
			$this->assign('hi','修改密码');
			$this->assign('title','修改密码');
			$this->display("newpassword");
		}
	}
}
?>