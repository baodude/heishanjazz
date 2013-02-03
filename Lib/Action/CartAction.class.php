<?php
class CartAction extends Action{
	public function _initialize()
	{
		if(!isset($_SESSION['userid']))
		{
			$_SESSION['userid']='guest';
		}
		if(!isset($_SESSION['totalamount']))
		{
			$_SESSION['totalamount']=0;
		}
		if(!isset($_SESSION['totalprice']))
		{
			$_SESSION['totalprice']=0;
		}
		$this->assign('title','购物车');
	}
    public function index(){
		if($_SESSION['uesrid']!='guest')
		{
			$orderbills=M('OrderBill');
			$billwhere['userid']=$_SESSION['uesrid'];
			$billdata=$orderbills->where($billwhere)->order('orderid desc')->limit(1)->find();
			$this->assign('billdata',$billdata);
		}
		$this->display("index");
    }
	public function add(){
		if(!isset($_GET['id']))
		{
			$this->index();
			exit();
		}
		$id=$_GET['id'];
		if($id!=101&&$id!=102)
		{
			if(!isset($_SESSION['userid'])||$_SESSION['userid']=='guest')
			{
				$this->assign('redirect',base64_encode("http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']));
				$this->assign('title','登录');
				$this->display("sign:index");
				exit();
			}
		}
		$userdes=M('UserDescription');
		$userwhere['userid']=$_SESSION['userid'];
		$userdata=$userdes->where($userwhere)->find();
		if($id>=5&&$id<=40){if($userdata['prisign']<1) $this->privilege($userdata['prisign']);}
		if($id>=41&&$id<=76){if($userdata['prisign']<2) $this->privilege($userdata['prisign']);}
		if($id>=77&&$id<=100){if($userdata['prisign']<3) $this->privilege($userdata['prisign']);}
		$bookview=M('BookDescription');
		$bookwhere['bookid']=$id;
		$bookdata=$bookview->where($bookwhere)->find();
		if($bookdata)
		{
			$_SESSION['book'][$id]['bookname']=$bookdata['bookname'];
			$_SESSION['book'][$id]['bookamount']=$_SESSION['book'][$id]['bookamount']+1;
			$_SESSION['book'][$id]['bookprice']=$bookdata['price'];
		}
		else
		{
			$this->index();
			exit();
		}
		$this->calculate();
		redirect("../../../cart");
	}
	public function del(){
		if(!isset($_GET['id']))
		{
			$this->index();
			exit();
		}
		$id=$_GET['id'];
		unset($_SESSION['book'][$id]);
		$_SESSION['totalamount']=0;
		$_SESSION['totalprice']=0;
		$this->calculate();
		redirect("../../../cart");
	}
	private function calculate(){
		foreach($_SESSION['book'] as $product_id => $quantity)
		{
			$totalamount=$totalamount+$quantity['bookamount'];
			$totalprice=$totalprice+$quantity['bookprice']*$quantity['bookamount'];
			$_SESSION['totalamount']=$totalamount;
			$_SESSION['totalprice']=$totalprice;
		}
	}
	private function privilege($pri){
		switch($pri){
			case 0:
				$this->assign('pri','您现在可以购买<font color="red">入会教材</a>');
				break;
			case 1:
				$this->assign('pri','您现在可以购买<font color="red">一期教材</a>');
				break;
			case 2:
				$this->assign('pri','您现在可以购买<font color="red">一期和二期教材</a>');
				break;
			case 3:
				$this->assign('pri','您现在可以购买<font color="red">全部教材</a>');
		}
			$this->assign('title','添加结果');
			$this->display("privilege");
			exit();
	}
	public function confirm(){
		$_SESSION['name']=$_POST['name'];
		$_SESSION['address']=$_POST['address'];
		$_SESSION['phone']=$_POST['phone'];
		$_SESSION['email']=$_POST['email'];
		$this->display();
	}
	public function redirect(){
		list($usec,$sec)=explode(" ", microtime());
		$usec=floor($usec*100);
		$orderbill['orderid']=date("YmdHis").sprintf("%02d",$usec);
		$_SESSION['orderid']=$orderbill['orderid'];
		$orderbill['userid']=$_SESSION['userid'];
		$orderbill['bookfee']=$_SESSION['totalprice'];
		$orderbill['shipfee']=0;
		$orderbill['express']='sf';
		$orderbill['name']=$_SESSION['name'];
		$orderbill['address']=$_SESSION['address'];
		$orderbill['phone']=$_SESSION['phone'];
		$orderbill['email']=$_SESSION['email'];
		date_default_timezone_set("Asia/Shanghai");
		$orderbill['time']=date("Y-m-d H:i:s");
		$orderbill['ip']=$this->GetIP();
		$OrderBills=M("OrderBill");
		$OrderBills->create($orderbill);
		if(!$OrderBills->add()){
			header("Content-Type:text/html; charset=utf-8");
			exit($OrderBills->getError().' [ <A HREF="javascript:history.back()">返 回</A> ]');
		}
		$OrderItems=M("OrderItem");
		foreach($_SESSION['book'] as $product_id => $quantity)
		{
			$item['orderid']=$_SESSION['orderid'];
			$item['bookid']=$product_id;
			$item['amount']=$quantity['bookamount'];
			$OrderItems->create($item);
			if(!$OrderItems->add()){
			header("Content-Type:text/html; charset=utf-8");
			exit($OrderBills->getError().' [ <A HREF="javascript:history.back()">返 回</A> ]');
			}
		}
		$this->alipay();
    }
	private function alipay(){
		foreach($_SESSION['book'] as $product_id => $quantity)
		{
			$bodystr=$bodystr.'《'.$quantity['bookname'].'》'.$quantity['bookamount'].'本 ';
		}
		require_once("alipay/alipay_service.php");
		require_once("alipay/alipay_config.php");
		$parameter = array(
		"service"        => "create_partner_trade_by_buyer",  //交易类型
		"partner"        => $partner,         //合作商户号
		"return_url"     => $return_url,      //同步返回
		"notify_url"     => $notify_url,      //异步返回
		"_input_charset" => $_input_charset,  //字符集，默认为GBK
		"subject"        => "黑山教材".$_SESSION['totalamount']."本",       //商品名称，必填
		"body"           => $_SESSION['userid']."购买".$bodystr,
		"out_trade_no"   => $_SESSION['orderid'],     //商品外部交易号，必填（保证唯一性）
		"price"          => $_SESSION['totalprice'],           //商品单价，必填（价格不能为0）
		"payment_type"   => "1",              //默认为1,不需要修改
		"quantity"       => "1",              //商品数量，必填
		"logistics_fee"      =>'0.00',        //物流配送费用
		"logistics_payment"  =>'BUYER_PAY',   //物流费用付款方式：SELLER_PAY(卖家支付)、BUYER_PAY(买家支付)、BUYER_PAY_AFTER_RECEIVE(货到付款)
		"logistics_type"     =>'EXPRESS',     //物流配送方式：POST(平邮)、EMS(EMS)、EXPRESS(其他快递)
		"show_url"       => "http://localhost/book/",        //商品相关网站
		"seller_email"   => $seller_email,     //卖家邮箱，必填
		"out_trade_np"   => $_SESSION['orderid'],
		"logistics_fee"  => "0",
		"receive_name"   => $_SESSION['name'],
		"receive_address"=> $_SESSION['address'],
		"receive_phone"  => $_SESSION['phone'],
		"receive_zip"    => "000000",
		);
		$alipay = new alipay_service($parameter,$security_code,$sign_type);
		dump($parameter);
		redirect($alipay->create_url());
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