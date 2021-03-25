<?php

class Api_UserCtl extends Api_Controller
{
	public function getUserInfo()
	{
		$user_id = request_int('user_id');

        if(!$user_id){
            return $this->data->addBody(-140, array('user_id'=>$user_id),__('数据有误'),250);
        }
		$user_info_row = array();

        $User_InfoModel = new User_InfoModel();
        $user_row = $User_InfoModel->getOne($user_id);

        if ($user_row)
        {
            $User_InfoDetailModel = new User_InfoDetailModel();
            $user_info_row = $User_InfoDetailModel->getOne($user_row['user_name']);
			$user_info_row['password'] = $user_row['password'];
			$user_info_row['user_id'] = $user_id;
            return $this->data->addBody(-140, $user_info_row);
        }
        else
        {
            return $this->data->addBody(-140, array('data'=>$user_row),__('数据有误'),250);
        }

	}


	//获取列表信息
	public function listUser()
	{
		$skey = request_string('skey');
		$page = $_REQUEST['page'];
		$rows = $_REQUEST['rows'];
		$asc = $_REQUEST['asc'];
		$userInfoModel = new User_InfoDetailModel();

		$items = array();
		$cond_row = array();
		$order_row = array();

		if($skey)
		{
			$cond_row['user_name:LIKE'] = '%'.$skey.'%';
		}

		$data = $userInfoModel->getInfoDetailList($cond_row, array('user_reg_time'=>'DESC'), $page, $rows);

		if($data){
			$msg = 'success';
			$status = 200;
		}
		else{
			$msg = 'failure';
			$status = 250;
		}
		$this->data->addBody(-140,$data,$msg,$status);
	}


    function details()
    {
        $user_name = request_string('id');
        $status = $_REQUEST['server_status'];
        //开启事物
        $User_InfoDetailModel  = new User_InfoDetailModel();
    
        $data = $User_InfoDetailModel->getOne($user_name);
    
        $User_InfoModel = new User_InfoModel();
        $user_id = $User_InfoModel->getUserIdByName($user_name);
    
        //扩展字段
        $User_OptionModel = new User_OptionModel();
        $user_option_rows = $User_OptionModel->getByWhere(array('user_id'=>$user_id));
    

        if ($user_option_rows)
        {
            $Reg_OptionModel = new Reg_OptionModel();
            $reg_opt_rows = $Reg_OptionModel->getByWhere(array('reg_option_active'=>1));
        
        
            foreach ($user_option_rows as $user_option_id=>$user_option_row)
            {
                $user_option_row['reg_option_name'] = $reg_opt_rows[$user_option_row['reg_option_id']]['reg_option_name'];
                
                $user_option_rows[$user_option_id] = $user_option_row;
            }
        }

        $data['user_option_rows'] = $user_option_rows;
        
        $this->data->addBody(-140, $data);
    }

  	function add()
	{
		  	$user_name 	= request_string('user_name');
			$password 	= request_string('password'); 
			$User_InfoModel = new User_InfoModel();
		    $User_InfoDetail = new User_InfoDetailModel();

			$Db       = Yf_Db::get('ucenter');
			$seq_name = 'user_id';
			$user_id  = $Db->nextId($seq_name);

			$cond_row = array();

			$cond_row['user_id'] = $user_id;
			$cond_row['user_name']	 = $user_name;
			$cond_row['password'] 	 = md5($password); 
			$user_info = $User_InfoModel->getOneByWhere($cond_row); 
			$data = array();
			if(!$user_name || !$password){
					$status = 250;
					$msg    = '参数错误';
			}else{
					if($user_info)
					{
						$msg    = '用户已存在';
						$status = 250;
						
					}
					else
					{ 
						$last_id = $User_InfoModel->addInfo($cond_row,true);

						$arr_field_user_info_detail = array();
						$now_time = time();
						$ip       = get_ip();
						$arr_field_user_info_detail['user_name']           = $user_name;
						$arr_field_user_info_detail['user_reg_time']       = $now_time;
						$arr_field_user_info_detail['user_count_login']    = 1;
						$arr_field_user_info_detail['user_lastlogin_time'] = $now_time;
						$arr_field_user_info_detail['user_lastlogin_ip']   = $ip;
						$arr_field_user_info_detail['user_reg_ip']         = $ip;

						$User_InfoDetail->addInfoDetail($arr_field_user_info_detail);
						
						$msg    = 'success';
						$status = 200;
						$data['id'] = $last_id; 
					}
			}
			
			$this->data->addBody(-1, $data, $msg, $status);
	}

