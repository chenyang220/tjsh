<?php
class TestCtl extends Yf_AppController
{

	public function addUser()
	{  $User_InfoModel = new User_InfoModel();
		$userinfo = $User_InfoModel->getInfoByName('5133707');
         //修改paycenter 身份证图片
        $arr['user_id'] = $userinfo['user_id'];
       
        $key = Yf_Registry::get('paycenter_api_key');
        $url = Yf_Registry::get('paycenter_api_url');
        $arr['app_id'] = Yf_Registry::get('paycenter_app_id');
        $arr['ctl']         = 'Api_User_Info';
        $arr['met']         = 'idCardImg';


        //if (request_string('ImageIDNo')) {
            $arr['ImageIDNo']       = '111111.jpg';//request_string('ImageIDNo');     //身份证图檔(正面)
        // }
        //if (request_string('ImageIDNo2')) {
            $arr['ImageIDNo2']      = '222222.jpg';//request_string('ImageIDNo2');    //身份证图檔(反面)
        //}

        $res = get_url_with_encrypt($key, $url, $arr);
        $msg    = 'success';
        $status = 200;
        
        return $this->data->addBody(100,array($res),$msg, $status);
	}

	public function blob()
	{
		//在user_info中插入用户信息
        $Db = Yf_Db::get('ucenter');
        $seq_name = 'user_id';
        $user_id = $Db -> nextId($seq_name);
        var_dump($user_id);die;
	}
	//请求伟盟快递单号
    public function EditUserDetail()
    {
        $images = 'https://shpict.blob.core.chinacloudapi.cn/su00ss/Images/Member/211381198501180267_20200305170446-01.jpg?sv=2017-04-17&ss=b&srt=o&sp=rl&se=2117-10-26T21:56:53Z&st=2017-10-26T13:56:53Z&spr=https,http&sig=UeVeSf4E%2F%2F%2B2V7vP%2FtC%2BnT7r%2BsmWUGtueNBAxCYJdSg%3D';
        $images2 = 'https://shpict.blob.core.chinacloudapi.cn/su00ss/Images/Member/211381198501180267_20200305170447-06.jpg?sv=2017-04-17&ss=b&srt=o&sp=rl&se=2117-10-26T21:56:53Z&st=2017-10-26T13:56:53Z&spr=https,http&sig=UeVeSf4E%2F%2F%2B2V7vP%2FtC%2BnT7r%2BsmWUGtueNBAxCYJdSg%3D';
        $result = '[{"Result":1,"ResultCode":"1500","ResultDesc":"成功","ParentMemberID":"1195717","Birthday":"1985/01/18","Sex":"F","ImageBank":"4705542_20191228115330_02.jpeg","AccountNameType":"0","AccountName":"荚晶","AccountType":"22","BankNo":"102","BankAccount":"6212260200055466862","BankCity":"北京市","BankTown":"北京市","BankBranch":"中国工商银行","BankSubBranch":"市辖区翠微路永定路支行","BankDept":"","BankDeposit":"","BankAgency":""}]';
        $result = json_decode($result,true);
        $memberid = '4705542';
        $password = '8346a6806386be760d84a7db4bcbe367';
        $user_name = '荚晶';
        $user_idcard = '211381198501180267';
        $email = '240073700@qq.com';
        $mobile = '18800183447';
        $User_InfoDetail = new User_InfoDetailModel();
        $rs_row = array();
        //用户是否存在
        $User_InfoModel = new User_InfoModel();
        $user_rows = $User_InfoDetail -> checkUserName($user_name);
        $user_name_info = $User_InfoModel -> getInfoByName($user_name);
        if (false) {
            $this ->data-> setError('用户已经存在,请更换用户名!');
            return false;
        } else {
            $User_InfoModel ->sql-> startTransaction();
            $Db = Yf_Db::get('ucenter');
            $seq_name = 'user_id';
            $user_id = $Db -> nextId($seq_name);
            $now_time = time();
            $ip = get_ip();
            $session_id = uniqid();
            $arr_field_user_info = array();
            $arr_field_user_info['user_id'] = $user_id;
            $arr_field_user_info['user_name'] = $memberid;
            $arr_field_user_info['password'] = $password;
            $arr_field_user_info['action_time'] = $now_time;
            $arr_field_user_info['action_ip'] = $ip;
            $arr_field_user_info['session_id'] = $session_id;

            $flag = $User_InfoModel -> addInfo($arr_field_user_info);

            array_push($rs_row, $flag);
            $arr_field_user_info_detail = array();
            //添加mobile绑定.
            //绑定标记：mobile/email/openid  绑定类型+openid
            $bind_id = sprintf('mobile_%s', $mobile);
            //查找bind绑定表
            $User_BindConnectModel = new User_BindConnectModel();
            $bind_info = $User_BindConnectModel -> getOne($bind_id);
            if (!$bind_info) {
                $time = date('Y-m-d H:i:s', time());
                    //插入绑定表
                   $bind_array = array(
                        'bind_id' => $bind_id,
                        'user_id' => $user_id,
                        'bind_type' => 12,
                        'bind_time' => $time
                    );
                    $flag = $User_BindConnectModel -> addBindConnect($bind_array);
                    array_push($rs_row, $flag);
                        //绑定关系
                        // if ($reg_checkcode == 1) {
                    $arr_field_user_info_detail['user_mobile_verify'] = 1;
                        // } else {
                    $arr_field_user_info_detail['user_email_verify'] = 1;
                        // }
            }
            $arr_field_user_info_detail['user_name'] = $memberid;
            if ($reg_checkcode == 1) {
            } else {
                $arr_field_user_info_detail['user_email'] = $email;
            }
            $arr_field_user_info_detail['user_mobile'] = $mobile;
            $arr_field_user_info_detail['user_truename'] = $user_name;
            $arr_field_user_info_detail['user_reg_time'] = $now_time;
            $arr_field_user_info_detail['user_count_login'] = 1;
            $arr_field_user_info_detail['user_lastlogin_time'] = $now_time;
            $arr_field_user_info_detail['user_lastlogin_ip'] = $ip;
            $arr_field_user_info_detail['user_reg_ip'] = $ip;
            $arr_field_user_info_detail['user_avatar'] = Web_ConfigModel::value('user_default_avatar', Yf_Registry::get('static_url') . '/images/default_user_portrait.png');
            $arr_field_user_info_detail['user_email_verify'] = 1; //邮箱也默认已验证

            $arr_field_user_info_detail['user_idcard']      = $user_idcard;
            $arr_field_user_info_detail['MemberID']         = $memberid;
            $arr_field_user_info_detail['user_email']       = $email;

            $arr_field_user_info_detail['par_member']       = $result[0]['ParentMemberID'];
            $arr_field_user_info_detail['user_birth']       = $result[0]['Birthday'];
            $arr_field_user_info_detail['user_gender']      = $result[0]['Sex'];
            if ($result[0]['Sex'] == 'F') {
                $arr_field_user_info_detail['user_gender']  = '0'; //女
            }else{
                $arr_field_user_info_detail['user_gender']  = '1'; //男
            }
            $arr_field_user_info_detail['ImageBank']        = $result[0]['ImageBank'];
            $arr_field_user_info_detail['AccountType']      = $result[0]['AccountType'];        //银帐户证号型态 22: 对私帐号 32: 对公帐号
            $arr_field_user_info_detail['bankno']           = $result[0]['BankNo'];      //开户行所在省
            $arr_field_user_info_detail['bankaccount']      = $result[0]['BankAccount'];
            $arr_field_user_info_detail['bankprovince']     = $result[0]['BankCity'];
            $arr_field_user_info_detail['bankcity']         = $result[0]['BankTown'];
            $arr_field_user_info_detail['bankbranch']       = $result[0]['BankBranch'];
            $arr_field_user_info_detail['banksubranch']     = $result[0]['BankSubBranch'];
            $arr_field_user_info_detail['ImageIDNo']        = $images;
            $arr_field_user_info_detail['ImageIDNo2']       = $images2;
            //加入日志
            Yf_Log::log("register2:" . json_encode($arr_field_user_info_detail), Yf_Log::INFO, 'register2_Submit');  //register2是接口返回的数据并要插入数据库
            $flag = $User_InfoDetail -> addInfoDetail($arr_field_user_info_detail);
            array_push($rs_row, $flag);
            $User_OptionModel = new User_OptionModel();
            foreach ($reg_opt_rows as $reg_option_id => $reg_opt_row) {
                if (isset($option_value_row[$reg_option_id])) {
                    $reg_option_value_row = explode(',', $reg_opt_row['reg_option_value']);
                    $user_option_row = array();
                    $user_option_row['reg_option_id'] = $reg_option_id;
                    $user_option_row['reg_option_value_id'] = $option_value_row[$reg_option_id];
                    $user_option_row['user_id'] = $user_id;
                    $user_option_row['user_option_value'] = isset($reg_option_value_row[$option_value_row[$reg_option_id]]) ? $reg_option_value_row[$option_value_row[$reg_option_id]] : $option_value_row[$reg_option_id];
                    $flag = $User_OptionModel -> addOption($user_option_row);
                    array_push($rs_row, $flag);
                }
            }
        }
        if (is_ok($rs_row) && $User_InfoDetail ->sql-> commit()) {
            $d = array();
            $d['user_id'] = $user_id;
            $encrypt_str = Perm::encryptUserInfo($d, $session_id);

            //二维码
            $qrurl = Yf_Registry::get('ucenter_api_url')."index.php?ctl=Login&act=regidimg&MemberID=".$memberid."&user_name=".$user_name;
            $arr_body = array(
                "user_name" => $user_name,
                "server_id" => $server_id,
                "k" => $encrypt_str,
                "user_id" => $user_id,
                'MemberID'=>$memberid,
                'par_member'=>$result[0]['ParentMemberID'],
                'qrurl' => $qrurl
            );
            if ($token) {
                //查找bind绑定表
                $User_BindConnectModel = new User_BindConnectModel();
                $bind_info = $User_BindConnectModel -> getBindConnectByToken($token);
                $bind_info = $bind_info[0];
                //获取qq缩略头像
                $qq_logo = substr($bind_info['bind_avator'], 0, strrpos($bind_info['bind_avator'], '/'));
                $qq_logo = $qq_logo . '/40';
                //更新用户详情表
                if ($bind_info['bind_gender'] == 1) {
                    $gender = 1;
                } else {
                    $gender = 0;
                }
                $user_info_detail = array(
                    'nickname' => $bind_info['bind_nickname'],
                    'user_avatar' => $bind_info['bind_avator'],
                    'user_gender' => $gender,
                    'user_avatar_thumb' => $qq_logo,
                );
                $User_InfoDetail -> editInfoDetail($user_name, $user_info_detail);
                $time = date('Y-m-d H:i:s', time());
                //插入绑定表
                $bind_array = array(
                    'user_id' => $user_id,
                    'bind_time' => $time,
                    'bind_token' => $token,
                    );
                    $User_BindConnectModel -> editBindConnect($bind_info['bind_id'], $bind_array);
                }
                return $this->data->addBody(100, $arr_body);
            } else {
                $User_InfoDetail ->sql-> rollBack();
                $this ->data-> setError('创建用户信息失败');
            }
    }

	

}