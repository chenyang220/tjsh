<?php if (!defined('ROOT_PATH'))
{
	exit('No Permission');
}

/**
 * @author     Xinze <xinze@live.cn>
 */
class WexinCtl extends Yf_AppController
{
	public   $app_id = "wxe9718e064b864d69";
	public   $app_secret = "7f16fa4a1b6b668ca71161259a3630d2";
	public   $app_mark = null;
	/**
	 * Constructor
	 *
	 * @param  string $ctl 控制器目录
	 * @param  string $met 控制器方法
	 * @param  string $typ 返回数据类型
	 * @access public
	 */
	public function __construct(&$ctl, $met, $typ)
	{
		parent::__construct($ctl, $met, $typ);

	}

	public function index()
    {
    	//验证TOKEN
    	$echostr 		 = $_GET["echostr"]; //第一次验证的时候需要
    	$shop_identifier = $_GET['shop_identifier']; //业务需要 与微信验证无关

    	if( $this->checkSignature() && $echostr ){
    		echo $echostr;
    	} else {
    		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
		    $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;
            $keyword = trim($postObj->Content);
            $time = time();
			$RX_TYPE = trim($postObj->MsgType);

			//如果存在店铺标识（每个店铺对应一个微信公众账号），调取店铺的微信公众账号 否则 采用默认的公众账号（平台的公众账号）
			if( $shop_identifier ) $this->getAppkey( $shop_identifier );

            // event  事件
			if($RX_TYPE == "event"){
                $eventname = $postObj->Event ;
				//关注事件
				if(strtolower($eventname) == 'subscribe')
				{
				   	// 获取openid
				    $openid  	  = $fromUsername ;
				    // 获取accesstoken
				    $bind_id      = sprintf('%s_%s', 'weixin',$openid);
				    $app_id       = $this->app_id ;
				    $app_secret   = $this->app_secret ;
				    $access_token = "";
				    $nickname     = "" ;
				    $headimgurl   = "" ;
				    $sex          = "1";
				    $user_id      =  "0" ;
				    $unionid      = "";
				    $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$app_id."&secret=".$app_secret;
	                $data = json_decode(file_get_contents($url),true);

	                if($data['access_token'])
	                {
		             	$access_token = $data['access_token'] ;
                     // 获取会员信息
					 	$userurl = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
                     	$userinfo = json_decode(file_get_contents($userurl),true);
					 	$nickname = $userinfo['nickname'];
						$headimgurl = $userinfo['headimgurl'];
					 	$sex = $userinfo['sex'];
					 	$unionid = $userinfo['unionid'];
	                }

                    $type = User_BindConnectModel::WEIXIN;
				    $User_BindConnectModel = new User_BindConnectModel();


					//排除所有与非法情况后，在绑定表中添加绑定信息
                     // 判断是否绑定
					$connect_rows = $User_BindConnectModel->getBindConnect($bind_id);
			        if($connect_rows)
		            {
			            $connect_row = array_pop($connect_rows);
					   	$user_id = $connect_row["user_id"] ;
					   	$data_row                      = array();
					   	$data_row['bind_nickname']     = $nickname ; // 名称
			           	$data_row['bind_avator']       = $headimgurl; //  头像
			           	$data_row['bind_gender']       = $sex; // 性别 1:男  2:女
					   	$data_row['bind_openid']       = $openid; // 访问
					   	$data_row['bind_token']        =  $openid; // 访问
					   	$data_row['wixinnunid']        =  $unionid ;
					   	$data_row['othertype']         = "1";
					   	$data_row['bind_type']         =  $User_BindConnectModel::WEIXIN ; // 微信关注
				        $connect_flag = $User_BindConnectModel->editBindConnect($bind_id, $data_row);
		            }else{
						$data = array();
				        $data['bind_id']           = $bind_id;
				        $data['bind_type']         =  $User_BindConnectModel::WEIXIN ; // 微信关注
				        $data['user_id']           = $user_id ;
						  //$data['othertype']           = "1";
				        $data['bind_nickname']     = $nickname ; // 名称
				        $data['bind_avator']         = $headimgurl ; //
				        $data['bind_gender']       = $sex; // 性别 1:男  2:女
				        $data['bind_openid']       = $openid; // 访问
			           	$data['bind_token'] 	   =  $openid ;
						  //$data['wixinnunid']       =  $unionid ;
						$connect_flag = $User_BindConnectModel->addBindConnect($data);
					}
					if($user_id == "0"){
					    // 通知去绑定手机号
                        $key = Yf_Registry::get('ucenter_api_key');
						$url = Yf_Registry::get('ucenter_api_url');
						$appid = Yf_Registry::get('ucenter_app_id');
						$t = $openid ;
						$fromc = "shop";
						$typec = "3" ;
						$callback = Yf_Registry::get('shop_api_url');
                        $bindurl     = sprintf('%s?ctl=%s&met=%s&t=%s&type=%s&from=%s&callback=%s', $url, 'Login', 'select', $t, $typec,$fromc,$callback);
						$content = "感谢您的关注，请点这里<a href='". $bindurl."' >绑定现有账号或绑定手机号</a>";
						   echo $this->response_text($postObj,$content);die;
					}else{
					   $content = "感谢您的再次关注";
					   echo $this->response_text($postObj,$content);die;
					}
	     		}
			} else {
				$jsonmenu = '{
				  "button":[
				  {
					"name":"官方店铺",
					"type":"view",
					"key":"官方店铺",
					"url":"http://esunhope.cn/bbc_tjsh/shop_wap/tmpl/store.html?shop_id=6"
				   },{
					"name":"关于我们",
					"type":"click",
					"key":"关于我们"
				   }]
				}';
				$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=" . $this->get_access_token();
				//$url = "https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=" . $this->get_access_token();
				$result = $this->https_request($url, $jsonmenu);
				var_dump($result);
			}
    	}


    }
	private function checkSignature(){

        $signature = $_GET["signature"];//微信加密签名，signature结合了开发者填写的token参数和请求中的timestamp参数、nonce参数。
        $timestamp = $_GET["timestamp"];//时间戳
        $nonce     = $_GET["nonce"];//随机数
        $token 	   = "Token_spzc";
      	$tmpArr    = array($token, $timestamp, $nonce);
      	sort($tmpArr);
      	$tmpStr    = implode( $tmpArr );
      	$tmpStr    = sha1( $tmpStr );

      	if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
	}



	//文本回复
	public function response_text($object,$content){
	    $textTpl = "<xml>
		                <ToUserName><![CDATA[%s]]></ToUserName>
		                <FromUserName><![CDATA[%s]]></FromUserName>
		                <CreateTime>%s</CreateTime>
		                <MsgType><![CDATA[text]]></MsgType>
		                <Content><![CDATA[%s]]></Content>
		                <FuncFlag>%d</FuncFlag>
	                </xml>";
	    $resultStr = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content,0);
	    return $resultStr;
	}

	//设置APPID
	public function setAppId( $app_id ){
		$this->app_id = $app_id;
	}

  	//设置Secret
	public function setAppSecret( $app_secret ){
		$this->app_secret = $app_secret;
	}

  	//设置APPmark
	public function setAppMark( $app_mark ){
		$this->app_mark = $app_mark;
	}


  	public function get_access_token()
	{
		$app_id = $this->app_id;
		$app_secret = $this->app_secret;
		$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$app_id."&secret=".$app_secret;

        $info = json_decode(file_get_contents($url),true);

		if($info['access_token'])
		{
			return $info['access_token'];
		}else{
			echo "Error";
			exit();
		}
	}

	public function https_request($url,$data = null)
	{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_SAFE_UPLOAD, false);
		curl_setopt($curl, CURLOPT_URL, $url);
		//curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		//curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		if (!empty($data)){
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		}
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($curl);
		curl_close($curl);
		return $output;
	}


    public function get_request($url)
    {
     	$curl = curl_init();
		curl_setopt($curl, CURLOPT_SAFE_UPLOAD, false);
		curl_setopt($curl, CURLOPT_URL, $url);
		//curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		//curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($curl);
		curl_close($curl);
		$data = json_decode($output);

		return $data;
    }



	public function post_request($url,$data = null){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
		if (!empty($data)){
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		}
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($curl);

		curl_close($curl);

        return $output;
	}

	//设置所属行业
	public function setIndustry(){
		$access_token = $this->get_access_token();
		$url = "https://api.weixin.qq.com/cgi-bin/template/api_set_industry?access_token=".$access_token;
		$msgdata = stripslashes('{"industry_id1":"1","industry_id2":"4"}');
		$this->post_request($url,$msgdata);
	}

	//获取设置的行业信息
	public function getIndustry(){
		$access_token = $this->get_access_token();
		$url = "https://api.weixin.qq.com/cgi-bin/template/get_industry?access_token=".$access_token;
		$data = $this->get_request();
		return $data;
	}

	//获得模板ID
	public function getTemplateId(){
		$access_token = $this->get_access_token();
		$url = "https://api.weixin.qq.com/cgi-bin/template/api_add_template?access_token=".$access_token;
		$msgdata = stripslashes('{"template_id_short":"TM00015"}');
		$data = $this->post_request($url,$msgdata);
		return $data;
	}


	//获取模板列表
	public function getTemplateList(){
		$access_token = $this->get_access_token();
		$url = "https://api.weixin.qq.com/cgi-bin/template/api_add_template?access_token=".$access_token;
		$msgdata = stripslashes('{"template_id_short":"TM00015"}');
		$data = $this->post_request($url,$msgdata);
		return $data;
	}

	//获取商城内，模板列表
    public function getTemList($tmpl_id){
        $key    = Yf_Registry::get('shop_api_key');
        $url    = Yf_Registry::get('shop_api_url');
        $app_id = Yf_Registry::get('shop_app_id');

        $formvars            = array();
        $formvars['app_id']  = $app_id;
        $formvars['tpl_id']  = $tmpl_id;
        $url     = sprintf('%s?ctl=%s&met=%s&typ=%s', $url, 'Wexin', 'getWxTemplateList', 'json');
        $data = get_url_with_encrypt($key, $url, $formvars);

	    return $data;
    }





	//获取用户绑定信息
	public function getUserBindInfo( $user_id ){
		$User_BindConnectModel = new User_BindConnectModel();
		$bind_id_row = array();
		$bind_id_row["user_id"] = $user_id;
		$bind_id_row["bind_type"] = "3" ;
        $data_rows = $User_BindConnectModel->getByWhere($bind_id_row);
        return $data_rows;
	}
	//推送模板消息
	public function sendTemplateMag(){
		$user_id = request_int('user_id');
		$user_bind = $this->getUserBindInfo( $user_id );
		if( $user_bind ){
			foreach ($user_bind as $key => $value) {
				$this->getAppkey( $value['bind_identifier'] );
				$access_token = $this->get_access_token();
				$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$access_token;
				$msgdata =  stripslashes('{
		           "touser":"opNgywBdzeR6NiGT0z1QOrZhNm7c",
		           "template_id":"E8muth9N3U9HqAW9s-W6i3MQ0QWgmSm967-AVo3Mn5w",
		           "url":"http://weixin.qq.com/download",           
		           "data":{
		                   "first": {
		                       "value":"恭喜你购买成功！",
		                       "color":"#173177"
		                   },
		                   "keyword1":{
		                       "value":"巧克力",
		                       "color":"#173177"
		                   },
		                   "keyword2": {
		                       "value":"39.8元",
		                       "color":"#173177"
		                   },
		                   "keyword3": {
		                       "value":"2014年9月22日",
		                       "color":"#173177"
		                   },
		                   "remark":{
		                       "value":"消息测试",
		                       "color":"#173177"
		                   }
		           }
		       }');
				echo $this->post_request($url,$msgdata);
			}
		}

		$data            = array();
		$data[] = $user_bind;
		$this->data->addBody(100, $data);

	}

	//推送模板消息
	public function sendImTemplateMag(){
		$user_id   = request_int('user_id');
//		$user_id   = 11212;
		$user_bind = $this->getUserBindInfo( $user_id );
		$title    = request_string( 'title');
		$data     = request_row('data');
		$remark   = request_string( 'remark' );
        $tmpl_id  = request_string('tmpl_id');

		if( $user_bind ){
			foreach ($user_bind as $key => $value) {

				$bind_openid = $value['bind_openid'];

				if( $value['bind_identifier'] ){
					$this->getAppkey( $value['bind_identifier'] );
				}
				$access_token = $this->get_access_token();

				$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$access_token;
				$msgdata =  stripslashes('{
		           "touser":"'.$bind_openid.'",
		           "template_id":"'.$tmpl_id.'",
		           "url":"http://esunhope.cn",      
		           "data":{
		                   "first": {
		                       "value":"'.$title.'",
		                       "color":"#173177"
		                   },
		                   "keyword1":{
		                       "value":"'.$data[0].'",
		                       "color":"#173177"
		                   },
		                   "keyword2":{
		                       "value":"'.$data[1].'",
		                       "color":"#173177"
		                   },
		                   "keyword3":{
		                       "value":"'.$data[2].'",
		                       "color":"#173177"
		                   },
		                   "keyword4":{
		                       "value":"'.$data[3].'",
		                       "color":"#173177"
		                   },
		                   "remark":{
		                       "value":"'.$remark.'",
		                       "color":"#173177"
		                   }
		           }
		       }');
				echo $this->post_request($url,$msgdata);
			}
		}
		$data            = array();
		$data['user'] = $user_bind;
		$this->data->addBody(100, $data);

	}

	public function sendMsg()
	{
		$user_id = request_string('user_id');
		$content = request_string('content');
	    $User_BindConnectModel = new User_BindConnectModel();
		$bind_id_row = array();
		$bind_id_row["user_id"] = $user_id;
		$bind_id_row["bind_type"] = "3" ;
        $data_rows = $User_BindConnectModel->getByWhere($bind_id_row);

		if(empty($content)){
		  $content  = "你好，请查收提醒信息";
		}

		if($data_rows){
			foreach($data_rows as $k=>$v){
				$this->getAppkey( $v['bind_identifier'] );
				$access_token = $this->get_access_token();

				$url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$access_token;

				$bind_openid  = $v["bind_openid"] ;
				if($bind_openid){
				   $msgdata = stripslashes('{"touser":"'.$bind_openid.'","msgtype":"text","text":{"content":"'.$content.'"}}');
				   $this->post_request($url,$msgdata);
				}
			}
		}

		$data            = array();
		$data[] = $data_rows;
		$this->data->addBody(100, $data);
	}

	public function getAppkey( $app_mark = null ){
		//本地读取远程信息
		$key = Yf_Registry::get('shop_api_key');
		$url    = Yf_Registry::get('shop_api_url');
		$app_id = Yf_Registry::get('shop_app_id');

		$formvars            = array();
		$formvars['u']       = request_int('us');
		$formvars['k']       = request_string('ks');
		$formvars['app_id']  = $app_id;
		$formvars['app_mark']= $app_mark;

		$url     = sprintf('%s?ctl=%s&met=%s&typ=%s', $url, 'Api_Appkey', 'getAppkey', 'json');
		$init_rs = get_url_with_encrypt($key, $url, $formvars);
		$appkey  = $init_rs['data'];

		if( $init_rs['status'] == 200 && $appkey ){
			$this->setAppId( $appkey['AppID'] );
			$this->setAppSecret( $appkey['AppSecret'] );
			$this->setAppMark( $appkey['AppMark'] );
		} else {
			//默认使用商城的公众号
		}
	}
}

?>