	function change()
	{
       
		$user_name = request_string('id');
		$status = $_REQUEST['server_status'];
		$userInfoModel = new User_InfoModel();

		if($user_name)
		{
			$data['user_state'] = $status;
			$user_id = $userInfoModel->getUserIdByName($user_name);
			$flag = $userInfoModel->editInfo($user_id, $data);

			if(false !== $flag)
			{
				$msg = 'success';
				$status = 200;
			}
			else
			{
				$msg = 'failure';
				$status = 250;
			}
		}
		$this->data->addBody(-140,array(),$msg,$status);
	}

	//解除绑定,生成验证码,并且发送验证码
	public function getYzm()
	{
		$type = request_string('type');
		$val  = request_string('val');

		$cond_row['code'] = 'Lift verification';

		$Message_TemplateModel = new Message_TemplateModel();

		$de = $Message_TemplateModel->getTemplateDetail($cond_row);

		fb($de);
		if ($type == 'mobile')
		{
			$me = $de['content_phone'];

			$code_key = $val;
			$code     = VerifyCode::getCode($code_key);
			$me       = str_replace("[weburl_name]", $this->web['web_name'], $me);
			$me       = str_replace("[yzm]", $code, $me);

			$str = Sms::send($val, $me);
		}
		else
		{
			$me    = $de['content_email'];
			$title = $de['title'];

			$code_key = $val;
			$code     = VerifyCode::getCode($code_key);
			$me       = str_replace("[weburl_name]", Web_ConfigModel::value("site_name"), $me);
			$me       = str_replace("[yzm]", $code, $me);
			$title    = str_replace("[weburl_name]", Web_ConfigModel::value("site_name"), $title);

			$str = Email::send($val, Perm::$row['user_account'], $title, $me);
		}
		$status = 200;
		$data   = array($code);
		$msg    = "success";
		$this->data->addBody(-140, $data, $msg, $status);

	}

	/**
	 * 修改会员密码
	 *
	 * @access public
	 */
	public function editUserPassword()
	{
		$user_name   = request_string('user_id');
		$user_password = request_string('user_password');

		$User_InfoModel = new User_InfoModel();
		$rs_row = array();

		//开启事务
		$User_InfoModel->sql->startTransactionDb();

		if($user_name && $user_password)
		{
			$user_id = $User_InfoModel->getUserIdByName($user_name);

			$edit_user['password'] = md5($user_password);
			$flag = $User_InfoModel->editInfo($user_id,$edit_user);
			check_rs($flag, $rs_row);
		}

		$flag = is_ok($rs_row);

		if ($flag && $User_InfoModel->sql->commitDb())
		{
			$status = 200;
			$msg    = _('success');
		}
		else
		{
			$User_InfoModel->sql->rollBackDb();
			$status = 250;
			$msg    = _('failure');
		}

		$data = array();
		$this->data->addBody(-140, $data, $msg, $status);
	}

