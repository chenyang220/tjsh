<?php if (!defined('ROOT_PATH')) exit('No Permission');
/**
 * @author     Xinze <xinze@live.cn>
 */
class IndexCtl extends Yf_AppController
{
    public function index()
    {
		//如果已经登录,则直接跳转
		if (!Perm::checkUserPerm())
		{
			$data = Perm::$row;

			$k = $_COOKIE[Perm::$cookieName];
			$u = $_COOKIE[Perm::$cookieId];

			if (isset($_REQUEST['callback']) && $_REQUEST['callback'] )
			{
				$url = $_REQUEST['callback'] . '&us=' . $u . '&ks=' . urlencode($k);

			}
			else
			{
				$url = './index.php?ctl=Login';
			}

			header('location:' . $url);
		}

		$url = './index.php?ctl=User&met=getUserInfo1';

		header('location:' . $url);

        //include $this->view->getView();
    }

    public function main()
    {
		include $this->view->getView();
    }

	public function img()
	{
		$user_id = request_int('user_id');

		if ($user_id)
		{
			$User_InfoModel = new User_InfoModel();
			$user_row = $User_InfoModel->getOne($user_id);

			if ($user_row)
			{
				$User_InfoDetailModel = new User_InfoDetailModel();
				$user_info_row = $User_InfoDetailModel->getOne($user_row['user_name']);

				//原图
				if ($user_info_row['user_avatar'])
				{
					location_to($user_info_row['user_avatar']);
				}
				else
				{
					$this->get_avatar();
				}
			}
			else
			{
				$this->get_avatar();
			}
		}
		else
		{ 
			$this->get_avatar();
		}
	}
	/**
	 * 默认头像设置
	 */
	protected function get_avatar(){
			$img_url = Web_ConfigModel::value('user_default_avatar');
			$host = $_SERVER['HTTP_HOST']?:$_SERVER['SERVER_NAME'];
			if($img_url && strpos($img_url,$host)!==false){

			}else{
				$img_url = Yf_Registry::get('static_url') .'/images/default_user_portrait.gif';
			} 
			location_to($img_url);
	}
	//API文件无权限，所以放这里测试用 会员状态变更,修改B2C会员订购状态
	//http://139.196.51.206/bbc_tjsh/ucenter/index.php?ctl=Index&met=UpMebStatus&typ=e
	public function UpMebStatus()
	{

        $aes        = new AesCryptStatus();        
        $result = $aes->decrypt($_REQUEST['data']); //解密,无需转码,返回json数据
       
        $result = json_decode($result,true);
 		
        $User_InfoDetailModel        = new User_InfoDetailModel();
        $User_InfoModel        		 = new User_InfoModel();

        if($result['MemberID']){
	        $userinfo = $User_InfoDetailModel->getOneByWhere(array('MemberID'=>$result['MemberID']));

	        $userinfo1= $User_InfoModel->getOneByWhere(array('user_name'=>$result['MemberID'])); //拿出user_id用于shop端修改订购状态
        }
        if ($userinfo) {
	        $res = $User_InfoDetailModel->editInfoDetail($userinfo['user_name'],array('MemberStatus'=>$result['MemberStatus'],'OrderFlag'=>$result['OrderFlag']));

	        //修改shop端黑名单的数据
	        $key = Yf_Registry::get('shop_api_key');
	        $url = Yf_Registry::get('shop_api_url');
	        $formvars['app_id'] = Yf_Registry::get('shop_app_id');
	        $formvars['ctl'] = 'Api';
	        $formvars['met'] = 'IsBlackList';
	        $formvars['user_id'] = $userinfo1['user_id'];
	        $formvars['typ'] = 'json';
	        $formvars['OrderFlag'] = $result['OrderFlag'];
	    
	        $result = get_url_with_encrypt($key, $url, $formvars);

        }else{
        	$data['Result'] 	= -1;
        	$data['ResultCode'] = 250;
        	$data['ResultDesc'] = '会员编号不存在';
        }
        

        if ($res == 1) {
        	$data['Result'] 	= 1;
        	$data['ResultCode'] = '';
        	$data['ResultDesc'] = '成功';

        }else{
        	$data['Result'] 	= -1;
        	$data['ResultCode'] = '';
        	$data['ResultDesc'] = '失败';
        }

        $data  = $aes->encrypt(json_encode($data,320)); //AES加密返回 320防止中文转译乱码或日期多反斜杠
		header('Content-type: application/json');
		echo $data;
    }

