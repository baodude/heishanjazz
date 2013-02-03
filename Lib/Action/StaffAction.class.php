<?php
class StaffAction extends Action{
    public function index(){
		$this->assign('title','中心人员');
		$this->display('index');
    }
	public function staff(){
		if(isset($_GET['id']))
		{
			$staffid=$_GET['id'];
			switch($staffid)
			{
				case 'heishan':
					$this->assign('title','翟黑山 - 中心人员');
					$this->display('heishan');
					break;
				case 'builder':
					$this->assign('title','创建人 - 中心人员');
					$this->display('builder');
					break;
				case 'partner':
					$this->assign('title','管理员 - 中心人员');
					$this->display('partner');
					break;
				default:
					$this->index();
			}
		}
		else
		{
			$this->index();
		}
	}
}
?>