	/**
	 * 修改会员头像
	 *
	 * @access public
	 */
	public function editUserImg()
	{
		$user_id   = request_int('user_id');
		$User_Info = new User_Info();
		$user_info = current($User_Info->getInfo($user_id));
		$user_name = $user_info['user_name'];

		$userInfoModel  = new User_InfoDetailModel();
		$edit_user_row['user_avatar'] = request_string('user_avatar');

		$flag = $userInfoModel->editInfoDetail($user_name, $edit_user_row);
//		$data = array();
//		$data[0] = $user_name;
//		$this->data->addBody(-140, $edit_user_row);
		$data = array();
		//echo '<pre>';print_r($flag);exit;
		if ($flag === false)
		{
			$status = 250;
			$msg    = _('failure');
		}
		else
		{
			$status = 200;
			$msg    = _('success');
			$data[0] = $flag;
			$res = $userInfoModel->sync($user_id);
			//$userInfoModel->sync($user_id);
		}
		
		$this->data->addBody(-140, $data, $msg, $status);
	}


	/**
	 * 修改会员信息
	 *
	 * @access public
	 */
	public function editUserInfoDetail()
	{
		$user_id   = request_int('user_id');
		$User_Info = new User_Info();
		$user_info = current($User_Info->getInfo($user_id));
		$user_name = $user_info['user_name'];
		
//		$year    = request_int('year');
//		$month   = request_int('month');
//		$day     = request_int('day');
//		$user_qq = request_string('user_qq');

		$edit_user_row['user_birth']      = request_string('user_birth');
		$edit_user_row['user_gender']     = request_int('user_gender');
		$edit_user_row['user_truename']   = request_string('user_truename');
		$edit_user_row['user_provinceid'] = request_int('province_id');
		$edit_user_row['user_cityid']     = request_int('city_id');
		$edit_user_row['user_areaid']     = request_int('area_id');
		$edit_user_row['user_area']       = request_string('user_area');
		$edit_user_row['nickname']       = request_string('nickname');
		$edit_user_row['user_sign']       = request_string('user_sign');
		$edit_user_row['user_province']       = request_string('user_province');
		$edit_user_row['user_city']       = request_string('user_city');
		
		//$edit_user_row['user_ww'] = $user_ww;
		//echo '<pre>';print_r($edit_user_row);exit;
		$userInfoModel  = new User_InfoDetailModel();
		$userPrivacyModel = new User_PrivacyModel();

		if (!$userPrivacyModel->getOne($user_id))
		{
			$userPrivacyModel->addPrivacy(array('user_id'=>$user_id));
		}

		if (!$userInfoModel->getOne($user_name))
		{
			$userInfoModel->addInfoDetail(array('user_name'=>$user_name));
		}

		//开启事物
		$rs_row = array();
		$userInfoModel->sql->startTransactionDb();

		//$flagPrivacy = $this->userPrivacyModel->editPrivacy($user_id, $rows);
		//check_rs($flagPrivacy, $rs_row);
		$flag = $userInfoModel->editInfoDetail($user_name, $edit_user_row);
		check_rs($flag, $rs_row);
		$flag_status = array();
		$flag_status[0] = $flag;

		$flag = is_ok($rs_row);
		$flag_status[1] = $flag;
		$res = array();
		if ($flag && $userInfoModel->sql->commitDb())
		{
			$status = 200;
			$msg    = _('success');

			$res = $userInfoModel->sync($user_id);
		}
		else
		{
			$userInfoModel->sql->rollBackDb();
			$status = 250;
			$msg    = _('failure');

		}


		$this->data->addBody(-140, $flag_status, $msg, $status);
	}