    public function UpMebStatusy()
    {

        $aes        = new AesCryptStatus();
        $result = $aes->decrypt($_REQUEST['data']); //解密,无需转码,返回json数据

        $result = json_decode($result,true);

        $User_InfoDetailModel        = new User_InfoDetailModel();
        $User_InfoModel        		 = new User_InfoModel();

        if($result['MemberID']){
            $userinfo = $User_InfoDetailModel->getOneByWhere(array('MemberID'=>$result['MemberID']));

            $userinfo1= $User_InfoModel->getOneByWhere(array('user_name'=>$result['MemberID'])); //拿出user_id用于shop端修改订购状态
        }
        if ($userinfo) {
            $res = $User_InfoDetailModel->editInfoDetail($userinfo['user_name'],array('MemberStatus'=>$result['MemberStatus'],'OrderFlag'=>$result['OrderFlag']));

            //修改shop端黑名单的数据
            $key = Yf_Registry::get('shop_api_key');
            $url = Yf_Registry::get('shop_api_url');
            $formvars['app_id'] = Yf_Registry::get('shop_app_id');
            $formvars['ctl'] = 'Api';
            $formvars['met'] = 'IsBlackList';
            $formvars['user_id'] = $userinfo1['user_id'];
            $formvars['typ'] = 'json';
            $formvars['OrderFlag'] = $result['OrderFlag'];

            $result = get_url_with_encrypt($key, $url, $formvars);

        }else{
            $data['Result'] 	= -1;
            $data['ResultCode'] = 250;
            $data['ResultDesc'] = '会员编号不存在';
        }

        if ($res == 1) {
            $data['Result'] 	= 1;
            $data['ResultCode'] = '';
            $data['ResultDesc'] = '成功';

        }else{
            $data['Result'] 	= -1;
            $data['ResultCode'] = '';
            $data['ResultDesc'] = '失败';
        }

        $data  = $aes->encrypt(json_encode($data,320)); //AES加密返回 320防止中文转译乱码或日期多反斜杠
        header('Content-type: application/json');
        echo $data;
    }

    public function addUser()
	{  $User_InfoModel = new User_InfoModel();
		$userinfo = $User_InfoModel->getInfoByName('5133707');
         //修改paycenter 身份证图片
        $arr['user_id'] = $userinfo['user_id'];
       
        $key = Yf_Registry::get('ucenter_api_key');
        $url = Yf_Registry::get('paycenter_api_url');
        $arr['app_id'] = Yf_Registry::get('ucenter_app_id');
        $arr['ctl']         = 'Api_User_Info';
        $arr['met']         = 'idCardImg';
        $arr['typ'] = 'json';

        //if (request_string('ImageIDNo')) {
            $arr['ImageIDNo']       = '3333.jpg';//request_string('ImageIDNo');     //身份证图檔(正面)
        // }
        //if (request_string('ImageIDNo2')) {
            $arr['ImageIDNo2']      = '4444.jpg';//request_string('ImageIDNo2');    //身份证图檔(反面)
        //}

        $res = get_url_with_encrypt($key, $url, $arr);

        $msg    = 'success';
        $status = 200;
        
        return $this->data->addBody(100,array($res),$msg, $status);
	}
	public function blog(){
		// https://shpict.blob.core.chinacloudapi.cn/su00ss/Images/Member/527816198001018720_20181225091048-06.jpg?sv=2017-04-17&ss=b&srt=o&sp=rl&se=2117-10-26T21:56:53Z&st=2017-10-26T13:56:53Z&spr=https,http&sig=UeVeSf4E%2F%2F%2B2V7vP%2FtC%2BnT7r%2BsmWUGtueNBAxCYJdSg%3D
        // $ImageIDNo_blobName       = $user_info['user_idcard']."_".date("YmdHis")."-02.jpg";
		$arr['myContainer']       = "sutest/Images/Member";
        $arr['blobName']          = '130722198605196715_2035345345417-06.jpg';
		$arr['file_url']          = 'http://106.12.12.214/bbc_tjsh/ucenter/image.php/ucenter/data/upload/media/plantform/image/20190530/1559193710748504.jpg';
        $url                      = "http://106.12.10.179/test/blobModel.php";
		$ImageBank1               =	get_url($url,$arr,'JSON','POST','','','');
		var_dump($ImageBank1);die;
    }











}
?>