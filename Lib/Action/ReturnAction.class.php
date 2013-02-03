<?php
class ReturnAction extends Action{
    public function index(){
			require_once("alipay/alipay_notify.php");
			require_once("alipay/alipay_config.php");
			$alipay = new alipay_notify($partner,$security_code,$sign_type,$_input_charset,$transport);
			$verify_result = $alipay->return_verify();

			 //获取支付宝的反馈参数
			 /*  $dingdan    = $_GET['out_trade_no'];   //获取订单号
			   $total_fee  = $_GET['total_fee'];      //获取总价格
			 
				$receive_name    =$_GET['receive_name'];    //获取收货人姓名
				$receive_address =$_GET['receive_address']; //获取收货人地址
				$receive_zip     =$_GET['receive_zip'];     //获取收货人邮编
				$receive_phone   =$_GET['receive_phone'];   //获取收货人电话
				$receive_mobile  =$_GET['receive_mobile'];  //获取收货人手机
			  */

			if($verify_result) {    //认证合格
				echo "success";
				//这里放入你自定义代码,比如根据不同的trade_status进行不同操作
				//log_result("verify_success"); 
			}
			else {    //认证不合格
				echo "fail";
				//log_result ("verify_failed");
			}
	}
}
?>