	/**
	 * 修改会员信息
	 *
	 * @access public
	 */
	public function editUserInfo()
	{
		$user_id   = request_int('user_id');
		$User_Info = new User_Info();
		$user_info = current($User_Info->getInfo($user_id));
		$user_name = $user_info['user_name'];
		$edit_user_row['user_gender']     = request_int('user_gender');
		$edit_user_row['user_avatar']   = request_string('user_logo');
		$user_delete = request_int('user_delete');

		//开启事物
		$User_InfoDetailModel  = new User_InfoDetailModel();
		$rs_row = array();
		$User_InfoDetailModel->sql->startTransactionDb();

		$User_InfoModel = new User_InfoModel();
		$user_row = $User_InfoModel->getOne($user_id);
		if($user_delete)
		{
			$edit_user['user_state'] = 3;
			$flagState =$User_InfoModel->editInfo($user_id,$edit_user);
			check_rs($flagState, $rs_row);
		}
		else
		{
			if($user_row['user_state'] == 3)
			{
				$edit_user['user_state'] = 0;  //解禁后用户状态恢复到未激活
				$flagState =$User_InfoModel->editInfo($user_id,$edit_user);
				check_rs($flagState, $rs_row);
			}
		}

		$flag = $User_InfoDetailModel->editInfoDetail($user_name, $edit_user_row);
		check_rs($flag, $rs_row);

		$flag = is_ok($rs_row);

		if ($flag && $User_InfoDetailModel->sql->commitDb())
		{
			$status = 200;
			$msg    = _('success');


			$User_InfoDetailModel->sync($user_id);
		}
		else
		{
			$User_InfoDetailModel->sql->rollBackDb();
			$status = 250;
			$msg    = _('failure');

		}

		$data = array();
		$this->data->addBody(-140, $data, $msg, $status);
	}
	
	public function checkUserAccount()
	{
		$user_name 	= request_string('user_name');
		$password 	= request_string('password');

		$User_InfoModel = new User_InfoModel();
		$cond_row = array();
		$cond_row['user_name']	 = $user_name;
		$cond_row['password'] 	 = md5($password);

		$user_info = $User_InfoModel->getOneByWhere($cond_row);

		$data = array();
		if($user_info)
		{
			$data['user_id'] 	= $user_info['user_id'];
			$data['user_name'] 	= $user_info['user_name'];
			$data['password'] 	= $user_info['password'];
			$msg    = 'success';
			$status = 200;

			// cookie login
			 
					 $session_id   = $user_info['session_id'];
					 $d            = array();
		       $d['user_id'] = $user_info['user_id'];
					 $data['k'] = Perm::encryptUserInfo($d, $session_id); 
					 
			 
			//
		}
		else
		{
			$msg    = '用户不存在';
			$status = 250;
		}
		$this->data->addBody(-1, $data, $msg, $status);

	}


	/*webpos通过用户名获取用户id
 * */
	public function getUserIdByUsername(){
		$user_name = request_string('user_name');
		$User_InfoModel = new User_InfoModel();
		$user_info_data = $User_InfoModel->getOneByWhere(['user_name'=>$user_name]);
		$data = [];
		if($user_info_data)
		{
			$data['user_id'] = $user_info_data['user_id'];
			$msg = 'success';
			$status = 200;
		}
		else
		{
			$msg = 'failure:用户还没注册';
			$status = 250;
		}
		$this->data->addBody(-140, $data, $msg, $status);
	}

