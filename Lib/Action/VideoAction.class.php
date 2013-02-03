<?php
class VideoAction extends Action{
    public function index(){
		$this->assign('data',M('VideoDescription')->field('videoid,title,urltudou')->order('videoid desc')->limit('1')->findAll());
		$this->assign('title','谈音说乐');
		$this->display('index');
    }
	public function video(){
		if(isset($_GET['id']))
		{
			$videoid=$_GET['id'];
			$videomodel=M('VideoDescription');
			$data=$videomodel->where('videoid='.$videoid)->find();
			if($data)
			{
				$save['count']=array('exp',$data['count']+1);
				$videomodel->where('videoid='.$videoid)->save($save);
				$this->assign('data',$data);
				$this->assign('comment',M('VideoComment')->where('videoid='.$videoid)->findAll());
				$this->assign('title',$data['videoid'].'.'.$data['title'].' - 谈音说乐');
				$this->display('video');
			}
			else
				$this->lists();
		}
		else
		{
			$this->index();
		}
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
	public function lists(){
		$Model=new Model();
		$this->assign("data",$Model->query("select videoid,title,isnull(description) AS 'length' from video_description order by videoid desc"));
		$this->assign('title','视频列表');
		$this->display('list');
	}
	public function tongji(){
		$videomodel=M("VideoDescription");
		$data=$videomodel->order('count desc')->field('videoid,title,count')->findAll();
		$this->assign("count",$videomodel->sum('count'));
		$this->assign("data",$data);
		$this->assign("comment",M("VideoComment")->Order('time desc')->limit('30')->findAll());
		$this->assign('title','视频统计');
		$this->display('tongji');
	}
	function is_gb2312($str)
{
        for($i=0; $i<strlen($str); $i++) {
                $v = ord( $str[$i] );
                if( $v > 127) {
                        if( ($v >= 228) && ($v <= 233) )
                        {
                                if( ($i+2) >= (strlen($str) - 1)) return true;  // not enough characters
                                $v1 = ord( $str[$i+1] );
                                $v2 = ord( $str[$i+2] );
                                if( ($v1 >= 128) && ($v1 <=191) && ($v2 >=128) && ($v2 <= 191) ) // utf编码
                                        return false;
                                else
                                        return true;
                        }
                }
        }
        return true;
}
	public function tag(){
		if(isset($_GET['tag']))
		{
			if($this->is_gb2312($_GET['tag']))
				$tag=iconv("gb2312","utf-8",$_GET['tag']);
			else
				$tag=$_GET['tag'];
			$this->assign("data",D('VideoTagView')->where("VideoTag.tag='".$tag."'")->findAll());
			$this->assign('title','标签');
			$this->display('tag');
		}
		else
		{
			$this->assign("data",M('VideoTag')->query('select tag,count(videoid) as num from video_tag group by tag'));
			$this->assign('title','标签');
			$this->display('tags');
		}
	}
	public function comment(){
		if($_POST['comment']!='')
		{
			$data['videoid']=$_POST['videoid'];
			date_default_timezone_set("PRC");
			$data['time']=date("Y-m-d H:i:s");
			if($_SESSION['userid']==''||$_SESSION['userid']=='guest')
				$data['userid']=$this->GetIP();
			else
				$data['userid']=$_SESSION['userid'];
			$data['comment']=$_POST['comment'];
			M("VideoComment")->add($data);
		}
		redirect('http://'.$_SERVER['SERVER_NAME'].'/video/'.$_POST['videoid']);
	}
	public function search(){
		if($_POST['word']!='')
		{
			$keys=explode(' ',$_POST['word']);
			$i=0;
			foreach($keys as $key)
			{
				if($i==0)
					$sql=$sql." title like '%$key%'";
				else
					$sql=$sql." and title like '%$key%'";
				$i++;
			}
			$this->assign("data",M('VideoDescription')->where($sql)->findAll());
			$this->assign('title','搜索结果');
			$this->display('saerch');
		}
		else
		{
			$this->lists();
		}
	}
	public function album(){
		if(isset($_GET['album']))
		{
			$id=$_GET['album'];
			switch ($id)
			{
				case '1':
				{
					$this->assign("data",M('VideoDescription')->where('albumid=1')->findAll());
					$this->assign('title','“从头学音乐” - 专辑');
					$this->display('album');
					break;
				}
				case '2':
				{
					$this->assign("data",M('VideoDescription')->where('albumid=2')->findAll());
					$this->assign('title','“爵士四书” - 专辑');
					$this->display('album');
					break;
				}
				default:
					$this->lists();
			}
		}
		else
		{
			$this->lists();
		}
	}
	public function star(){
		if(isset($_GET['star']))
		{
			if(!isset($_SESSION['userid'])||$_SESSION['uesrid']=='guest')
			{
				$this->assign('redirect',base64_encode("http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']));
				$this->assign('title','登录');
				$this->display("Sign:index");
				exit();
			}
			$id=$_GET['star'];
			$stardata['userid']=$_SESSION['userid'];
			$stardata['videoid']=$id;
			M('VideoStar')->add($stardata);
			header("Content-type:text/html;charset=utf-8");
			$this->redirect('member/index', array(), 1,'视频收藏成功...');
		}
		else
		{
			$this->lists();
		}
	}
	public function unstar(){
		if(isset($_GET['unstar']))
		{
			if(!isset($_SESSION['userid'])||$_SESSION['userid']=='guest')
			{
				$this->assign('redirect',base64_encode("http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']));
				$this->assign('title','登录');
				$this->display("sign:index");
				exit();
			}
			$id=$_GET['unstar'];
			$stardata['userid']=$_SESSION['userid'];
			$stardata['videoid']=$id;
			M('VideoStar')->where($stardata)->delete();
			header("Content-type:text/html;charset=utf-8");
			$this->redirect('member/index', array(), 1,'视频收藏删除成功...');
		}
		else
		{
			$this->lists();
		}
	}
}
?>