	//修改绑定手机
	public function editMobileInfo()
	{
		$user_id   = request_int('user_id');
		$user_name = request_string('user_name');
		$user_mobile = request_string('user_mobile');

		$rs_row = array();
		$data = array();

		//检查手机号是否被使用
		$userInfoDetailModel = new User_InfoDetail();
		$check_user_name = $userInfoDetailModel->checkUserName($user_mobile);
		if($check_user_name)
		{
			$data['code'] = 2;
			$this->data->addBody(-140, $data, __('该手机已经被使用'), 250);
		}

		//检查用户信息
		$cond_user['user_id'] = $user_id;
		$userModel = new User_InfoModel();
		$user_info_row = $userModel->getOne($cond_user);
		if (!$user_info_row)
		{
			$data['code'] = 3;
			$this->data->addBody(-140, $data, __('用户信息有误'), 250);
		}

		//查找bind绑定表
		$new_bind_id = sprintf('mobile_%s', $user_mobile);
		$User_BindConnectModel = new User_BindConnectModel();
		$bind_info             = $User_BindConnectModel->getOne($new_bind_id);
		if (isset($bind_info['user_id']) && $bind_info['user_id'] != $user_id)
		{
			$data['code'] = 4;
			$this->data->addBody(-140, $data, __('该手机已经被使用'), 250);
		}

		//开启事务
		$User_InfoModel = new User_InfoDetailModel();
		$User_InfoModel->sql->startTransactionDb();

		//查找该用户之前是否已经绑定手机号，如果有的话需要删除
		$user_mobile_bind = $User_BindConnectModel->getByWhere(array('user_id'=>$user_id,'bind_type'=>$User_BindConnectModel::MOBILE));
		if($user_mobile_bind)
		{
			$old_bind_id_row = array_keys($user_mobile_bind);
			//将之前用户绑定的手机号删除
			$flag_remove = $User_BindConnectModel->removeBindConnect($old_bind_id_row);
			check_rs($flag_remove,$rs_row);
		}

		//该手机号可用，将手机号写入用户详情表中，验证状态为已验证
		if($user_name)
		{
			$edit_user_row['user_mobile']        = $user_mobile;
			$edit_user_row['user_mobile_verify'] = 1;
			$flag_edit = $User_InfoModel->editInfoDetail($user_name, $edit_user_row);
			check_rs($flag_edit,$rs_row);
		}else{
			$flag_edit = true;
		}
		if ($flag_edit === false)
		{
			$User_InfoModel->sql->rollBackDb();
			$data['code'] = 5;
			$this->data->addBody(-140, $data, __('绑定失败'), 250);
		}

		//用户信息表中的手机号修改完成后，修改绑定表中的数据
		//添加mobile绑定.
		//绑定标记：mobile/email/openid  绑定类型+openid
		//插入绑定表
		if (isset($bind_info['user_id']) && $bind_info['user_id'] == $user_id)
		{
			check_rs(true,$rs_row);
		}
		else
		{
			$time = date('Y-m-d H:i:s', time());
			$bind_array = array('bind_id' => $new_bind_id, 'user_id' => $user_id, 'bind_type' => $User_BindConnectModel::MOBILE, 'bind_time' => $time);
			$flag_add = $User_BindConnectModel->addBindConnect($bind_array);
			if ($flag_add)
			{
				//将用户原来绑定的手机号删除
				$bind_id = sprintf('mobile_%s', $user_info_row['user_mobile']);
				$flag_del = $User_BindConnectModel->removeBindConnect($bind_id);
				check_rs($flag_del,$rs_row);
			}
		}

		$flag = is_ok($rs_row);

		$User_InfoModel->sync($user_id);

		if ($flag && $User_InfoModel->sql->commitDb())
		{
			$status = 200;
			$msg    = __('操作成功');
		}
		else
		{
			$User_InfoModel->sql->rollBackDb();
			$msg    =  __('操作失败');
			$status = 250;
		}

		$this->data->addBody(-140, $data, $msg, $status);

	}
	public function test1(){
				$this->data->addBody(100, array());

	}
	public function getUserInfoDetail()
	{
		$user_name = request_string('user_name');

		$User_InfoDetailModel = new User_InfoDetailModel();

		$user_info = $User_InfoDetailModel->getInfoDetail($user_name);

		$this->data->addBody(100, $user_info);

	}
	//计划任务查询会员数据异动纪录需要修改会员信息
    public function editInfo()
    {
        $User_InfoModel = new User_InfoModel();
        $User_InfoDetailModel = new User_InfoDetailModel();
        //数据
        $param['MemberID']        = request_string('MemberID');
        
        if (request_string('user_name')) {
            $param['user_truename']   = request_string('user_name');
        }
        if (request_string('user_idcard')) {
            $param['user_idcard']     = request_string('user_idcard');
        }
        if (request_string('par_member')) {
            $param['par_member']      = request_string('par_member');  //辅导直销员编号
        }
        if (request_string('user_birth')) {
            $param['user_birth']      = request_string('user_birth');
        }
        if (request_string('user_gender')) {
            $param['user_gender']     = request_string('user_gender');
        }
        if (request_string('user_mobile')) {
            $param['user_mobile']     = request_string('user_mobile');
        }
        if (request_string('user_email')) {
            $param['user_email']      = request_string('user_email');
        }
        if (request_string('bankno')) {
            $param['bankno']          = request_string('bankno');          //银行类别
        }
        if (request_string('bankaccount')) {
            $param['bankaccount']     = request_string('bankaccount');        //银行账号
        }
        if (request_string('bankprovince')) {
            $param['bankprovince']    = request_string('bankprovince');      //开户行所在省
        }
        if (request_string('bankcity')) {
            $param['bankcity']        = request_string('bankcity');      //开户行所在市
        }
        if (request_string('bankbranch')) {
            $param['bankbranch']      = request_string('bankbranch');    //银行分行名称
        }
        if (request_string('banksubranch')) {
            $param['banksubranch']    = request_string('banksubranch'); //银行支行名称
        }
        if (request_string('MemberStatus')) {
            $param['MemberStatus']    = request_string('MemberStatus');  //订购注记 会员状态  C:过期D:冻结F:严重取消N:有效Q:取消S:移转
        }
        if (request_string('OrderFlag')) {
            $param['OrderFlag']       = request_string('OrderFlag');     //Y:可订购、N:不可订购
        }
        if (request_string('CertificateType')) {
            $param['CertificateType'] = request_string('CertificateType');
        }
        if (request_string('ImageIDNo')) {
            $param['ImageIDNo']       = request_string('ImageIDNo');     //身份证图檔(正面)
        }
        if (request_string('ImageIDNo2')) {
            $param['ImageIDNo2']      = request_string('ImageIDNo2');    //身份证图檔(反面)
        }
        if (request_string('ImageBank')) {
            $param['ImageBank']       = request_string('ImageBank'); //银行卡图檔 图檔名称
        }
        if (request_string('UpdateTime')) {
            $param['UpdateTime']      = request_string('UpdateTime'); //异动日期 当地时间 必填
        }
        

        //回传user_id给shop端修改订购状态
        $userinfo = $User_InfoModel->getInfoByName(request_string('MemberID'));


        $user_name = request_string('MemberID'); //需求改动-user_name插入了会员编号

        $flag = $User_InfoDetailModel->editInfoDetail($user_name,$param);
        
        if ($flag) {
            $msg    = 'success';
            $status = 200;
        }else{
            $msg    = 'failure';
            $status = 250;
        }
           
        $data = array();

        //修改paycenter 身份证图片
        $arr['user_id'] = $userinfo['user_id'];
        
		$key = Yf_Registry::get('paycenter_api_key');
		$url = Yf_Registry::get('paycenter_api_url');
		$arr['app_id'] = Yf_Registry::get('paycenter_app_id');
		$arr['ctl'] 		= 'Api_User_Info';
		$arr['met'] 		= 'idCardImg';
		$arr['typ'] 		= 'json';
		if (request_string('ImageIDNo')) {
            $arr['ImageIDNo'] 	 	= request_string('ImageIDNo');     //身份证图檔(正面)
        }
        if (request_string('ImageIDNo2')) {
            $arr['ImageIDNo2']      = request_string('ImageIDNo2');    //身份证图檔(反面)
        }

		$res = get_url_with_encrypt($key, $url, $arr);


        return $this->data->addBody(100,$data,$msg, $status);
    }

    public function getOpenid()
    {
    	$user_id = request_string("user_id");
    	$User_BindConnectModel = new User_BindConnectModel();

    	$cond_row['bind_type'] = User_BindConnectModel::WEIXIN;
    	$cond_row['user_id'] = $user_id;
    	$data = array();
    	$data = $User_BindConnectModel->getOneByWhere($cond_row);

    	return $this->data->addBody(100,$data);
	}
	public function getUserInfoAll(){
		$user_name = request_string('user_name');
		$User_InfoDetailModel = new User_InfoDetailModel();
		$data = $User_InfoDetailModel->getOneByWhere(array('user_name'=>$user_name));
		$data['user_sex'] =  _(User_InfoDetailModel::$userSex[$data['user_gender']]);
		$this->data->addBody(-140,$data);
	}
}

?>