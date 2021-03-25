<?php
header("Access-Control-Allow-Credentials: true");
$origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';
header("Access-Control-Allow-Origin:$origin");

class LoginCtl extends Yf_AppController
{
    public function callback()
    {
        echo 'callback 地址';
    }

    public function select()
    {
        $web['site_logo'] = Web_ConfigModel ::value("site_logo");//首页logo
        $BaseAppModel = new BaseApp_BaseAppModel();
        $shop_row = $BaseAppModel -> getOne('102');
        $shop_url = '';
        if ($shop_row) {
            $shop_url = $shop_row['app_url'];
        }
        $type = request_int('type');
        $re_url = Yf_Registry::get('re_url');
        $from = $_REQUEST['callback'];
        $callback = $from ? $from : $re_url;
        //根据token获取用户信息
        $token = request_string('t');
        $User_BindConnectModel = new User_BindConnectModel();
        $user_info = $User_BindConnectModel -> getBindConnectByToken($token);
        $user_info = current($user_info);
        fb($user_info);
        //查找注册的设置
        $Web_ConfigModel = new Web_ConfigModel();
        $reg_row = $Web_ConfigModel -> getByWhere(array('config_type' => 'register'));
        $pwd_str = '';
        //判断是否开启了用户密码必须包含数字
        if ($reg_row['reg_number']['config_value']) {
            $pwd_str .= "'数字'";
        }
        //判断是否开启了用户密码必须包含小写字母
        if ($reg_row['reg_lowercase']['config_value']) {
            $pwd_str .= "'小写字母'";
        }
        //判断是否开启了用户密码必须包含大写字母
        if ($reg_row['reg_uppercase']['config_value']) {
            $pwd_str .= "'大写字母'";
        }
        //判断是否开启了用户密码必须包含符号
        if ($reg_row['reg_symbols']['config_value']) {
            $pwd_str .= "'符号'";
        }
        if ($pwd_str) {
            $pwd_str = '密码中必须包含：' . $pwd_str;
        }
        if ($pwd_str) {
            $pwd_str .= '，';
        }
        $pwd_str .= $reg_row['reg_pwdlength']['config_value'] . '-16个字符。';

        include $this -> view -> getView();
    }

    //第三方注册
    public function bindRegist()
    {
        $token = request_string('token');
        $user_code = request_string('code');
        $mobile = request_string('mobile');
        $password = request_string('password');
        $server_id = 0;
        if (!$user_code) {
            $this -> data -> setError('请输入验证码');
            return false;
        }
        if (!$mobile) {
            $this -> data -> setError('请输入手机号');
            return false;
        }
        if (!$password) {
            $this -> data -> setError('请输入密码');
            return false;
        }
        $config_cache = Yf_Registry ::get('config_cache');
        $Cache_Lite = new Cache_Lite_Output($config_cache['verify_code']);
        $user_code_pre = $Cache_Lite -> get($mobile);
        if ($user_code != $user_code_pre) {
            if (DEBUG !== true) {
                $user_code_pre = "";
            }
            $this -> data -> setError('验证码错误');
            return false;
        }
        $rs_row = array();
        //根据token从绑定表中查找用户信息
        $User_BindConnectModel = new User_BindConnectModel();
        //开启事务
        $User_BindConnectModel -> sql -> startTransaction();
        $bind_info = $User_BindConnectModel -> getBindConnectByToken($token);
        $bind_info = current($bind_info);
        if (!$bind_info) {
            $this -> data -> setError('绑定账号不存在');
            return false;
        }
        //判断绑定账户是否已经绑定过用户，已经绑定过用户的账号，不可重复绑定
        if ($bind_info['user_id']) {
            $this -> data -> setError('该账号已经绑定用户!');
            return false;
        }
        //判断该账号名是否已经存在
        $User_InfoModel = new User_InfoModel();
        $User_InfoDetail = new User_InfoDetailModel();
        $user_rows = $User_InfoModel -> getInfoByName($bind_info['bind_nickname']);
        //如果用户名已经存在了，则在用户名后面添加随机数
        if ($user_rows) {
            $bind_info['bind_nickname'] = $bind_info['bind_nickname'] . rand(0000, 9999);
        }
        //在user_info中插入用户信息
        $Db = Yf_Db::get('ucenter');
        $seq_name = 'user_id';
        $user_id = $Db -> nextId($seq_name);
        $now_time = time();
        $ip = get_ip();
        $session_id = uniqid();
        $arr_field_user_info = array();
        $arr_field_user_info['user_id'] = $user_id;
        $arr_field_user_info['user_name'] = $bind_info['bind_nickname'];
        $arr_field_user_info['password'] = md5($password);
        $arr_field_user_info['action_time'] = $now_time;
        $arr_field_user_info['action_ip'] = $ip;
        $arr_field_user_info['session_id'] = $session_id;
        $user_info_add_flag = $User_InfoModel -> addInfo($arr_field_user_info);
        check_rs($user_info_add_flag, $rs_row);
        //在绑定表中插入用户id
        $bind_user_row = array();
        $time = date('Y-m-d H:i:s', time());
        $bind_user_row['user_id'] = $user_id;
        $bind_user_row['bind_time'] = $time;
        $bind_user_row['bind_token'] = $token;
        $bind_edit_flag = $User_BindConnectModel -> editBindConnect($bind_info['bind_id'], $bind_user_row);
        check_rs($bind_edit_flag, $rs_row);
        //在user_info_detail表中插入用户信息
        $arr_field_user_info_detail = array();
        if ($bind_info['bind_gender'] == 1) {
            $gender = 1;
        } else {
            $gender = 0;
        }
        $qq_logo = substr($bind_info['bind_avator'], 0, strrpos($bind_info['bind_avator'], '/'));
        $qq_logo = $qq_logo . '/40';
        //添加mobile绑定.
        //绑定标记：mobile/email/openid  绑定类型+openid
        $bind__mobile_id = sprintf('mobile_%s', $mobile);
        //查找bind绑定表
        $User_BindConnectModel = new User_BindConnectModel();
        $bind_mobile_info = $User_BindConnectModel -> getOne($bind__mobile_id);
        if (!$bind_mobile_info) {
            $time = date('Y-m-d H:i:s', time());
            //插入绑定表
            $bind_array = array(
                'bind_id' => $bind__mobile_id,
                'user_id' => $user_id,
                'bind_type' => $User_BindConnectModel ::MOBILE,
                'bind_time' => $time
            );
            $flag = $User_BindConnectModel -> addBindConnect($bind_array);
            check_rs($flag, $rs_row);
            array_push($rs_row, $flag);
            //绑定关系
            $arr_field_user_info_detail['user_mobile_verify'] = 1;
        } else {
            //针对之前的历史数据处理。之前已经解绑的手机号在bind_connect表中还是存在，给之后用该手机号绑定用户造成了困扰
            $time = date('Y-m-d H:i:s', time());
            //插入绑定表
            $bind_array = array(
                'user_id' => $user_id,
                'bind_type' => $User_BindConnectModel::MOBILE,
                'bind_time' => $time
            );
            $flag = $User_BindConnectModel -> editBindConnect($bind__mobile_id, $bind_array);
            check_rs($flag, $rs_row);
            array_push($rs_row, $flag);
            //绑定关系
            $arr_field_user_info_detail['user_mobile_verify'] = 1;
        }
        $arr_field_user_info_detail['user_name'] = $bind_info['bind_nickname'];
        $arr_field_user_info_detail['user_mobile'] = $mobile;
        $arr_field_user_info_detail['nickname'] = $bind_info['bind_nickname'];
        $arr_field_user_info_detail['user_avatar'] = $bind_info['bind_avator'];
        $arr_field_user_info_detail['user_avatar_thumb'] = $qq_logo;
        $arr_field_user_info_detail['user_gender'] = $gender;
        $arr_field_user_info_detail['user_reg_time'] = $now_time;
        $arr_field_user_info_detail['user_count_login'] = 1;
        $arr_field_user_info_detail['user_lastlogin_time'] = $now_time;
        $arr_field_user_info_detail['user_lastlogin_ip'] = $ip;
        $arr_field_user_info_detail['user_reg_ip'] = $ip;
        $user_detail_add_flag = $User_InfoDetail -> addInfoDetail($arr_field_user_info_detail);
        check_rs($user_detail_add_flag, $rs_row);
        if (is_ok($rs_row) && $User_BindConnectModel -> sql -> commit()) {
            $d = array();
            $d['user_id'] = $user_id;
            $encrypt_str = Perm::encryptUserInfo($d, $session_id);
            $arr_body = array(
                "user_name" => $bind_info['bind_nickname'],
                "server_id" => $server_id,
                "k" => $encrypt_str,
                "session_id" => $session_id,
                "user_id" => $user_id
            );
            $this -> data -> addBody(100, $arr_body);
        } else {
            $User_BindConnectModel -> sql -> rollBack();
            $this -> data -> setError('创建用户信息失败');
        }
    }

    //第三方关联登录
    public function bindLogin()
    {
        $token = request_string('token');
        $type = request_int('type');
        $user_name = strtolower(request_string('user_account'));
        $password = request_string('user_password');
        $User_BindConnectModel = new User_BindConnectModel();
        $rs_row = array();
        //开启事务
        $User_BindConnectModel -> sql -> startTransaction();
        $bind_info = $User_BindConnectModel -> getBindConnectByToken($token);
        $bind_info = current($bind_info);
        //判断绑定账户是否已经绑定过用户，已经绑定过用户的账号，不可重复绑定
        if ($bind_info['user_id']) {
            $this -> data -> setError('该账号已经绑定用户!');
            return false;
        }
        if (!strlen($user_name)) {
            $this -> data -> setError('请输入账号');
            return false;
        }
        if (!strlen($password)) {
            $this -> data -> setError('请输入密码');
            return false;
        }
        $User_InfoModel = new User_InfoModel();
        $User_InfoDetail = new User_InfoDetailModel();
        //判断传过来的用户名是否是手机号，如果是手机号就查找该手机号的用户，如果不是则直接用用户名查找手机号
        if (Yf_Utils_String ::isMobile($user_name)) {
            $user_name = $User_InfoDetail -> getUserByMobile($user_name);
            if (!$user_name) {
                $this -> data -> setError('账号不存在');
                return false;
            }
        }
        $user_info_row = $User_InfoModel -> getInfoByName($user_name);
        if (!$user_info_row) {
            $this -> data -> setError('账号不存在');
            return false;
        }
        $pswd = md5($password);
        if ($pswd != $user_info_row['password']) {
            $this -> data -> setError('密码错误');
            return false;
        }
        if (3 == $user_info_row['user_state']) {
            $this -> data -> setError('用户已经锁定,禁止登录!');
            return false;
        }
        //添加修改过的
        if ($user_info_row['MemberStatus'] == 'C') {
            $this ->data-> setError('无法登陆,您的会员已过期');
            return false;
        }elseif ($user_info_row['MemberStatus'] == 'D') {
            $this ->data-> setError('无法登陆,您的会员已冻结');
            return false;
        }elseif ($user_info_row['MemberStatus'] == 'F') {
            $this ->data-> setError('无法登陆,您的会员已严重取消');
            return false;
        }elseif ($user_info_row['MemberStatus'] == 'Q') {
            $this ->data-> setError('无法登陆,您的会员已取消');
            return false;
        }elseif($user_info_row['MemberStatus'] == 'S'){
            $this ->data-> setError('无法登陆,您的会员已移转');
            return false;
        }

        //查找该用户是否已经绑定过其他用户
        $bind_id_row = $User_BindConnectModel -> getBindConnectByuserid($user_info_row['user_id'], $type);
        if ($bind_id_row) {
            $this -> data -> setError('账号已绑定');
            return false;
        }
        $info_row = $User_InfoDetail -> getOne($user_name);
        if (!$info_row['user_mobile']) {
            $this -> data -> setError('该账号未绑定手机号！');
            return false;
        }
        $session_id = $user_info_row['session_id'];
        $arr_body = $user_info_row;
        $arr_body['result'] = 1;
        $data = array();
        $data['user_id'] = $user_info_row['user_id'];
        $arr_body['user_id'] = $user_info_row['user_id'];
        $encrypt_str = Perm ::encryptUserInfo($data, $session_id);
        $arr_body['k'] = $encrypt_str;
        //插入绑定表
        $time = date('Y-m-d H:i:s', time());
        $User_BindConnectModel = new User_BindConnectModel();
        $bind_array = array(
            'user_id' => $user_info_row['user_id'],
            'bind_time' => $time,
            'bind_token' => $token,
        );
        $user_bind_flag = $User_BindConnectModel -> editBindConnect($bind_info['bind_id'], $bind_array);
        check_rs($rs_row, $user_bind_flag);
        $arr_field_user_info_detail['user_count_login'] = $info_row['user_count_login'] + 1;
        $arr_field_user_info_detail['user_lastlogin_time'] = time();
        $user_detail_flag = $User_InfoDetail -> editInfoDetail($user_name, $arr_field_user_info_detail);
        check_rs($rs_row, $user_detail_flag);
        if (is_ok($rs_row) && $User_BindConnectModel -> sql -> commit()) {
            $this -> data -> addBody(100, $arr_body);
        } else {
            $User_BindConnectModel -> sql -> rollBack();
            $this -> data -> setError('关联用户失败');
        }
    }

    public function index()
    {
        $web['site_logo'] = Web_ConfigModel::value("site_logo");//首页logo
        $BaseAppModel = new BaseApp_BaseAppModel();
        $shop_row = $BaseAppModel -> getOne('102');
        $shop_url = '';
        if ($shop_row) {
            $shop_url = $shop_row['app_url'];
        }

        $act = request_string('act');
        //如果已经登录,则直接跳转
        if (Perm::checkUserPerm()) {
            $data = Perm::$row;
            //查找用户是否绑定了手机号。如果没有绑定的手机号就退出
            $User_InfoDetailModel = new User_InfoDetailModel();
            $user_info = $User_InfoDetailModel -> getInfoDetail($data['user_name']);
            $user_info = current($user_info);
            if (!$user_info['user_mobile']) {
                $this -> loginout();
            }
            $k = $_COOKIE[Perm::$cookieName];
            $u = $_COOKIE[Perm::$cookieId];
            if (isset($_REQUEST['callback']) && $_REQUEST['callback']) {
                $url = $_REQUEST['callback'] . '&us=' . $u . '&ks=' . urlencode($k);
            } else {
                $url = './index.php';
            }
            header('location:' . $url);
        } else {
            //查找注册的设置
            $Web_ConfigModel = new Web_ConfigModel();
            $reg_row = $Web_ConfigModel -> getByWhere(array('config_type' => 'register'));
            if (!isset($reg_row['reg_checkcode']) || !$reg_row['reg_checkcode']) {
                //config_value = 1手机，2邮箱，默认手机验证
                $reg_row['reg_checkcode'] = array(
                    'config_key' => 'reg_checkcode',
                    'config_value' => 1,
                    'config_type' => 'register',
                    'config_enable' => 1,
                    'config_comment' => '',
                    'config_datatype' => 'number'
                );
            }
            $pwd_str = '';
            if ($reg_row['reg_checkcode']['config_value'] == 2) {
                $email_display = 'display';
                $mobile_display = 'none';
                $both_display = 'none';
            } elseif ($reg_row['reg_checkcode']['config_value'] == 3) {
                $email_display = 'none';
                $mobile_display = 'display';
                $both_display = 'display';
            } else {
                $email_display = 'none';
                $mobile_display = 'display';
                $both_display = 'none';
            }
            //判断是否开启了用户密码必须包含数字
            if ($reg_row['reg_number']['config_value']) {
                $pwd_str .= "'数字'";
            }
            //判断是否开启了用户密码必须包含小写字母
            if ($reg_row['reg_lowercase']['config_value']) {
                $pwd_str .= "'小写字母'";
            }
            //判断是否开启了用户密码必须包含大写字母
            if ($reg_row['reg_uppercase']['config_value']) {
                $pwd_str .= "'大写字母'";
            }
            //判断是否开启了用户密码必须包含符号
            if ($reg_row['reg_symbols']['config_value']) {
                $pwd_str .= "'符号'";
            }
            //密码规则提示
            $pwd_icon = $pwd_str . '组合,' . $reg_row['reg_pwdlength']['config_value'] . '-16个字符';
            if ($pwd_str) {
                $pwd_str = '密码中必须包含：' . $pwd_str;
            }
            if ($pwd_str) {
                $pwd_str .= '，';
            }
            $pwd_str .= $reg_row['reg_pwdlength']['config_value'] . '-16个字符。';
            if ($act == 'reset') {
                $this ->view-> setMet('resetpwd');
            }
            if ($act == 'reg') {
                $Reg_OptionModel = new Reg_OptionModel();
                $reg_opt_rows = $Reg_OptionModel -> getByWhere(array('reg_option_active' => 1));
                $this ->view-> setMet('regist');
            }
            //上传身份证照片
            if ($act == 'regidimg') {
                $this ->view-> setMet('regidimg');
            }
            //找回会员编号
            if ($act == 'findmebid') {
                $this ->view-> setMet('findmebid');
            }
            //老会员首次登录激活
            if ($act == 'activat') {
                $Reg_OptionModel = new Reg_OptionModel();
                $reg_opt_rows = $Reg_OptionModel -> getByWhere(array('reg_option_active' => 1));
                $this ->view-> setMet('activat');
            }
            include $this ->view-> getView();
        }
    }

    public function regist()
    {
        //如果已经登录,则直接跳转
        if (Perm::checkUserPerm()) {
            $data = Perm::$row;
            $k = $_COOKIE[Perm::$cookieName];
            $u = $_COOKIE[Perm::$cookieId];
            if (isset($_REQUEST['callback'])) {
                $url = $_REQUEST['callback'] . '&us=' . $u . '&ks=' . urlencode($k);
            } else {
                $url = './index.php';
            }
            header('location:' . $url);
        } else {
            if (isset($_REQUEST['callback'])) {
                $url = './index.php?ctl=Login&act=regidimg&callback=' . urlencode($_REQUEST['callback']);
            } else {
                $url = './index.php?ctl=Login&act=regidimg';
            }
            header('location:' . $url);
        }
    }

    public function findpwd()
    {
        $url = './index.php?ctl=Login&act=reset';
        header('location:' . $url);
    }

    public function getPhonCode()
    {
        $mobile = request_string('mobile');
        $check_code = mt_rand(100000, 999999);
        if ($mobile && Yf_Utils_String ::isMobile($mobile)) {
            $save_result = $this -> _saveCodeCache($mobile, $check_code, 'verify_code');
            if (!$save_result) {
                $msg = _('发送失败');
                $status = 250;
            } else {
                //发送短消息
                $message_model = new Message_TemplateModel();
                $pattern = array('/\[weburl_name\]/', '/\[yzm\]/');
                $replacement = array(Web_ConfigModel ::value("site_name"), $check_code);
                $message_info = $message_model -> getTemplateInfo(array('code' => 'regist_verify'), $pattern, $replacement);
                if (!$message_info['is_phone']) {
                    $this -> data -> addBody(-140, array(), _('信息内容创建失败'), 250);
                }
                $contents = $message_info['content_phone'];
                $result = Sms ::send($mobile, $contents);
                if ($result) {
                    $msg = _('发送成功');
                    $status = 200;
                } else {
                    $msg = _('发送失败');
                    $status = 250;
                }
            }
        } else {
            $msg = __('发送失败');
            $status = 250;
        }
        $data = array();
        if (DEBUG === false) {
            $data['user_code'] = $check_code;
        }
        return $this -> data -> addBody(-140, $data, $msg, $status);
    }
    //新会员注册流程，会员姓名进行检索  http://127.0.0.1/bbc_tjsh/ucenter/index.php?ctl=Login&met=checkName&typ=&user_name=%E6%80%AA%E8%9C%80%E9%BB%8D5
    public function checkName()
    {
        $User_InfoModel = new User_InfoModel();
        $User_InfoDetail = new User_InfoDetailModel();

        $user_name = request_string('user_name');

        if ($user_name) {
            //查询用户名

            // $user_info_row  = $User_InfoModel->getInfoByName($user_name);
            $user_info_row = $User_InfoDetail->getOneByWhere(array('user_name'=>$user_name));
            if ($user_info_row) {

                $msg = __('失败');
                $status = 250;
            } else {
                $msg = _('成功');
                $status = 200;
            }
        }
        $data['items'] = $user_info_row;

        return $this -> data -> addBody(-140, $data, $msg, $status);
    }
    //新会员注册流程,验证手机号和短信验证码是否一致 http://127.0.0.1/bbc_tjsh/ucenter/index.php?ctl=Login&met=phoneCode&typ=&user_code=123456&user_mobile=15214338749
    public function phoneCode()
    {
        $User_InfoModel = new User_InfoModel();
        $User_InfoDetail = new User_InfoDetailModel();

        $user_code   = request_string('user_code');
        $user_mobile = request_string('user_mobile');
        if (!$user_code) {
            $this ->data-> setError('验证码不能为空');
            return false;
        }
        if (!$user_mobile) {
            $this ->data-> setError('手机号不能空');
            return false;
        }
        $zhizhang = false;
        $verify_check = Perm::checkAppYzm($user_code, $user_mobile,$zhizhang);

        if ($verify_check) {

            $msg = _('成功');
            $status = 200;

        }else{
            $msg = __('失败');
            $status = 250;
        }

        $data = array();

        return $this -> data -> addBody(-140, $data, $msg, $status);
    }
    /*
     * 小程序短信验证码获取
     * */
    public function wxappregCode()
    {
        $mobile = request_string('mobile');
        $check_code = mt_rand(100000, 999999);
        if ($mobile && Yf_Utils_String ::isMobile($mobile)) {
            //判断手机号是否已经注册过
            $User_InfoDetail = new User_InfoDetailModel();
            $checkmobile = $User_InfoDetail -> checkMobile($mobile);
            if ($checkmobile) {
                $msg = _('该手机号已注册');
                $status = 250;
            } else {
                $save_result = $this -> _saveCodeCache($mobile, $check_code, 'verify_code');
                if (!$save_result) {
                    $msg = _('发送失败');
                    $status = 250;
                } else {
                    //发送短消息
                    $message_model = new Message_TemplateModel();
                    $pattern = array('/\[weburl_name\]/', '/\[yzm\]/');
                    $replacement = array(Web_ConfigModel ::value("site_name"), $check_code);
                    $message_info = $message_model -> getTemplateInfo(array('code' => 'regist_verify'), $pattern, $replacement);
                    if (!$message_info['is_phone']) {
                        $this -> data -> addBody(-140, array(), _('信息内容创建失败'), 250);
                    }
                    $contents = $message_info['content_phone'];
                    $result = Sms ::send($mobile, $contents);
                    if ($result) {
                        $msg = _('发送成功');
                        $status = 200;
                    } else {
                        $msg = _('发送失败');
                        $status = 250;
                    }
                }
            }
        } else {
            $msg = __('发送失败');
            $status = 250;
        }
        $data = array();
        if (DEBUG === false) {
            $data['user_code'] = $check_code;
        }
        return $this -> data -> addBody(-140, $data, $msg, $status);
    }
    /**
     * 新会员注册-手机获取注册码
     *
     * @access public
     */
    public function reg1Code()
    {
        $mobile = request_string('mobile');

        $check_code = mt_rand(100000, 999999);
        if ($mobile && Yf_Utils_String::isMobile($mobile)) {
            //判断手机号是否已经注册过
            $User_InfoDetail = new User_InfoDetailModel();
            $checkmobile = $User_InfoDetail -> checkMobile($mobile);
            $arr = array();
            $arr['Source'] = 11;
            $arr['MobileNo'] = $mobile;
            $result = current(json_decode(WeimengApi::api('B2C_CheckMobile',$arr),true));
            if ($checkmobile||$result['ResultCode']==1803) {
                $msg = _('该手机号已注册');
                $status = 250;
            } else {
                $save_result = $this -> _saveCodeCache($mobile, $check_code, 'verify_code');
                if (!$save_result) {
                    $msg = _('发送失败');
                    $status = 250;
                } else {
                    //发送短消息
                    $message_model = new Message_TemplateModel();
                    $pattern = array('/\[weburl_name\]/', '/\[yzm\]/');
                    $replacement = array(Web_ConfigModel::value("site_name"), $check_code);
                    $message_info = $message_model -> getTemplateInfo(array('code' => 'regist_verify'), $pattern, $replacement);
                    if (!$message_info['is_phone']) {
                        $this -> data -> addBody(-140, array(), _('信息内容创建失败'), 250);
                    }
                    $contents = $message_info['content_phone'];
                    $result = Sms ::send($mobile, $contents);
                    // var_dump($result);die;
                    if ($result) {
                        $msg = _('发送成功');
                        $status = 200;
                    } else {
                        $msg = _('发送失败');
                        $status = 250;
                    }
                }
            }
        } else {
            $msg = __('发送失败');
            $status = 250;
        }
        $data = array();
        if (DEBUG === false) {
            $data['user_code'] = $check_code;
        }
        return $this->data->addBody(-140, $data, $msg, $status);
    }
    /**
     * 新会员注册-手机获取注册码
     *
     * @access public
     */
    public function reg2Code()
    {
        $mobile = request_string('mobile');

        $check_code = mt_rand(100000, 999999);
        if ($mobile && Yf_Utils_String::isMobile($mobile)) {
            //判断手机号是否已经注册过
            $User_InfoDetail = new User_InfoDetailModel();
            $checkmobile = $User_InfoDetail -> checkMobile($mobile);
            $save_result = $this -> _saveCodeCache($mobile, $check_code, 'verify_code');
            if (!$save_result) {
                $msg = _('发送失败');
                $status = 250;
            } else {
                //发送短消息
                $message_model = new Message_TemplateModel();
                $pattern = array('/\[weburl_name\]/', '/\[yzm\]/');
                $replacement = array(Web_ConfigModel::value("site_name"), $check_code);
                $message_info = $message_model -> getTemplateInfo(array('code' => 'regist_verify'), $pattern, $replacement);
                if (!$message_info['is_phone']) {
                    $this -> data -> addBody(-140, array(), _('信息内容创建失败'), 250);
                }
                $contents = $message_info['content_phone'];
                $result = Sms ::send($mobile, $contents);
                // var_dump($result);die;
                if ($result) {
                    $msg = _('发送成功');
                    $status = 200;
                } else {
                    $msg = _('发送失败');
                    $status = 250;
                }
            }

        } else {
            $msg = __('发送失败');
            $status = 250;
        }
        $data = array();
        if (DEBUG === false) {
            $data['user_code'] = $check_code;
        }
        return $this->data->addBody(-140, $data, $msg, $status);
    }
    /**
     * 手机获取注册码
     *
     * @access public
     */
    public function regCode()
    {
        $mobile = request_string('mobile');
        $email = request_string('email');
        $yzm = request_string('yzm');
        if (!Perm ::checkYzm($yzm)) {
            return $this -> data -> addBody(-140, array(), _('图形验证码有误'), 230);
        }
        $check_code = mt_rand(100000, 999999);
        if ($mobile && Yf_Utils_String ::isMobile($mobile)) {
            //判断手机号是否已经注册过
            $User_InfoDetail = new User_InfoDetailModel();
            $checkmobile = $User_InfoDetail -> checkMobile($mobile);
            if ($checkmobile) {
                $msg = _('该手机号已注册');
                $status = 250;
            } else {
                $save_result = $this -> _saveCodeCache($mobile, $check_code, 'verify_code');
                if (!$save_result) {
                    $msg = _('发送失败');
                    $status = 250;
                } else {
                    //发送短消息
                    $message_model = new Message_TemplateModel();
                    $pattern = array('/\[weburl_name\]/', '/\[yzm\]/');
                    $replacement = array(Web_ConfigModel ::value("site_name"), $check_code);
                    $message_info = $message_model -> getTemplateInfo(array('code' => 'regist_verify'), $pattern, $replacement);
                    if (!$message_info['is_phone']) {
                        $this -> data -> addBody(-140, array(), _('信息内容创建失败'), 250);
                    }
                    $contents = $message_info['content_phone'];
                    $result = Sms ::send($mobile, $contents);
                    if ($result) {
                        $msg = _('发送成功');
                        $status = 200;
                    } else {
                        $msg = _('发送失败');
                        $status = 250;
                    }
                }
            }
        } elseif ($email && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            //判断邮箱是否已经注册过
            $User_InfoDetail = new User_InfoDetailModel();
            $checkemail = $User_InfoDetail -> checkEmail($email);
            if ($checkemail) {
                $msg = _('该邮箱已注册');
                $status = 250;
            } else {
                $save_result = $this -> _saveCodeCache($email, $check_code, 'verify_code');
                if (!$save_result) {
                    $msg = _('验证码获取失败');
                    $status = 250;
                } else {
                    //发送邮件
                    $message_model = new Message_TemplateModel();
                    $pattern = array('/\[weburl_name\]/', '/\[yzm\]/');
                    $replacement = array(Web_ConfigModel ::value("site_name"), $message_info);
                    $message_info = $message_model -> getTemplateInfo(array('code' => 'regist_verify'), $pattern, $replacement);
                    if (!$message_info['is_email']) {
                        $this -> data -> addBody(-140, array(), __('信息内容创建失败'), 250);
                    }
                    $title = '注册验证';
                    $contents = $message_info['content_email'];
                    $result = Email::send($email, '', $title, $contents);
                    if ($result) {
                        $msg = _('发送成功');
                        $status = 200;
                    } else {
                        $msg = _('发送失败');
                        $status = 250;
                    }
                }
            }
        } else {
            $msg = __('发送失败');
            $status = 250;
        }
        $data = array();
        if (DEBUG === false) {
            $data['user_code'] = $check_code;
        }
        return $this -> data -> addBody(-140, $data, $msg, $status);
    }

    /**
     * 手机获取找回密码验证码
     *
     * @access public
     */
    public function findPasswdCode()
    {
        $mobile = request_string('mobile');
        $email = request_string('email');
        // $yzm = request_string('yzm');
        // if (!Perm ::checkYzm($yzm)) {
        //     return $this -> data -> addBody(-140, array(), _('图形验证码有误'), 230);
        // }
        $data = array();
        //验证手机号是否是用户手机号
        $User_InfoDetail = new User_InfoDetailModel();
        $checkMobile = $User_InfoDetail -> isUserMobile($mobile);
        if (!$checkMobile) {
            $this -> data -> setError('请填写注册或绑定的手机号');
            return false;
        }
        //判断用户是否存在  $mobile
        $pattern_email = '/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/';
        $check_code = mt_rand(100000, 999999);
        if ($mobile && Yf_Utils_String ::isMobile($mobile)) {
            //缓存数据
            $save_result = $this -> _saveCodeCache($mobile, $check_code, 'verify_code');
            if (!$save_result) {
                $msg = '发送失败';
                $status = 250;
            } else {
                //发送短消息
                $contents = '【尚赫国际】您的验证码是：' . $check_code . '。请不要把验证码泄露给其他人。如非本人操作，可不用理会！';
                $result = Sms ::send($mobile, $contents);
                if ($result) {
                    $msg = '发送成功';
                    $status = 200;
                } else {
                    $msg = '发送失败';
                    $status = 250;
                }
            }
        } elseif (preg_match($pattern_email, $email)) {
            //缓存数据
            $save_result = $this -> _saveCodeCache($email, $check_code, 'verify_code');
            if (!$save_result) {
                $msg = '发送失败';
                $status = 250;
            } else {
                //发送短消息
                $contents = '【尚赫国际】您的验证码是：' . $check_code . '。请不要把验证码泄露给其他人。如非本人操作，可不用理会！';
                $result = Email::send($email, '', '找回密码验证码', $contents);
                if ($result) {
                    $msg = '发送成功';
                    $status = 200;
                } else {
                    $msg = '发送失败';
                    $status = 250;
                }
            }
        } else {
            $msg = '用户账号不存在';
            $status = 250;
        }
        if (DEBUG === false) {
            $data['user_code'] = $check_code;
        }
        $this -> data -> addBody(-140, $data, $msg, $status);
    }

    public function resetPasswd()
    {
//      $img_code = request_string('imgCode');
//        session_start();
//        if (strtolower($img_code) != strtolower($_SESSION['auth'])) {
//            return $this->data->addBody(-140, [], '验证码错误', 210);
//        }

        $user_code = request_string('user_code');
        $from = request_string('from');
        $data = array();
        $data['mobile'] = request_string('mobile');
        $data['email'] = request_string('email');
        $data['password'] = md5(request_string('user_password'));
        $data['passworderp'] = request_string('user_password');
        $reg_checkcode = request_string('reg_checkcode', '1');
        //为erp做的修改密码
        if ($from == 'erp' || $from == 'chain') {
            $data['user'] = request_string('user_account');
            $User_InfoModel = new User_InfoModel();
            //检测登录状态
            $user_id_row = $User_InfoModel -> getInfoByName($data['user']);
            if ($user_id_row) {
                //重置密码
                $user_id = $user_id_row['user_id'];
                $reset_passwd_row = array();
                $reset_passwd_row['password'] = $from == 'erp' ? $data['passworderp'] : $data['password'];
                $flag = $User_InfoModel -> editInfo($user_id, $reset_passwd_row);
                if ($flag !== false) {
                    $msg = '重置密码成功';
                    $status = 200;
                } else {
                    $msg = '重置密码失败';
                    $status = 250;
                }
            } else {
                $msg = '用户不存在';
                $status = 250;
            }
            unset($data['password']);
        } else {
            if ($user_code) {
                if ($reg_checkcode == 1 || $reg_checkcode == 3) {
                    if (!$data['mobile']) {
                        $this -> data -> setError('手机号不能为空');
                        return false;
                    }
                } else {
                    if (!$data['email']) {
                        $this -> data -> setError('邮箱不能为空');
                        return false;
                    }
                }
                if (request_string('user_password')) {
                    $config_cache = Yf_Registry ::get('config_cache');
                    $Cache_Lite = new Cache_Lite_Output($config_cache['verify_code']);
                    if ($reg_checkcode == 2) {
                        $user_code_pre = $Cache_Lite -> get($data['email']);
                    } else {
                        $user_code_pre = $Cache_Lite -> get($data['mobile']);
                    }
                    //$user_code_pre = $reg_checkcode == 1 ? $Cache_Lite->get($data['mobile']) : $Cache_Lite->get($data['email']);
                    if ($user_code == $user_code_pre) {
                        $User_InfoModel = new User_InfoModel();
                        $User_InfoDetailModel = new User_InfoDetailModel();
                        //检测登录状态
                        if ($reg_checkcode == 2) {
                            $data['user'] = $User_InfoDetailModel -> getUserByEmail($data['email']);
                        } else {
                            $data['user'] = $User_InfoDetailModel -> getUserByMobile($data['mobile']);
                        }
                        //$data['user'] = $reg_checkcode == 1 ? $User_InfoDetailModel->getUserByMobile($data['mobile']) : $User_InfoDetailModel->getUserByEmail($data['email']);
                        $user_id_row = $User_InfoModel -> getInfoByName($data['user']);
                        if ($user_id_row) {
                            //重置密码
                            $user_id = $user_id_row['user_id'];
                            $reset_passwd_row = array();
                            $reset_passwd_row['password'] = $data['password'];
                            $flag = $User_InfoModel -> editInfo($user_id, $reset_passwd_row);
                            if ($flag === 'false') {
                                $msg = '网路故障，请稍后重试';
                                $status = 250;
                            } else {
                                $msg = '重置密码成功';
                                $status = 200;
                                //使验证码失效
                                if ($reg_checkcode == 2) {
                                    $reg_checkcode == $Cache_Lite -> remove($data['email']);
                                } else {
                                    $reg_checkcode == $Cache_Lite -> remove($data['mobile']);
                                }
                                //$reg_checkcode == 1 ? $Cache_Lite->remove($data['mobile']) : $Cache_Lite->remove($data['email']);
                            }
                        } else {
                            $msg = '用户不存在';
                            $status = 250;
                        }
                    } else {
                        $msg = '验证码错误' . $Cache_Lite -> get($data['email']);
                        $status = 250;
                    }
                } else {
                    $msg = '密码不能为空';
                    $status = 250;
                }
            } else {
                $msg = '手机或验证码不能为空';
                $status = 250;
            }
            unset($data['password']);
        }
        $this -> data -> addBody(-140, array(), $msg, $status);
    }
    function request_token($url = '', $param = '') {
        if (empty($url) || empty($param)) {
            return false;
        }

        $postUrl = $url;
        $curlPost = $param;
        $curl = curl_init();//初始化curl
        curl_setopt($curl, CURLOPT_URL,$postUrl);//抓取指定网页
        curl_setopt($curl, CURLOPT_HEADER, 0);//设置header
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($curl, CURLOPT_POST, 1);//post提交方式
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);

        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false); //重新定义
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,false);  //重新定义

        $data = curl_exec($curl);//运行curl
        curl_close($curl);

        return $data;
    }
    /**
     * 发起http post请求(REST API), 并获取REST请求的结果
     * @param string $url
     * @param string $param
     * @return - http response body if succeeds, else false.
     */
    function request_post($url = '', $param = '')
    {
        if (empty($url) || empty($param)) {
            return false;
        }

        $postUrl = $url;
        $curlPost = $param;

        // 初始化curl
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $postUrl);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        // 要求结果为字符串且输出到屏幕上
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        // post提交方式
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);

        // 运行curl
        $data = curl_exec($curl);

        curl_close($curl);

        return $data;
    }
    /** B2C
     * @Interface 具体接口名称
     * @aparam 传输的数据
     * @headers 开启权限管控或自定义请求头
     * @key暂时用不到
     * @新KEY：w7IGvmon7ckO1aP2  原KEY：CmqD6kpCBq7b7ypB 若要开启管控，key要用新key
     * @AES加密模式: CBC 填充: PKCS7Padding 数据块: 128位 密码: key 偏移量: key 输出: base64 字符集：utf8
     * @測試區:http://suapidemo.eastasia.cloudapp.azure.com/SU01SSTest_WebAPI/api/接口名
     * @開發區: http://suapidev.eastasia.cloudapp.azure.com/SU01SSDev_WebAPI/api/接口名
     */
    function WeiMengApi($Interface,$param=array(),$headers=array(),$key){

        $key = 'w7IGvmon7ckO1aP2';
        $url = 'http://suapidemo.eastasia.cloudapp.azure.com/SU01SSTest_WebAPI/api/'.$Interface;

        //AES加密
        $aes        = new AesCrypt();
        $aes->iv    = $key;  //传入iv值
        $encrypted  = $aes->encrypt(json_encode($param,320),$key); //320防止中文转译乱码或日期多反斜杠
        $encrypted  = '='.urlencode($encrypted); //转码并在前面连接"="

        $result = get_url($url,$encrypted,'JSON','POST','','',$headers); //请求接口并推送数据

        $result = $aes->decrypt($result,$key); //解密,无需转码,返回json数据

        return $result;
    }

    /** 百度接口-身份证图片识别
     * grant_type： 必须参数，固定为client_credentials；
     * client_id： 必须参数，应用的API Key；
     * client_secret： 必须参数，应用的Secret Key；
     * detect_direction: 是否检测图像旋转角度，默认不检测;
     * id_card_side : front：身份证含照片的一面；back：身份证带国徽的一面;
     * 必须上传正面照，否则报错
     * http://127.0.0.1/bbc_tjsh/ucenter/index.php?ctl=Login&met=regidapi&typ=json
     */
    public function regidapi()
    {
        $user_froutIdentity = request_string('user_froutIdentity');

        //获取access_token
        $post_data                      = array();
        $url                            = 'https://aip.baidubce.com/oauth/2.0/token';
        $post_data['grant_type']        = 'client_credentials';
        $post_data['client_id']         = 'd0o6eIZKLMZuMqzn5XubyCVy';
        $post_data['client_secret']     = 'cRFRbYjH2xCOuvd4g3mqEysAiUBAfdpD';
        $o = "";
        foreach ( $post_data as $k => $v )
        {
            $o.= "$k=" . urlencode( $v ). "&" ;
        }
        $post_data = substr($o,0,-1);

        $access_token = $this->request_token($url, $post_data); //获取access_token
        $access_token = json_decode($access_token,true);
        $access_token = $access_token['access_token'];

        //身份证识别
        $url = 'https://aip.baidubce.com/rest/2.0/ocr/v1/idcard?access_token='.$access_token;
        $img = file_get_contents($user_froutIdentity);
        $img = base64_encode($img);
        //调用使用的方法
        $bodys = array(
            "image"             => $img,
            "detect_direction"  => "true",
            "id_card_side"      => "front"
        );

        $res    = $this->request_post($url, $bodys);
        $res    = json_decode($res,true);

        //$res    = array_values(array_column($res['words_result'],'words')); //拿出words列值，并将汉字关联数组转为索引数组
        $res    = array_column($res['words_result'],'words');

        $idcard =  $res[3];

        //请求伟盟接口是否已在伟盟注册过
        $arr['IDNo']    = $res['公民身份号码'];
        $arr['Source']  = '11';
        setcookie("IDNo",$arr['IDNo'],time()+7*24*3600); //身份证号存入cookie用于银行卡唯一性验证

        //开启权限管控 设置请求头
        // $headers = array();
        // $headers = array(
        //     'x-Authority-Identity'    => 'B2C'
        // );
        //是否在伟盟注册过
        // $result = $this->WeiMengApi('B2C_CheckIDNO',$arr,$headers,$key);
        $result = WeimengApi::api('B2C_CheckIDNO',$arr);

        //加入日志
        Yf_Log::log("request:" . json_encode($arr), Yf_Log::INFO, 'CheckIDNO');  //请求数据
        $result = json_decode($result,true);
        //是否在伟盟注册过
        if ($result[0]['ResultCode'] == 1108) {
            //注册过则提示--并进入老会员首次登陆激活

            $msg    = '该身份证已注册会员';
            $status = 100;
            $result[0]['idcard'] = $res['公民身份号码'];
            $result[0]['name']   = $res['姓名'];

            //检查是否也在本商城注册过
            $User_InfoModel = new User_InfoModel();
            // $user_info_row  = $User_InfoModel -> getInfoByName($result[0]['name']);
            $user_info_row  = $User_InfoModel -> getInfoByName($result[0]['MemberID']);//user_name被插入了会员编号

            if ($user_info_row) {
                $result[0]['dirlogin'] = 1;
            }

            return $this->data->addBody(-140, $result, $msg, $status);
        }elseif ($result[0]['ResultCode'] == 1100) {
            //两边都没有注册--新会员注册
            $msg    = '成功';
            $status = 200;
            //$data['card'] = $res;

            return $this->data->addBody(-140, array_values($res), $msg, $status);
        }else{
            //return $this->data->setError($result[0]['ResultDesc']);
            $msg    = '请上传正确的身份证图片';
            $status = 250;
            $data = array();

            return $this->data->addBody(-140, $data, $msg, $status);
        }

    }
    /** 百度接口-银行卡图片识别
     * grant_type： 必须参数，固定为client_credentials；
     * client_id： 必须参数，应用的API Key；
     * http://127.0.0.1/bbc_tjsh/ucenter/index.php?ctl=Login&met=bankcardapi&typ=json
     * 可支持PNG、JPG、JPEG、BMP，图片大小不超过4M，长边不大于4096像素，请保证需要识别的部分为图片主体部分
     */
    public function bankcardapi(){

        $bankimg = request_string('bankimg');

        //获取access_token
        $url = 'https://aip.baidubce.com/oauth/2.0/token';
        $post_data['grant_type']        = 'client_credentials';
        $post_data['client_id']         = 'd0o6eIZKLMZuMqzn5XubyCVy';
        $post_data['client_secret']     = 'cRFRbYjH2xCOuvd4g3mqEysAiUBAfdpD';
        $o = "";
        foreach ( $post_data as $k => $v )
        {
            $o.= "$k=" . urlencode( $v ). "&" ;
        }
        $post_data = substr($o,0,-1);

        $access_token = $this->request_token($url, $post_data); //获取access_token
        $access_token = json_decode($access_token,true);
        $access_token = $access_token['access_token'];

        //银行卡识别
        $url = 'https://aip.baidubce.com/rest/2.0/ocr/v1/bankcard?access_token='.$access_token;

        $img = file_get_contents($bankimg);

        $img = base64_encode($img);

        //调用使用的方法
        $bodys = array(
            "image"             => $img
        );

        $res        = $this->request_post($url, $bodys);
        $res        = json_decode($res,true);

        $bankcard   =  $res['result']['bank_card_number'];

        if ($bankcard) {

            //银行卡唯一验证
            $arr['IDNo']        = $_COOKIE['IDNo'];  //  411528199110055056    120103196910015121
            $arr['BankAccount'] = $bankcard ;
            $arr['Source']      = '11';
            //开启权限管控 设置请求头
            $headers = array();
            // $headers = array(
            //     'x-Authority-Identity'    => 'B2C'
            // );
            // $result = $this->WeiMengApi('B2C_CheckBankAccount',$arr,$headers,$key);
            $result = WeimengApi::api('B2C_CheckBankAccount',$arr);
            //加入日志
            Yf_Log::log("request:" . json_encode($arr), Yf_Log::INFO, 'CheckBankAccount');  //请求数据
            preg_match_all("/(\[)(.*)(\])/i",$result, $result); //删除多余字符

            $result = json_decode($result[0][0],true);

            if ($result[0]['ResultCode'] == 1303) {
                //卡号已存在
                $msg    = $result[0]['ResultDesc'];
                $status = 250;

            }else if ($result[0]['ResultCode'] == 1300) {
                //成功
                $msg    = '成功';
                $status = 200;
                //$data['card'] = $res;

            }else{
                $msg    = $result[0]['ResultDesc'];
                $status = 250;
            }

            $bid = substr($bankcard,0,6);  //取银行卡前六位进行查询

            $User_UmstjTcardbinIModel = new User_UmstjTcardbinIModel();

            $banknation = $User_UmstjTcardbinIModel->getOneByWhere(array('BIN' => $bid));


            $res = array_merge($res['result'],$banknation);
        }

        return $this->data->addBody(-140, $res, $msg, $status);
    }
    //上线会员资格,验证辅导员直销编号
    public function CheckParent(){


        $arr['IDNo']            = request_string("IDNo");  //  身份证号 411528199110055056    120103196910015121
        $arr['ParentMemberID']  = request_string("ParentMemberID");  //辅导员直销编号 上线会员编号
        $arr['Source']          = '11';

        //AES加密
        // $aes        = new AesCrypt();

        // //开启权限管控 设置请求头
        // $headers = array();
        // $headers = array(
        //     'x-Authority-Identity'    => 'B2C'
        // );
        //是否在伟盟注册过
        // $result = $this->WeiMengApi('B2C_CheckParent',$arr,$headers,$key);
        $result = WeimengApi::api('B2C_CheckParent',$arr);

        //加入日志
        Yf_Log::log("request:" . json_encode($arr), Yf_Log::INFO, 'CheckParent');  //请求数据
        $result = json_decode($result,true);

        if ($result[0]['ResultCode'] == 1200) {
            //成功
            $msg    = '成功';
            $status = 200;

        }elseif ($result[0]['ResultCode'] == 1203) {
            //上线会员资格不符
            $msg    = $result[0]['ResultDesc'];
            $status = 250;

        }elseif ($result[0]['ResultCode'] == 1204) {
            #上线会员无效
            $msg    = $result[0]['ResultDesc'];
            $status = 250;

        }
        return $this->data->addBody(-140, $result[0], $msg, $status);
    }


    //新会员注册
    public function register1()
    {
        if(Web_ConfigModel::value('register')==2)
        {
            $this -> data -> setError('新会员注册已关闭');
            return false;
        }
        $option_value_row = request_row('option');
        $Reg_OptionModel = new Reg_OptionModel();
        $reg_opt_rows = $Reg_OptionModel -> getByWhere(array('reg_option_active' => 1));
        foreach ($reg_opt_rows as $reg_option_id => $reg_opt_row) {
            if ($reg_opt_row['reg_option_required']) {
                if ('' == $option_value_row[$reg_option_id]) {
                    $this -> data -> setError('请输入' . $reg_opt_row['reg_option_name']);
                    return false;
                }
            }
        }
        $token = request_string('t');
        $app_id = request_int('app_id');

        $par_member    = request_string("par_member"); //辅导直销员编号
        $par_name      = request_string("par_name");   //辅导员姓名
        $user_idcard   = request_string("user_idcard");
        $user_name     = request_string("user_name", null);
        $user_gender   = request_string("user_gender");
        $user_birth    = date('Y/m/d',strtotime(request_string("user_birth")));
        $user_address  = request_string("user_address");
        $mobile        = request_string("user_mobile");
        $user_code     = request_string("user_code");
        $email         = request_string("user_email");
        $bankaccount   = preg_replace('# #','',request_string("bankaccount"));
        $bankno        = request_string("bankno");
        $banksubranch  = request_string("banksubranch");   //银行支行名称
        $bankbranch    = request_string("bankbranch");     //银行分行名称
        $bankprovince  = request_string("bankprovince");   //开户行所在省
        $bankcity      = request_string("bankcity");       //开户行所在省
        $password      = request_string("user_password", null);
        $BelongSalon   = request_string("BelongSalon");    //归属沙龙
        $ImageIDNo     = request_string("ImageIDNo");    //身份证正面
        $ImageIDNo2    = request_string("ImageIDNo2");    //身份证反面
        $ImageBank     = request_string("ImageBank");    //身份证反面

        //$user_name = request_string('user_account', null);
        //$password = request_string('user_password', null);
        //$user_code = request_string('user_code');
        //$mobile = request_string('mobile');
        //$email = request_string('email');
        $reg_checkcode = 1;
        $server_id = 0;


        if (!$par_member) {
            $this ->data-> setError('请输辅导员编号');
            return false;
        }
        if (!$par_name) {
            $this ->data-> setError('请输入辅导员姓名');
            return false;
        }
        if (!$user_idcard) {
            $this ->data-> setError('请输入身份证号码');
            return false;
        }
        if (!$user_name) {
            $this ->data-> setError('请输入会员姓名');
            return false;
        }
        if (!$user_gender && $user_gender!= "0") {

            $this ->data-> setError('请输入会员性别');
            return false;
        }

        if (!$user_birth) {
            $this ->data-> setError('请输入出生年月');
            return false;
        }
        if (!$user_address) {
            $this ->data-> setError('请输入户籍地址');
            return false;
        }
        if (!$user_name) {
            $this ->data-> setError('请输入账号');
            return false;
        }
        if (!$password) {
            $this ->data-> setError('请输入密码');
            return false;
        }
        if (!$user_code) {
            $this ->data-> setError('请输入验证码');
            return false;
        }

        if (!$mobile) {
            $this ->data-> setError('请输入手机号');
            return false;
        }

        if (!$email) {
            $this ->data-> setError('请输入邮箱');
            return false;
        }

        if (!$bankaccount) {
            $this ->data-> setError('请输银行卡号');
            return false;
        }
        if (!$bankno) {
            $this ->data-> setError('请输入银行类别');
            return false;
        }
        if (!$banksubranch) {
            $this ->data-> setError('请输入银行支行名称');
            return false;
        }
        if (!$bankbranch) {
            $this ->data-> setError('请输入银行分行');
            return false;
        }
        if (!$bankprovince) {
            $this ->data-> setError('请输入开户行所在省');
            return false;
        }
        if (!$bankcity) {
            $this ->data-> setError('请输入开户行所在市');
            return false;
        }
        if (!$ImageIDNo) {
            $this ->data-> setError('请上传身份证正面图片');
            return false;
        }
        if (!$ImageIDNo2) {
            $this ->data-> setError('请上传身份证反面图片');
            return false;
        }
        if (!$ImageBank) {
            $this ->data-> setError('请上传银行卡图片');
            return false;
        }
        // $verify_key = $reg_checkcode == 2 ? $email : $mobile;
        // $verify_check = Perm::checkAppYzm($user_code, $verify_key);

        $verify_key =  $mobile; //全部默认手机
        $verify_check = 'true';//Perm::checkAppYzm($user_code, $verify_key);

        if ($verify_check) {
            $rs_row = array();
            //用户是否存在
            $User_InfoModel = new User_InfoModel();
            $User_InfoDetail = new User_InfoDetailModel();
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
//              $User_InfoModel->check_input($user_name, $password, $user_mobile);
                $now_time = time();
                $ip = get_ip();
                $session_id = uniqid();
                $arr_field_user_info = array();
                $arr_field_user_info['user_id'] = $user_id;
                // $arr_field_user_info['user_name'] = $user_name; //后面把会员编号插入此字段
                $arr_field_user_info['password'] = md5($password);
                $arr_field_user_info['action_time'] = $now_time;
                $arr_field_user_info['action_ip'] = $ip;
                $arr_field_user_info['session_id'] = $session_id;


                $arr_field_user_info_detail = array();
                //添加mobile绑定.
                //绑定标记：mobile/email/openid  绑定类型+openid
                $bind_id = $reg_checkcode == 1 ? sprintf('mobile_%s', $mobile) : sprintf('email_%s', $email);

                //查找bind绑定表
                $User_BindConnectModel = new User_BindConnectModel();
                $bind_info = $User_BindConnectModel -> getOne($bind_id);
                if (!$bind_info) {
                    $time = date('Y-m-d H:i:s', time());
                    //插入绑定表
                    $bind_array = array(
                        'bind_id' => $bind_id,
                        'user_id' => $user_id,
                        'bind_type' => $reg_checkcode == 1 ? $User_BindConnectModel ::MOBILE : $User_BindConnectModel ::EMAIL,
                        'bind_time' => $time
                    );
                    $flag = $User_BindConnectModel -> addBindConnect($bind_array);
                    check_rs($flag, $rs_row);
                    //绑定关系
                    if ($reg_checkcode == 1) {
                        $arr_field_user_info_detail['user_mobile_verify'] = 1;
                    } else {
                        $arr_field_user_info_detail['user_email_verify'] = 1;
                    }
                }
                // $arr_field_user_info_detail['user_name'] = $user_name; //后面把会员编号插入此字段
                if ($reg_checkcode == 1) {
                    $arr_field_user_info_detail['user_mobile'] = $mobile;
                } else {
                    $arr_field_user_info_detail['user_email'] = $email;
                }

                $arr_field_user_info_detail['user_truename'] = $user_name;
                $arr_field_user_info_detail['user_reg_time'] = $now_time;
                $arr_field_user_info_detail['user_count_login'] = 1;
                $arr_field_user_info_detail['user_lastlogin_time'] = $now_time;
                $arr_field_user_info_detail['user_lastlogin_ip'] = $ip;
                $arr_field_user_info_detail['user_reg_ip'] = $ip;
                $arr_field_user_info_detail['user_avatar'] = Web_ConfigModel::value('user_default_avatar', Yf_Registry::get('static_url') . '/images/default_user_portrait.png');
                $arr_field_user_info_detail['user_email_verify'] = 1; //邮箱也默认已验证

                $arr_field_user_info_detail['par_member']   = $par_member;
                $arr_field_user_info_detail['par_name']     = $par_name;
                $arr_field_user_info_detail['user_idcard']  = $user_idcard;
                $arr_field_user_info_detail['user_gender']  = $user_gender;
                $arr_field_user_info_detail['user_birth']   = $user_birth;
                $arr_field_user_info_detail['user_address'] = $user_address;
                $arr_field_user_info_detail['user_email']   = $email;
                $arr_field_user_info_detail['user_birth']   = $user_birth;
                $arr_field_user_info_detail['BelongSalon']  = $BelongSalon;
                $arr_field_user_info_detail['bankaccount']  = $bankaccount;
                $arr_field_user_info_detail['bankno']       = $bankno;
                $arr_field_user_info_detail['banksubranch'] = $banksubranch;
                $arr_field_user_info_detail['bankbranch']   = $bankbranch;
                $arr_field_user_info_detail['bankprovince'] = $bankprovince;
                $arr_field_user_info_detail['bankcity']     = $bankcity;

                //图档上传 身份证正面
                $ImageIDNo_blobName       = $user_idcard."_".date("YmdHis")."-01.jpg";
                $arr['myContainer']       = "su00ss/Images/Member";
                $arr['blobName']          = $ImageIDNo_blobName;
                $arr['file_url']          = $ImageIDNo;
                $url                      = BOLB;
                $arr_field_user_info_detail['ImageIDNo'] = get_url($url,$arr,'JSON','POST','','','');
                //身份证反面
                $ImageIDNo2_blobName      = $user_idcard."_".date("YmdHis")."-06.jpg";
                $arr['myContainer']       = "su00ss/Images/Member";
                $arr['blobName']          = $ImageIDNo2_blobName;
                $arr['file_url']          = $ImageIDNo2;
                $url                      = BOLB;

                $arr_field_user_info_detail['ImageIDNo2'] = get_url($url,$arr,'JSON','POST','','','');
                //银行卡图档上传
                $ImageBank_blobName = $user_idcard."_".date("YmdHis")."-02.jpg";
                $arr['myContainer']       = "su00ss/Images/Member";
                $arr['blobName']          = $ImageBank_blobName;
                $url                      = BOLB;
                $arr['file_url']          = $ImageBank;

                $arr_field_user_info_detail['ImageBank']  = get_url($url,$arr,'JSON','POST','','','');

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



                check_rs($flag, $rs_row);
                if ($flag == 1) {

//                        $userinfo   = $User_InfoModel->getOneByWhere(array('user_id' => $user_id));
//                        $infodetail = $User_InfoDetail->getOneByWhere(array('user_name' => $user_name));
                    //请求伟盟接口新会员加入
                    //必填
                    $arr = array();
                    $arr['MemberID']        = '';//$infodetail['MemberID']; //会员编号
                    $arr['MemberName']      = $user_name; //会员姓名
                    $arr['IDNo']            = $arr_field_user_info_detail['user_idcard']; //  411528199110055056    120103196910015121   527816198001018720
                    // $arr['IDNo']            = '370302199801154524'; //  411528199110055056    120103196910015121   527816198001018720
                    $arr['ParentMemberID']  = $arr_field_user_info_detail['par_member'];//'9191919';            //辅导直销员编号 判断须为会员档的辅导直销员编号
                    $arr['Birthday']        = $arr_field_user_info_detail['user_birth'];          //
                    if ($arr_field_user_info_detail['user_gender'] == 0) {
                        $arr['Sex']          = 'F';                  //请填入代码F：女 M：男
                    }else if($arr_field_user_info_detail['user_gender'] == 1){
                        $arr['Sex']         = 'M';
                    }else{
                        //$arr['Sex']          = '保密';
                        $arr['Sex']          = 'M';
                    }
                    $arr['JoinType']        = '1';                  //会员身份
                    $arr['MobileNo']        = $arr_field_user_info_detail['user_mobile'];        //手机号码
                    //可不必填
                    $arr['EmailAddress']    = $arr_field_user_info_detail['user_email'];//电子邮箱
                    $arr['PerZipCode']      = '';                  //户籍地址邮政编码
                    $arr['PerProvince']     = '';             //户籍地址(省分)
                    $arr['PerCity']         = '';             //户籍地址(城市)
                    $arr['PerTown']         = '';               //户籍地址(区域)
                    $arr['PerAddress']      = $arr_field_user_info_detail['user_address'];    //户籍地址
                    $arr['CurZipCode']      = '';                //通讯地址邮政编码
                    $arr['CurProvince']     = '';              //通讯地址(省分)
                    $arr['CurCity']         = '';              //通讯地址(城市)
                    $arr['CurTown']         = '';               //通讯地址
                    $arr['CurAddress']      = $arr_field_user_info_detail['user_address'];   //户籍地址
                    //必填
                    $arr['AccountNameType'] = '0';                //银行户名选项 请填入代码预设 : 0 0: 个人账户
                    $arr['AccountName']     = $user_name;                //账号用证件号
                    $arr['AccountIdNo']     = $arr_field_user_info_detail['user_idcard'];                //账号用证件号
                    //可不必填
                    $arr['AccountType']     = '22';                //帐户证号型态 请填入代码预设 : 22 22: 对私帐号
                    $arr['BankNo']          = $arr_field_user_info_detail['bankno'];                //银行类别 必填必须是102
                    $arr['BankAccount']     = $arr_field_user_info_detail['bankaccount'];         //银行账号
                    $arr['BankCity']        = $arr_field_user_info_detail['bankprovince'];             //开户行所在省
                    $arr['BankTown']        = $arr_field_user_info_detail['bankcity'];             //开户行所在市
                    $arr['BankBranch']      = $arr_field_user_info_detail['banksubranch'];           //银行分行名称
                    $arr['BankSubBranch']   = $arr_field_user_info_detail['bankbranch'];           //银行支行名称
                    $arr['BankDept']        = '';                 //分理处
                    $arr['BankDeposit']     = '';                 //储蓄所
                    $arr['BankAgency']      = '';                 //代办点
                    //必填
                    $arr['MemberStatus']    = 'N';                 //会员状态 请填入代码 预设 : N N:有效
                    $arr['OrderFlag']       = 'Y';                //订购注记 请填入代码预设 : Y Y:可订购
                    $arr['InsJoinOrder']    = 'Y';                //可否领取折让 请填入代码Y:是
                    $arr['Nationality']     = 'CN';                 //国籍 请填入代码预设 : CN CN:中国
                    $arr['CertificateType'] = '01';              //证件类别 请填入代码 预设 : 01 01:身份证
                    $arr['MemberType']      = '1';              //会员型态 请输入代码 预设: 1 1:个人
                    $arr['Position']        = '00';             //阶级 请输入代码预设: 00 00:实习代表
                    $arr['JoinDate']        = date("Y/m/d");     //入会日期
                    $arr['BelongSalon']     = $arr_field_user_info_detail['BelongSalon'];//'sl99999';        //归属沙龙 请输入沙龙编号，判断必须为辅导直销员的归属沙龙
                    $arr['JoinSalon']       = Web_ConfigModel::value('join_salon');        //加入沙龙 请输入沙龙编号 预设:ES88888
                    $arr['BrowseStatus']    = 'Y';              //可否浏览 请输入代码 预设:Y Y:可浏览
                    $arr['RoyaltyFlag']     = 'N';              //已购事业手册
                    $arr['IsRecommend']     = 'Y';              //可否推荐下线
                    $arr['ApproveStatus']   = 'Y';              //审核状态
                    $arr['ApproveDate']     = date("Y/m/d");     //审核日期
                    //可不必填
                    $arr['CompanyIdNo']     = '';           //营业执照注册号
                    $arr['CompanyName']     = '';     //营业执照商户名称
                    $arr['InvZipCode']      = '';             //营业执照邮政编码
                    $arr['InvProvince']     = '';          //营业执照地址(省分)
                    $arr['InvCity']         = '';          //营业执照地址(城市)
                    $arr['InvTown']         = '';            //营业执照地址(区域)
                    $arr['InvAddress']      = '';     //营业执照地址
                    //必填
                    $arr['ImageIDNo']       = $ImageIDNo_blobName;     //身份证图檔(正面)
                    $arr['ImageIDNo2']      = $ImageIDNo2_blobName;  //身份证图
                    $arr['ImageBank']       = $ImageBank_blobName;     //图檔名称
                    $arr['Source']          = '11';
                    //开启权限管控 设置请求头
                    $headers = array();
                    // $headers = array(
                    //     'x-Authority-Identity'    => 'B2C'
                    // );
                    //把新注册会员信息提交到伟盟
                    // $result = $this->WeiMengApi('B2C_InsertMemberSubmit',$arr,$headers,$key);
                    $result = WeimengApi::api('B2C_InsertMemberSubmit',$arr);

                    $result = json_decode($result,true);
                    //加入日志
                    $arr_field_user_info_detail['user_name'] = $result[0]['MemberID'];
                    $arr_field_user_info_detail['MemberID'] = $result[0]['MemberID'];
                    $flag = $User_InfoDetail -> addInfoDetail($arr_field_user_info_detail);
                    array_push($rs_row, $flag);
                    $arr_field_user_info['user_name'] = $result[0]['MemberID'];

                    $flag = $User_InfoModel -> addInfo($arr_field_user_info);
                    array_push($rs_row, $flag);

                    //返回会员编号
                    $MemberID   = $result[0]['MemberID'];
                    $par_member = $arr_field_user_info_detail['par_member'];
                    $desc    = $result[0]['ResultDesc'];
                    if ($result[0]['ResultCode'] == 1400  ) {

                        //修改shop端黑名单的数据
                        $key = Yf_Registry::get('shop_api_key');
                        $url = Yf_Registry::get('shop_api_url');
                        $formvars['app_id'] = Yf_Registry::get('shop_app_id');
                        $formvars['ctl'] = 'Api';
                        $formvars['met'] = 'IsBlackList';
                        $formvars['user_id'] = $user_id;
                        $formvars['typ'] = 'json';
                        $formvars['OrderFlag'] = $arr_field_user_info_detail['OrderFlag'];
                        $res = get_url_with_encrypt($key, $url, $formvars);



                        // $User_InfoModel->alterUsername($user_id, array('user_name'=>$MemberID));
                        // $User_InfoDetail->editInfoDetail($user_name, array('MemberID' => $MemberID,'user_name'=>$MemberID));

                    }else{

                        if ($desc !== '成功') {
                            $des = false;
                        }
                        check_rs($des,$rs_row);
                    }
                }

            }

            if (is_ok($rs_row) && $User_InfoDetail -> sql -> commit()) {
                $d = array();
                $d['user_id'] = $user_id;
                $encrypt_str = Perm::encryptUserInfo($d, $session_id);

                //二维码
                $qrurl = Yf_Registry::get('ucenter_api_url')."index.php?ctl=Login&act=regidimg&u_account=".$result[0]['MemberID']."&MemberID=".$result[0]['MemberID']."&user_name=".$user_name;

                $arr_body = array(
                    "user_name" => $user_name,
                    "server_id" => $server_id,
                    "k" => $encrypt_str,
                    "user_id" => $user_id,
                    'desc'=>$desc,
                    'MemberID'=>$result[0]['MemberID'],
                    'par_member'=>$par_member,
                    'qrurl' => $qrurl,
                );
                Yf_Log::log("ddd:" . json_encode($arr_body), Yf_Log::INFO, 'cc');
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
                return $this->data->addBody(-140, $arr_body,$desc,200);
            } else {
                $User_InfoDetail ->sql-> rollBack();
                $this ->data-> setError('创建用户信息失败');
            }
        } else {
            $msg = $code_from . '验证码错误';
            $status = 250;
            if (DEBUG !== true) {
                $user_code = "";
            }
            return $this ->data-> addBody(-140, array('code' => $user_code), $msg, $status);
        }
    }
    /*
         * 找回会员编号
         * */
    public function findmebId()
    {
        $user_name   = request_string('user_name');
        $user_idcard = request_string('user_idcard');
        if (!$user_name) {
            $this ->data-> setError('请输入真实姓名');
            return false;
        }
        if (!$user_idcard) {
            $this ->data-> setError('请输入身份证号');
            return false;
        }
        $User_InfoDetail = new User_InfoDetailModel();

        $result = $User_InfoDetail->getOneByWhere(array('user_truename'=>$user_name));

        if ($result) {
            $msg = _('成功');
            $status = 200;
        } else {
            $msg = _('失败');
            $status = 250;
        }
        if ($result['user_idcard'] != $user_idcard) {
            $msg = _('真实姓名和身份证不一致');
            $status = 250;
        }
        $data['MemberID'] = $result['MemberID'];
        // $data['user_truename'] = $user_name;
        // $data['result'] = $result;
        return $this->data-> addBody(-140, $data, $msg, $status);
    }
    //老会员激活
    public function register2()
    {
        $User_InfoDetail = new User_InfoDetailModel();
        $option_value_row = request_row('option');
        $Reg_OptionModel = new Reg_OptionModel();
        $reg_opt_rows = $Reg_OptionModel -> getByWhere(array('reg_option_active' => 1));
        foreach ($reg_opt_rows as $reg_option_id => $reg_opt_row) {
            if ($reg_opt_row['reg_option_required']) {
                if ('' == $option_value_row[$reg_option_id]) {
                    $this -> data -> setError('请输入' . $reg_opt_row['reg_option_name']);
                    return false;
                }
            }
        }
        $user_infodetailss = $User_InfoDetail->getOneByWhere(array('user_name'=>request_string('memberid')));
        // Yf_Log::log("request:" . json_encode($arr), Yf_Log::INFO, 'ffff');  //请求的数据
        if($user_infodetailss){
            $this ->data-> setError('用户已经存在,请更换用户名!');
            return false;
        }
        $token          = request_string('t');
        $app_id         = request_int('app_id');
        $user_name      = request_string('user_name', null);
        $password       = request_string('user_password', null);

        $user_idcard    = request_string('user_idcard');
        $memberid       = request_string('memberid');

        $images         = request_string('images');
        $images2        = request_string('images2');

        $mobile         = request_string('user_mobile');
        $email          = request_string('user_email');
        $reg_checkcode  = 1;  //默认手机
        $server_id      = 0;

        if (!$user_idcard) {
            $this ->data-> setError('请输入身份证号');
            return false;
        }
        if (!$mobile) {
            $this ->data-> setError('请输入手机号');
            return false;
        }
        if (!$email) {
            $this ->data-> setError('请输入邮箱');
            return false;
        }
        if (!$password) {
            $this ->data-> setError('请输入密码');
            return false;
        }
        if (!$memberid) {
            $this ->data-> setError('会员编号不能为空');
            return false;
        }

        $verify_key = $mobile;
        $verify_check = true;

        //老会员资料覆盖 必填
        $arr['MemberID']    = $memberid;
        $arr['IDNo']        = $user_idcard;  //  411528199110055056    120103196910015121 527816198001018720
        $arr['MobileNo']    = $mobile;
        // $arr['MobileNo']    = 13188745668;
        $arr['EmailAddress']= $email;

        //图档上传 身份证正面
        $ImageIDNo_blobName        = $user_idcard."_".date("YmdHis")."-01.jpg";
        $arr1['myContainer']       = "su00ss/Images/Member";
        $arr1['blobName']          = $ImageIDNo_blobName;
        $arr1['file_url']          = $images;
        $url                       = BOLB;
        $images = get_url($url,$arr1,'JSON','POST','','','');
        $arr['ImageIDNo'] = $ImageIDNo_blobName;
        //身份证反面
        $ImageIDNo2_blobName      = $user_idcard."_".date("YmdHis")."-06.jpg";
        $arr2['myContainer']       = "su00ss/Images/Member";
        $arr2['blobName']          = $ImageIDNo2_blobName;
        $arr2['file_url']          = $images2;
        $url                       = BOLB;

        $images2 = get_url($url,$arr2,'JSON','POST','','','');
        $arr['ImageIDNo2'] = $ImageIDNo2_blobName;
        $arr['Source'] = '11';
        //开启权限管控 设置请求头
        // $headers = array();
        //把新注册会员信息提交到伟盟
        // $result = $this->WeiMengApi('B2C_UpdateMember',$arr,$headers,$key);
        $result = WeimengApi::api('B2C_UpdateMember',$arr);

        // file_put_contents(dirname(__FILE__).DIRECTORY_SEPARATOR.'abs.php',print_r($result,true),FILE_APPEND);
        Yf_Log::log("request:" . json_encode($arr), Yf_Log::INFO, 'register2_UpdateMember');  //请求的数据
        Yf_Log::log("Return:" . $result, Yf_Log::INFO, 'register2_UpdateMember');  //请求的数据

        preg_match_all("/(\[)(.*)(\])/i",$result, $res); //删除多余字符


        // $result = json_decode($test,true);
        $result = json_decode($res[0][0],true);
        //成功
        if ($result[0]['ResultCode'] == 1500) {
            //注册
            if ($verify_check) {
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
                    $arr_field_user_info['password'] = md5($password);
                    $arr_field_user_info['action_time'] = $now_time;
                    $arr_field_user_info['action_ip'] = $ip;
                    $arr_field_user_info['session_id'] = $session_id;

                    $flag = $User_InfoModel -> addInfo($arr_field_user_info);

                    array_push($rs_row, $flag);
                    $arr_field_user_info_detail = array();
                    //添加mobile绑定.
                    //绑定标记：mobile/email/openid  绑定类型+openid
                    $bind_id = $reg_checkcode == 1 ? sprintf('mobile_%s', $mobile) : sprintf('email_%s', $email);
                    //查找bind绑定表
                    $User_BindConnectModel = new User_BindConnectModel();
                    $bind_info = $User_BindConnectModel -> getOne($bind_id);
                    if (!$bind_info) {
                        $time = date('Y-m-d H:i:s', time());
                        //插入绑定表
                        $bind_array = array(
                            'bind_id' => $bind_id,
                            'user_id' => $user_id,
                            'bind_type' => $reg_checkcode == 1 ? $User_BindConnectModel ::MOBILE : $User_BindConnectModel ::EMAIL,
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
                        $arr_field_user_info_detail['user_mobile'] = $mobile;
                    } else {
                        $arr_field_user_info_detail['user_email'] = $email;
                    }

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
                    //$arr_field_user_info_detail['AccountNameType']= $result[0]['AccountNameType'];//银行户名选项 0: 个人账户 1: 公司账户 2: 配偶账户
                    //$arr_field_user_info_detail['AccountName']    = $result[0]['AccountName'];          //银行开户名
                    $arr_field_user_info_detail['AccountType']      = $result[0]['AccountType'];        //银帐户证号型态 22: 对私帐号 32: 对公帐号
                    $arr_field_user_info_detail['bankno']           = $result[0]['BankNo'];      //开户行所在省
                    $arr_field_user_info_detail['bankaccount']      = $result[0]['BankAccount'];
                    $arr_field_user_info_detail['bankprovince']     = $result[0]['BankCity'];
                    $arr_field_user_info_detail['bankcity']         = $result[0]['BankTown'];
                    $arr_field_user_info_detail['bankbranch']       = $result[0]['BankBranch'];
                    $arr_field_user_info_detail['banksubranch']     = $result[0]['BankSubBranch'];
                    // $arr_field_user_info_detail['BankDept']         = $result[0]['BankDept'];       //分理处
                    // $arr_field_user_info_detail['BankDeposit']      = $result[0]['BankDeposit'];   //储蓄所
                    // $arr_field_user_info_detail['BankAgency']       = $result[0]['BankAgency'];  //代办点
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
            } else {
                $msg = $code_from . '验证码错误';
                $status = 250;
                if (DEBUG !== true) {
                    $user_code = "";
                }
                return $this ->data-> addBody(-1, array('code' => $user_code), $msg, $status);
            }
        }else{
            return $this ->data-> addBody(-1, $result[0], $msg, $status);
        }

    }
    public function register()
    {
        //本地读取远程信息
        //只能只能只能使用分享链接注册新账号功能（闭环）
        /*$key = Yf_Registry::get('shop_api_key');;
        $url         = Yf_Registry::get('shop_api_url');
        $shop_app_id = Yf_Registry::get('shop_app_id');

        $formvars           = $_POST;
        $formvars['app_id'] = $shop_app_id;

        $fenxiao_data = get_url_with_encrypt($key, sprintf('%s?ctl=Api_%s&met=%s&typ=json', $url, 'Fenxiao', 'getStatus'), $formvars);

        if($fenxiao_data['data']['status'] == 1){
            if(empty($_COOKIE['uu_id']))
            {
                throw new Exception("请使用分享链接注册新账号");
            }
        }*/



        $option_value_row = request_row('option');
        $Reg_OptionModel = new Reg_OptionModel();
        $reg_opt_rows = $Reg_OptionModel -> getByWhere(array('reg_option_active' => 1));
        foreach ($reg_opt_rows as $reg_option_id => $reg_opt_row) {
            if ($reg_opt_row['reg_option_required']) {
                if ('' == $option_value_row[$reg_option_id]) {
                    $this -> data -> setError('请输入' . $reg_opt_row['reg_option_name']);
                    return false;
                }
            }
        }
        $token = request_string('t');
        $app_id = request_int('app_id');
        $user_name = request_string('user_account', null);
        $password = request_string('user_password', null);
        $user_code = request_string('user_code');
        $mobile = request_string('mobile');
        $email = request_string('email');
        $reg_checkcode = request_int('reg_checkcode', 1);
        $server_id = 0;
        if (!$user_name) {
            $this ->data-> setError('请输入账号');
            return false;
        }
        if (!$password) {
            $this ->data-> setError('请输入密码');
            return false;
        }
        if (!$user_code) {
            $this ->data-> setError('请输入验证码');
            return false;
        }
        if ($reg_checkcode == 1 || $reg_checkcode == 3) {
            if (!$mobile) {
                $this ->data-> setError('请输入手机号');
                return false;
            }
            $code_from = '手机';
        } else {
            if (!$email) {
                $this ->data-> setError('请输入邮箱');
                return false;
            }
            $code_from = '邮箱';
        }
        $verify_key = $reg_checkcode == 2 ? $email : $mobile;
        $verify_check = Perm::checkAppYzm($user_code, $verify_key);
        if ($verify_check) {
            $rs_row = array();
            //用户是否存在
            $User_InfoModel = new User_InfoModel();
            $User_InfoDetail = new User_InfoDetailModel();
            $user_rows = $User_InfoDetail -> checkUserName($user_name);
            $user_name_info = $User_InfoModel -> getInfoByName($user_name);
            if ($user_rows || $user_name_info) {
                $this ->data-> setError('用户已经存在,请更换用户名!');
                return false;
            } else {
                $User_InfoModel ->sql-> startTransaction();
                $Db = Yf_Db::get('ucenter');
                $seq_name = 'user_id';
                $user_id = $Db -> nextId($seq_name);
//              $User_InfoModel->check_input($user_name, $password, $user_mobile);
                $now_time = time();
                $ip = get_ip();
                $session_id = uniqid();
                $arr_field_user_info = array();
                $arr_field_user_info['user_id'] = $user_id;
                $arr_field_user_info['user_name'] = $user_name;
                $arr_field_user_info['password'] = md5($password);
                $arr_field_user_info['action_time'] = $now_time;
                $arr_field_user_info['action_ip'] = $ip;
                $arr_field_user_info['session_id'] = $session_id;
                $flag = $User_InfoModel -> addInfo($arr_field_user_info);

                array_push($rs_row, $flag);
                $arr_field_user_info_detail = array();
                //添加mobile绑定.
                //绑定标记：mobile/email/openid  绑定类型+openid
                $bind_id = $reg_checkcode == 1 ? sprintf('mobile_%s', $mobile) : sprintf('email_%s', $email);
                //查找bind绑定表
                $User_BindConnectModel = new User_BindConnectModel();
                $bind_info = $User_BindConnectModel -> getOne($bind_id);
                if (!$bind_info) {
                    $time = date('Y-m-d H:i:s', time());
                    //插入绑定表
                    $bind_array = array(
                        'bind_id' => $bind_id,
                        'user_id' => $user_id,
                        'bind_type' => $reg_checkcode == 1 ? $User_BindConnectModel ::MOBILE : $User_BindConnectModel ::EMAIL,
                        'bind_time' => $time
                    );
                    $flag = $User_BindConnectModel -> addBindConnect($bind_array);
                    array_push($rs_row, $flag);
                    //绑定关系
                    if ($reg_checkcode == 1) {
                        $arr_field_user_info_detail['user_mobile_verify'] = 1;
                    } else {
                        $arr_field_user_info_detail['user_email_verify'] = 1;
                    }
                }
                $arr_field_user_info_detail['user_name'] = $user_name;
                if ($reg_checkcode == 1) {
                    $arr_field_user_info_detail['user_mobile'] = $mobile;
                } else {
                    $arr_field_user_info_detail['user_email'] = $email;
                }
                //$arr_field_user_info_detail['user_mobile_verify']         = 1;
                $arr_field_user_info_detail['user_reg_time'] = $now_time;
                $arr_field_user_info_detail['user_count_login'] = 1;
                $arr_field_user_info_detail['user_lastlogin_time'] = $now_time;
                $arr_field_user_info_detail['user_lastlogin_ip'] = $ip;
                $arr_field_user_info_detail['user_reg_ip'] = $ip;
                $arr_field_user_info_detail['user_avatar'] = Web_ConfigModel::value('user_default_avatar', Yf_Registry::get('static_url') . '/images/default_user_portrait.png');
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
            if (is_ok($rs_row) && $User_InfoDetail -> sql -> commit()) {
                $d = array();
                $d['user_id'] = $user_id;
                $encrypt_str = Perm::encryptUserInfo($d, $session_id);
                $arr_body = array(
                    "user_name" => $user_name,
                    "server_id" => $server_id,
                    "k" => $encrypt_str,
                    "user_id" => $user_id
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
        } else {
            $msg = $code_from . '验证码错误';
            $status = 250;
            if (DEBUG !== true) {
                $user_code = "";
            }
            return $this ->data-> addBody(-1, array('code' => $user_code), $msg, $status);
        }
    }

    public function userRegist()
    {
        $option_value_row = request_row('option');
//        $Reg_OptionModel = new Reg_OptionModel();
//        $reg_opt_rows = $Reg_OptionModel->getByWhere(array('reg_option_active'=>1));
//        foreach ($reg_opt_rows as $reg_option_id=>$reg_opt_row)
//        {
//            if ($reg_opt_row['reg_option_required'])
//            {
//                if ('' == $option_value_row[$reg_option_id])
//                {
//                    $this->data->setError('请输入' . $reg_opt_row['reg_option_name']);
//                    return false;
//                }
//            }
//        }
        $token = request_string('t');
        $app_id = request_int('app_id');
        $user_name = request_string('user_account', null);
        $password = request_string('user_password', null);
        $user_code = request_string('user_code');
        $mobile = request_string('mobile');
        $email = request_string('email');
        $reg_checkcode = request_int('reg_checkcode', 1);
        $server_id = 0;
        if (!$user_name) {
            $this -> data -> setError('请输入账号');
            return false;
        }
        if (!$password) {
            $this -> data -> setError('请输入密码');
            return false;
        }
        if (!$user_code) {
            $this -> data -> setError('请输入验证码');
            return false;
        }
        if ($reg_checkcode == 1 || $reg_checkcode == 3) {
            if (!$mobile) {
                $this -> data -> setError('请输入手机号');
                return false;
            }
            $code_from = '手机';
        } else {
            if (!$email) {
                $this -> data -> setError('请输入邮箱');
                return false;
            }
            $code_from = '邮箱';
        }
        $verify_key = $reg_checkcode == 2 ? $email : $mobile;
        $verify_check = Perm ::checkAppYzm($user_code, $verify_key);
        if ($verify_check) {
            $rs_row = array();
            //用户是否存在
            $User_InfoModel = new User_InfoModel();
            $User_InfoDetail = new User_InfoDetailModel();
            $user_rows = $User_InfoDetail -> checkUserName($user_name);
            $user_name_info = $User_InfoModel -> getInfoByName($user_name);
            if ($user_rows || $user_name_info) {
                $this -> data -> setError('用户已经存在,请更换用户名!');
                return false;
            } else {
                $User_InfoModel -> sql -> startTransaction();
                $Db = Yf_Db::get('ucenter');
                $seq_name = 'user_id';
                $user_id = $Db -> nextId($seq_name);
//              $User_InfoModel->check_input($user_name, $password, $user_mobile);
                $now_time = time();
                $ip = get_ip();
                $session_id = uniqid();
                $arr_field_user_info = array();
                $arr_field_user_info['user_id'] = $user_id;
                $arr_field_user_info['user_name'] = $user_name;
                $arr_field_user_info['password'] = md5($password);
                $arr_field_user_info['action_time'] = $now_time;
                $arr_field_user_info['action_ip'] = $ip;
                $arr_field_user_info['session_id'] = $session_id;
                $flag = $User_InfoModel -> addInfo($arr_field_user_info);
                array_push($rs_row, $flag);
                $arr_field_user_info_detail = array();
                //添加mobile绑定.
                //绑定标记：mobile/email/openid  绑定类型+openid
                $bind_id = $reg_checkcode == 1 ? sprintf('mobile_%s', $mobile) : sprintf('email_%s', $email);
                //查找bind绑定表
                $User_BindConnectModel = new User_BindConnectModel();
                $bind_info = $User_BindConnectModel -> getOne($bind_id);
                if (!$bind_info) {
                    $time = date('Y-m-d H:i:s', time());
                    //插入绑定表
                    $bind_array = array(
                        'bind_id' => $bind_id,
                        'user_id' => $user_id,
                        'bind_type' => $reg_checkcode == 1 ? $User_BindConnectModel ::MOBILE : $User_BindConnectModel ::EMAIL,
                        'bind_time' => $time
                    );
                    $flag = $User_BindConnectModel -> addBindConnect($bind_array);
                    array_push($rs_row, $flag);
                    //绑定关系
                    if ($reg_checkcode == 1) {
                        $arr_field_user_info_detail['user_mobile_verify'] = 1;
                    } else {
                        $arr_field_user_info_detail['user_email_verify'] = 1;
                    }
                }
                $arr_field_user_info_detail['user_name'] = $user_name;
                if ($reg_checkcode == 1) {
                    $arr_field_user_info_detail['user_mobile'] = $mobile;
                } else {
                    $arr_field_user_info_detail['user_email'] = $email;
                }
                //$arr_field_user_info_detail['user_mobile_verify']         = 1;
                $arr_field_user_info_detail['user_reg_time'] = $now_time;
                $arr_field_user_info_detail['user_count_login'] = 1;
                $arr_field_user_info_detail['user_lastlogin_time'] = $now_time;
                $arr_field_user_info_detail['user_lastlogin_ip'] = $ip;
                $arr_field_user_info_detail['user_reg_ip'] = $ip;
                $arr_field_user_info_detail['user_avatar'] = Web_ConfigModel::value('user_default_avatar', Yf_Registry ::get('static_url') . '/images/default_user_portrait.png');
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
            if (is_ok($rs_row) && $User_InfoDetail -> sql -> commit()) {
                $d = array();
                $d['user_id'] = $user_id;
                $encrypt_str = Perm::encryptUserInfo($d, $session_id);
                $arr_body = array(
                    "user_name" => $user_name,
                    "server_id" => $server_id,
                    "k" => $encrypt_str,
                    "user_id" => $user_id
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
                return $this -> data -> addBody(100, $arr_body);
            } else {
                $User_InfoDetail -> sql -> rollBack();
                $this -> data -> setError('创建用户信息失败');
            }
        } else {
            $msg = $code_from . '验证码错误';
            $status = 250;
            if (DEBUG !== true) {
                $user_code = "";
            }
            return $this -> data -> addBody(-1, array('code' => $user_code), $msg, $status);
        }
    }

    public function loginex()
    {
        $token = request_string('t');
        fb($token);
        $user_name = strtolower($_REQUEST['user_account']);
        if (!$user_name) {
            $user_name = strtolower($_REQUEST['user_name']);
        }
        $password = $_REQUEST['user_password'];
        $md5_password = $_REQUEST['md5_password'];
        if (!$password) {
            $password = $_REQUEST['password'];
        }
        if (!strlen($user_name)) {
            $this -> data -> setError('请输入账号');
            return false;
        }
        if (!strlen($password) && !strlen($md5_password)) {
            $this -> data -> setError('请输入密码');
        } else {
            $User_InfoModel = new User_InfoModel();
            $User_InfoDetail = new User_InfoDetailModel();
            $user_info_row = $User_InfoModel -> getInfoByName($user_name);
            if (!$user_info_row) {
                $this -> data -> setError('账号不存在');
                return false;
            }
            if ($password) {
                $pswd = md5($password);
            }
            if ($md5_password) {
                $pswd = $md5_password;
            }
            if ($pswd != $user_info_row['password']) {
                $this -> data -> setError('密码错误');
            } else {
                //$session_id = uniqid();
                $session_id = $user_info_row['session_id'];
                $arr_field = array();
                $arr_field['session_id'] = $session_id;
                //if ($User_InfoModel->editInfo($user_info_row['user_id'], $arr_field) > 0)
                if (true) {
                    //$arr_body = array("result"=>1,"user_name"=>$user_info_row['user_name'],"session_id"=>$session_id);
                    $arr_body = $user_info_row;
                    $arr_body['result'] = 1;
                    //$arr_body['session_id'] = $session_id;
                    $data = array();
                    $data['user_id'] = $user_info_row['user_id'];
                    //$data['session_id'] = $session_id;
                    $encrypt_str = Perm ::encryptUserInfo($data, $session_id);
                    $arr_body['k'] = $encrypt_str;
                    //插入绑定表
                    if ($token) {
                        //查找bind绑定表
                        $User_BindConnectModel = new User_BindConnectModel();
                        $bind_info = $User_BindConnectModel -> getBindConnectByToken($token);
                        $bind_info = $bind_info[0];
                        //插入绑定表
                        $time = date('Y-m-d H:i:s', time());
                        $User_BindConnectModel = new User_BindConnectModel();
                        $bind_array = array(
                            'user_id' => $user_info_row['user_id'],
                            'bind_time' => $time,
                            'bind_token' => $token,
                        );
                        $User_BindConnectModel -> editBindConnect($bind_info['bind_id'], $bind_array);
                    }
                    $this -> data -> addBody(100, $arr_body);
                } else {
                    $this -> data -> setError('登录失败');
                }
            }
        }
    }

    /**
     * 给IOS自动登录使用
     * 调用URL /index.php?ctl=Login&met=login_wkwebview&typ=json&token=XXX
     *
     * @return  [type]
     * @weichat sunkangchina
     * @date    2017-12-05
     */
    public function login_wkwebview()
    {
        $cr = new ECrypt();
        $token = $_GET['token'];
        $msg = "error";
        $flag = true;
        if (!$token) {
            $flag = false;
            goto E1;
        }
        $token = urldecode($token);
        $arr = $cr -> decode($token);
        $user_id = $arr['user_id'];
        $time = $arr['time'];
        if (!$time || !$user_id) {
            $flag = false;
            $msg = "no user_infomation params";
            goto E1;
        }
        $User_InfoModel = new User_InfoModel();
        $user_info_row = $User_InfoModel -> getOne($user_id);
        //print_r($user_info_row['user_name']);
        if (!$user_info_row) {
            $flag = false;
            $msg = "not find";
            goto E1;
        }
        $session_id = $user_info_row['session_id'];
        $data = $arr_body = array();
        $data['user_id'] = $user_info_row['user_id'];
        $encrypt_str = Perm ::encryptUserInfo($data, $session_id);
        $arr_body['k'] = $encrypt_str;
        $this -> data -> addBody(100, $arr_body);
        E1:
        if ($flag == false) {
            $this -> data -> addBody(-1, [], $msg, 250);
        }
        if ($jsonp_callback = request_string('jsonp_callback')) {
            exit($jsonp_callback . '(' . json_encode($this -> data -> getDataRows()) . ')');
        }
    }

    public function login()
    {
        $token = request_string('t');
        $type = request_int('type');
        //如果密码错误三次及以上开启图形验证码
        // if ($_COOKIE['passwordErrorCount'] >= 3 || isset($_REQUEST['imgCode'])) {
        //     session_start();
        //     if (!request_string('imgCode') || strtolower(request_string('imgCode')) !== strtolower($_SESSION["auth"])) {
        //         return $this ->data-> setError('验证码错误');
        //     }
        // }
        $user_name = strtolower(request_string('user_account'));
      //  print_r($user_name);die;
        //查找bind绑定表
        $User_BindConnectModel = new User_BindConnectModel();
        if (!$user_name) {
            $user_name = strtolower(request_string('user_name'));
        }
        $password = $_REQUEST['user_password'];

        $md5_password = request_string('md5_password');

        if (!$password) {
            $password = request_int('password');
        }
        //添加验证
        if (!strlen($user_name)) {
            $this ->data-> setError('请输入会员编号或手机号');
            return false;
        }
        if (!$password) {
            $this ->data-> setError('请输入密码');
            return false;
        }

        if($user_name=="admin")
        {
            $this->data->setError('账号不存在，请核实后输入！');
            return false;
        }




        if (!strlen($password) && !strlen($md5_password)) {
            $this ->data-> setError('请输入密码');
        } else {
            $User_InfoModel = new User_InfoModel();
            $User_InfoDetail = new User_InfoDetailModel();
            $bind_id = '';
            $user_info_row = array();
            //添加mobile绑定.
            //绑定标记：mobile/email/openid  绑定类型+openid

            //判断是否过期
            if(strlen($user_name)==11)
            {
            $User_InfoDetail = new User_InfoDetailModel();
            $user_info_row1 = $User_InfoDetail->getOneByWhere(array('user_mobile'=>$user_name));
            $arr=array();
            $arr['ParentMemberID'] = $user_info_row1['user_name'];
            $arr['IDNo']= $user_info_row1['user_idcard'];
            $arr['Source'] = 11;
            $result = current(json_decode(WeimengApi::api('B2C_CheckParent',$arr),true));
            if($result['ResultCode']!='1200'){
                $this ->data-> setError('您的会员已过期,请联系平台');
                return false;
              }
            }else if(strlen($user_name)==7)
            {
            $User_InfoDetail = new User_InfoDetailModel();
            $user_info_row1 = $User_InfoDetail->getOneByWhere(array('user_name'=>$user_name));
            $arr=array();
            $arr['ParentMemberID'] = $user_info_row1['user_name'];
            $arr['IDNo']= $user_info_row1['user_idcard'];
            $arr['Source'] = 11;
            $result = current(json_decode(WeimengApi::api('B2C_CheckParent',$arr),true));
            if($result['ResultCode']!='1200'){
                $this ->data-> setError('您的会员已过期,请联系平台');
                return false;
              }  

            }

            if ($bind_id) {
                //查找bind绑定表
                $User_BindConnectModel = new User_BindConnectModel();
                $bind_info = $User_BindConnectModel -> getOne($bind_id);
                if ($bind_info) {
                    //用户名登录 手机号邮箱
                    $user_info_row  = $User_InfoModel -> getOne($bind_info['user_id']);
                    $user_info_row1 = $User_InfoDetail->getOneByWhere(array('user_name'=>$user_info_row['user_name']));
                    $user_info_row  = array_merge($user_info_row,$user_info_row1);
                    //判断会员状态  会员状态  C:过期D:冻结F:严重取消N:有效Q:取消S:移转
//                    if ($user_info_row['MemberStatus'] == 'C') {
//                        $this ->data-> setError('无法登陆,您的会员已过期');
//                        return false;
//                    }elseif ($user_info_row['MemberStatus'] == 'D') {
//                        $this ->data-> setError('无法登陆,您的会员已冻结');
//                        return false;
//                    }elseif ($user_info_row['MemberStatus'] == 'F') {
//                        $this ->data-> setError('无法登陆,您的会员已严重取消');
//                        return false;
//                    }elseif ($user_info_row['MemberStatus'] == 'Q') {
//                        $this ->data-> setError('无法登陆,您的会员已取消');
//                        return false;
//                    }elseif($user_info_row['MemberStatus'] == 'S'){
//                        $this ->data-> setError('无法登陆,您的会员已移转');
//                        return false;
//                    }
                }
            }
        }












        if (!strlen($password) && !strlen($md5_password)) {
            $this ->data-> setError('请输入密码');
        } else {
            $User_InfoModel = new User_InfoModel();
            $User_InfoDetail = new User_InfoDetailModel();
            $bind_id = '';
            $user_info_row = array();
            //添加mobile绑定.
            //绑定标记：mobile/email/openid  绑定类型+openid
            {
                if (filter_var($user_name, FILTER_VALIDATE_EMAIL)) {
                    //邮件登录
                    $bind_id = sprintf('email_%s', $user_name);
                } elseif (Yf_Utils_String::isMobile($user_name)) {
                    //手机号登录
                    $bind_id = sprintf('mobile_%s', $user_name);
                }

                if ($bind_id) {
                    //查找bind绑定表
                    $User_BindConnectModel = new User_BindConnectModel();
                    $bind_info = $User_BindConnectModel -> getOne($bind_id);
                    if ($bind_info) {
                        //用户名登录 手机号邮箱
                        $user_info_row  = $User_InfoModel -> getOne($bind_info['user_id']);
                        $user_info_row1 = $User_InfoDetail->getOneByWhere(array('user_name'=>$user_info_row['user_name']));
                        $user_info_row  = array_merge($user_info_row,$user_info_row1);
                        //判断会员状态  会员状态  C:过期D:冻结F:严重取消N:有效Q:取消S:移转
//                        if ($user_info_row['MemberStatus'] == 'C') {
//                            $this ->data-> setError('无法登陆,您的会员已过期');
//                            return false;
//                        }elseif ($user_info_row['MemberStatus'] == 'D') {
//                            $this ->data-> setError('无法登陆,您的会员已冻结');
//                            return false;
//                        }elseif ($user_info_row['MemberStatus'] == 'F') {
//                            $this ->data-> setError('无法登陆,您的会员已严重取消');
//                            return false;
//                        }elseif ($user_info_row['MemberStatus'] == 'Q') {
//                            $this ->data-> setError('无法登陆,您的会员已取消');
//                            return false;
//                        }elseif($user_info_row['MemberStatus'] == 'S'){
//                            $this ->data-> setError('无法登陆,您的会员已移转');
//                            return false;
//                        }
                    }
                }

                if ($user_info_row) {
                } else {
                    //用户名登录
                    $user_info_row  = $User_InfoModel -> getInfoByName($user_name);
                    $user_info_row1 = $User_InfoDetail->getOneByWhere(array('user_name'=>$user_info_row['user_name']));
                    $user_info_row  = array_merge($user_info_row,$user_info_row1);

                    //判断会员状态  会员状态  C:过期D:冻结F:严重取消N:有效Q:取消S:移转
//                    if ($user_info_row['MemberStatus'] == 'C') {
//                        $this ->data-> setError('无法登陆,您的会员已过期');
//                        return false;
//                    }elseif ($user_info_row['MemberStatus'] == 'D') {
//                        $this ->data-> setError('无法登陆,您的会员已冻结');
//                        return false;
//                    }elseif ($user_info_row['MemberStatus'] == 'F') {
//                        $this ->data-> setError('无法登陆,您的会员已严重取消');
//                        return false;
//                    }elseif ($user_info_row['MemberStatus'] == 'Q') {
//                        $this ->data-> setError('无法登陆,您的会员已取消');
//                        return false;
//                    }elseif($user_info_row['MemberStatus'] == 'S'){
//                        $this ->data-> setError('无法登陆,您的会员已移转');
//                        return false;
//                    }
                }
                //添加会员编号登录
                if(!$user_info_row){
                    // print_r($user_info_row);die;
                    $user_info_row2 = $User_InfoDetail->getOneByWhere(array('MemberID'=>$user_name));
                    $user_info_row1 = $User_InfoModel->getOneByWhere(array('user_name'=>$user_info_row2['user_name']));
                    $user_info_row  = array_merge($user_info_row1,$user_info_row2);

                    //判断会员状态  会员状态  C:过期D:冻结F:严重取消N:有效Q:取消S:移转
//                    if ($user_info_row['MemberStatus'] == 'C') {
//                        $this ->data-> setError('无法登陆,您的会员已过期');
//                        return false;
//                    }elseif ($user_info_row['MemberStatus'] == 'D') {
//                        $this ->data-> setError('无法登陆,您的会员已冻结');
//                        return false;
//                    }elseif ($user_info_row['MemberStatus'] == 'F') {
//                        $this ->data-> setError('无法登陆,您的会员已严重取消');
//                        return false;
//                    }elseif ($user_info_row['MemberStatus'] == 'Q') {
//                        $this ->data-> setError('无法登陆,您的会员已取消');
//                        return false;
//                    }elseif($user_info_row['MemberStatus'] == 'S'){
//                        $this ->data-> setError('无法登陆,您的会员已移转');
//                        return false;
//                    }
                }
            }

            if (!$user_info_row) {
                $this ->data-> setError('账号不存在,请完成首次注册,即可进入商城');
                return false;
            }
            if ($password) {
                $pswd = md5($password);
            }
            if ($md5_password) {
                $pswd = $md5_password;
            }
            if ($pswd != $user_info_row['password']) {
                $this ->data-> setError('密码错误');
            } else {
                if (3 == $user_info_row['user_state']) {
                    $this ->data-> setError('用户已经锁定,禁止登录!');
                    return false;
                }
                //$session_id = uniqid();
                $session_id = $user_info_row['session_id'];
                $arr_field = array();
                $arr_field['session_id'] = $session_id;
                //if ($User_InfoModel->editInfo($user_info_row['user_id'], $arr_field) > 0)
                if ($user_info_row['user_id'] != 0 && $token) {
                    $bind_id_row = $User_BindConnectModel -> getBindConnectByuserid($user_info_row['user_id'], $type);
                    if ($bind_id_row) {
                        $this ->data-> setError('账号已绑定');
                        return false;
                    }
                }
                $info_row = $User_InfoDetail -> getOne($user_info_row['user_name']);
                if ($info_row['user_no_mobile'] && isset($info_row['user_no_mobile'])) {
                    $info_row['user_no_mobile'] = $info_row['user_no_mobile'];
                } else {
                    $info_row['user_no_mobile'] = 1;
                }
                if (false) {
                    $this ->data->setError('登录失败', $info_row, 210);
                    return false;
                } else {
                    $arr_body = $user_info_row;
                    $arr_body['mobile'] = $info_row['user_mobile'];
                    $arr_body['result'] = 1;
                    //$arr_body['session_id'] = $session_id;
                    $data = array();
                    $data['user_id'] = $user_info_row['user_id'];
                    //$data['session_id'] = $session_id;
                    $encrypt_str = Perm::encryptUserInfo($data, $session_id);
                    $arr_body['k'] = $encrypt_str;
                    //插入绑定表
                    if ($token) {
                        $bind_info = $User_BindConnectModel -> getBindConnectByToken($token);
                        $bind_info = $bind_info[0];
                        //插入绑定表
                        $time = date('Y-m-d H:i:s', time());
                        $User_BindConnectModel = new User_BindConnectModel();
                        $bind_array = array(
                            'user_id' => $user_info_row['user_id'],
                            'bind_time' => $time,
                            'bind_token' => $token,
                        );
                        $User_BindConnectModel -> editBindConnect($bind_info['bind_id'], $bind_array);
                    }
                    $arr_field_user_info_detail['user_count_login'] = $info_row['user_count_login'] + 1;
                    $arr_field_user_info_detail['user_lastlogin_time'] = time();
                    $User_InfoDetail -> editInfoDetail($user_name, $arr_field_user_info_detail);
                    $this ->data-> addBody(100, $arr_body);
                }

            }
        }

        if ($jsonp_callback = request_string('jsonp_callback')) {

            exit($jsonp_callback . '(' . json_encode($this ->data->getDataRows()) . ')');
        }
    }

    /*
     * 用户退出
     *
     *
     */
    public function loginout()
    {
        if (isset($_COOKIE['key']) || isset($_COOKIE['id'])) {
            setcookie("key", null, time() - 3600 * 24 * 365);
            setcookie("id", null, time() - 3600 * 24 * 365);
        }
        //如果已经登录,则直接跳转
        if (isset($_REQUEST['callback'])) {
            $url = urldecode($_REQUEST['callback']);
        } else {
            $url = Yf_Registry ::get('url');
        }
        if ('e' == $this -> typ) {
            header('location:' . $url);
        } else {
            $this -> data -> addBody(-1, array());
            if ($jsonp_callback = request_string('jsonp_callback')) {
                exit($jsonp_callback . '(' . json_encode($this -> data -> getDataRows()) . ')');
            }
        }
    }

    public function logout()
    {
        $this -> loginout();
    }

    /*
     * 检测用户登录
     */
    public function checkLogin()
    {
        if (Perm ::checkUserPerm()) {
            $msg = '数据正确';
            $status = 200;
            $data = Perm ::$row;
            //user detail
            $User_InfoDetailModel = new User_InfoDetailModel();
            $data_info = $User_InfoDetailModel -> getOne($data['user_name']);
            $data = array_merge($data, $data_info);
            if (!$data['user_avatar']) {
                $data['user_avatar'] = Web_ConfigModel ::value('user_default_avatar', Yf_Registry ::get('static_url') . '/images/default_user_portrait.png');
            }
            $data['k'] = $_COOKIE['key'];
            $data['u'] = $_COOKIE['id'];
            //unset($data['session_id']);
        } else {
            $msg = '权限错误';
            $status = 250;
            $data = array();
            $data['k'] = $_COOKIE['key'];
            $data['u'] = $_COOKIE['id'];
        }
        $this -> data -> addBody(100, $data, $msg, $status);
    }

    /**
     *  检查用户名是否存在
     *  检查user_name, user_tel,user_mobile,user_emial
     */
    public function checkUserName()
    {
        $user_name = request_string('user_name');
        $cond_row = array();
        $cond_row['user_name'] = $user_name;
        $User_Info = new User_Info();
        $flag = $User_Info -> getByWhere($cond_row);
        $data = array();
        if ($flag) {
            $msg = '该用户名已存在！';
            $status = 200;
        } else {
            $msg = '未查询到该用户名';
            $status = 250;
        }
        $this -> data -> addBody(-1, $data, $msg, $status);
    }

    public function checkMobile()
    {
        $mobile = request_string('mobile');
        //判断手机号是否已经注册过
        $User_InfoDetail = new User_InfoDetail();
        $checkmobile = $User_InfoDetail -> checkUserName($mobile, Perm ::$userId);
        $arr = array();
        $arr['Source'] = 11;
        $arr['MobileNo'] = $mobile;
        $result = current(json_decode(WeimengApi::api('B2C_CheckMobile',$arr),true));
        $data = array();
        if (count($checkmobile)||$result['ResultCode']==1803) {
            $msg = 'failure';
            $status = 250;
        } else {
            $msg = 'success';
            $status = 200;
        }
        $this -> data -> addBody(-140, $data, $msg, $status);
    }

    public function checkStatus()
    {
        $data = array();
        //如果已经登录,则直接跳转
        if (Perm ::checkUserPerm()) {
            $data = Perm ::$row;
            $k = $_COOKIE[Perm ::$cookieName];
            $u = $_COOKIE[Perm ::$cookieId];
            $data['ks'] = $k;
            $data['us'] = $u;
            $msg = '已登录';
            $status = 200;
        } else {
            $data = Perm ::$row;
            $msg = '未登录';
            $status = 250;
        }
        $this -> data -> addBody(-1, $data, $msg, $status);
        if ($jsonp_callback = request_string('jsonp_callback')) {
            exit($jsonp_callback . '(' . json_encode($this -> data -> getDataRows()) . ')');
        }
    }

    //门店帐号注册
    public function registerChain()
    {
        $user_name = request_string('user_account', null);
        $password = request_string('user_password', null);
        $server_id = 0;
        if (!$user_name) {
            return $this -> data -> addBody(-1, array(), '请输入账号', 250);
        }
        if (!$password) {
            return $this -> data -> addBody(-1, array(), '请输入密码', 250);
        }
        $rs_row = array();
        //用户是否存在
        $User_InfoModel = new User_InfoModel();
        $User_InfoDetail = new User_InfoDetailModel();
        $user_rows = $User_InfoModel -> getInfoByName($user_name);
        if ($user_rows) {
            $arr_body = array(
                "user_name" => $user_name,
                "user_id" => $user_rows['user_id']
            );
            return $this -> data -> addBody(-1, $arr_body, '用户名已经存在', 250);
        } else {
            $User_InfoModel -> sql -> startTransaction();
            $Db = Yf_Db ::get('ucenter');
            $seq_name = 'user_id';
            $user_id = $Db -> nextId($seq_name);
            //$User_InfoModel->check_input($user_name, $password, $user_mobile);
            $now_time = time();
            $ip = get_ip();
            $session_id = uniqid();
            $arr_field_user_info = array();
            $arr_field_user_info['user_id'] = $user_id;
            $arr_field_user_info['user_name'] = $user_name;
            $arr_field_user_info['password'] = md5($password);
            $arr_field_user_info['action_time'] = $now_time;
            $arr_field_user_info['action_ip'] = $ip;
            $arr_field_user_info['session_id'] = $session_id;
            $flag = $User_InfoModel -> addInfo($arr_field_user_info);
            array_push($rs_row, $flag);
            $arr_field_user_info_detail = array();
            $arr_field_user_info_detail['user_name'] = $user_name;
            $arr_field_user_info_detail['user_mobile'] = $mobile;
            //$arr_field_user_info_detail['user_mobile_verify']         = 1;
            $arr_field_user_info_detail['user_reg_time'] = $now_time;
            $arr_field_user_info_detail['user_count_login'] = 1;
            $arr_field_user_info_detail['user_lastlogin_time'] = $now_time;
            $arr_field_user_info_detail['user_lastlogin_ip'] = $ip;
            $arr_field_user_info_detail['user_reg_ip'] = $ip;
            $flag = $User_InfoDetail -> addInfoDetail($arr_field_user_info_detail);
            array_push($rs_row, $flag);
        }
        $app_id = isset($_REQUEST['app_id']) ? $_REQUEST['app_id'] : 0;
        $Base_App = new Base_AppModel();
        if ($app_id && !($base_app_rows = $Base_App -> getApp($app_id))) {
            /*
            $base_app_row = array_pop($base_app_rows);

            $arr_field_user_app = array();
            $arr_field_user_app['user_name'] = $user_name;
            $arr_field_user_app['app_id'] = $app_id;
            $arr_field_user_app['active_time'] = time();

            $User_App = new User_AppModel();

            //是否存在
            $user_app_row = $User_App->getAppByNameAndAppId($user_name, $app_id);

            if ($user_app_row)
            {
                // update app_quantity
                $app_quantity_row = array();
                $app_quantity_row['app_quantity'] = $user_app_row['app_quantity'] + 1;
                $flag = $User_App->editApp($user_name, $app_quantity_row);
                array_push($rs_row, $flag);
            }
            else
            {

                $flag = $User_App->addApp($arr_field_user_app);
                array_push($rs_row, $flag);

            }

            $User_AppServerModel = new User_AppServerModel();

            $user_app_server_row = array();
            $user_app_server_row['user_name'] = $user_name;
            $user_app_server_row['app_id'] = $app_id;
            $user_app_server_row['server_id'] = $server_id;
            $user_app_server_row['active_time'] = time();

            $flag = $User_AppServerModel->addAppServer($user_app_server_row);
            */
        } else {
        }
        if (is_ok($rs_row) && $User_InfoDetail -> sql -> commit()) {
            $d = array();
            $d['user_id'] = $user_id;
            $encrypt_str = Perm::encryptUserInfo($d, $session_id);
            $arr_body = array(
                "user_name" => $user_name,
                "server_id" => $server_id,
                "k" => $encrypt_str,
                "user_id" => $user_id
            );
            $this -> data -> addBody(100, $arr_body, 'sucess', 200);
        } else {
            $Base_App -> sql -> rollBack();
            return $this -> data -> addBody(-1, array(), '创建用户信息失败', 250);
        }
    }

    public function regConfig()
    {
        $Web_ConfigModel = new Web_ConfigModel();
        $config_type_row = request_row('config_type');
        fb($config_type_row);
        $rs_row = array();
        foreach ($config_type_row as $config_type) {
            $config_value_row = request_row($config_type);
            fb($config_value_row);
            $config_rows = $Web_ConfigModel -> getByWhere(array('config_type' => $config_type));
            fb($config_rows);
            foreach ($config_rows as $config_key => $config_row) {
                $edit_row = array();
                if (isset($config_value_row[$config_key])) {
                    if ('json' == $config_row['config_datatype']) {
                        $edit_row['config_value'] = json_encode($config_value_row[$config_key]);
                    } else {
                        $edit_row['config_value'] = $config_value_row[$config_key];
                    }
                } else {
                    if ('number' == $config_row['config_datatype']) {
                        if ('theme_id' != $config_key) {
                            //$edit_row['config_value'] = 0;
                        }
                    } else {
                    }
                }
                if ($edit_row) {
                    $flag = $Web_ConfigModel -> editConfig($config_key, $edit_row);
                    check_rs($flag, $rs_row);
                }
            }
        }
        $flag = is_ok($rs_row);
        if ($flag) {
            $msg = 'success';
            $status = 200;
        } else {
            $msg = 'failure';
            $status = 250;
        }
        $this -> data -> addBody(-1, $edit_row, $msg, $status);
    }

    public function checkEmail()
    {
        $email = request_string('email');
        //判断邮箱号是否已经注册过
        $User_InfoDetail = new User_InfoDetailModel();
        $checkmobile = $User_InfoDetail -> checkEmail($email);
        $data = array();
        if ($checkmobile) {
            $msg = 'failure';
            $status = 250;
        } else {
            $msg = 'success';
            $status = 200;
        }
        $this -> data -> addBody(-140, $data, $msg, $status);
    }

    /**
     *  缓存验证码
     *
     * @param type $key
     * @param type $value
     * @param type $group
     *
     * @return type
     */
    public function _saveCodeCache($key, $value, $group = 'verify_code')
    {
        $config_cache = Yf_Registry ::get('config_cache');
        if (!file_exists($config_cache[$group]['cacheDir'])) {
            mkdir($config_cache[$group]['cacheDir'], 0755);
        }
        $Cache_Lite = new Cache_Lite_Output($config_cache[$group]);
        $result = $Cache_Lite -> save($value, $key);
        return $result;
    }

    //判断用户是否绑定手机号
    public function checkUserMobile()
    {
        $user_id = request_int('user_id');
        //查找绑定表
        $User_BindConnectModel = new User_BindConnectModel();
        $bind_id_row = $User_BindConnectModel -> getBindConnectByuserid($user_id, User_BindConnectModel::MOBILE);
        if ($bind_id_row) {
            $msg = 'success';
            $status = 200;
        } else {
            $msg = 'failure';
            $status = 250;
        }
        $this -> data -> addBody(-140, array(), $msg, $status);
    }

    public function editNickName()
    {
        $nickname = request_string("nickname");
        $token = request_string('token');
        if (!$nickname || !$token) {
            return $this -> data -> setError('无效用户名');
        }
        $User_BindConnectModel = new User_BindConnectModel();
        $bind_info = $User_BindConnectModel -> getBindConnectByToken($token);
        $bind_info = current($bind_info);
        if (!$bind_info) {
            return $this -> data -> setError('绑定账号不存在');
        }
        //判断绑定账户是否已经绑定过用户，已经绑定过用户的账号，不可重复绑定
        if ($bind_info['user_id']) {
            return $this -> data -> setError('该账号已经绑定用户');
        }
        //判断该账号名是否已经存在
        $User_InfoModel = new User_InfoModel();
        $User_InfoDetail = new User_InfoDetailModel();
        $user_rows = $User_InfoModel -> getInfoByName($nickname);
        //如果用户名已经存在了，则在用户名后面添加随机数
        if ($user_rows) {
            return $this -> data -> setError('已存在该用户名');
        }
        $bind_id = $bind_info['bind_id'];
        $flag = $User_BindConnectModel -> editBindConnect($bind_id, ['bind_nickname' => $nickname]);
        if ($flag) {
            $msg = __('修改成功');
            $status = 200;
        } else {
            $msg = __('修改失败');
            $status = 250;
        }
        $this -> data -> addBody(-140, ['bind_nickname' => $nickname], $msg, $status);
    }

    /**
     * 客户端验证码
     */
    public function getAppVerifyCode()
    {
        $app_token = urldecode($_REQUEST['app_token']);
        $request_data = $this -> ecryptDecode($app_token);
        if ($request_data) {
            $verify_key = trim($request_data['verify_key']);
            $code = mt_rand(100000, 999999);
            $save_result = $this -> _saveCodeCache($verify_key, $code, 'verify_code');
            if (!$save_result) {
                return $this -> data -> addBody(-140, array('verify_code' => ''), __('failure'), 250);
            } else {
                return $this -> data -> addBody(-140, array('verify_code' => $code), __('success'), 200);
            }
        } else {
            return $this -> data -> addBody(-140, array('verify_code' => ''), __('验证失败'), 250);
        }
    }

    /**
     *  客户端验证短信内容
     */
    public function appRegCode()
    {
        $app_token = urldecode($_REQUEST['app_token']);
        $request_data = $this -> ecryptDecode($app_token);
        $mobile = $request_data['mobile'];
        $email = $request_data['email'];
        if (!Perm ::checkAppYzm($request_data['verify_code'], $request_data['verify_key'])) {
            return $this -> data -> addBody(-140, array(), __('验证失败'), 250);
        }
        $check_code = mt_rand(100000, 999999);
        if ($mobile && preg_match('/^1[\d]{10}$/', $mobile)) {
            //判断手机号是否已经注册过
            $User_InfoDetail = new User_InfoDetailModel();
            $checkmobile = $User_InfoDetail -> checkMobile($mobile);
            if ($checkmobile) {
                $msg = __('该手机号已注册');
                $status = 250;
            } else {
                $save_result = $this -> _saveCodeCache($mobile, $check_code, 'verify_code');
                if (!$save_result) {
                    $msg = __('发送失败');
                    $status = 250;
                } else {
                    //发送短消息
                    $message_model = new Message_TemplateModel();
                    $pattern = array('/\[weburl_name\]/', '/\[yzm\]/');
                    $replacement = array(Web_ConfigModel ::value("site_name"), $check_code);
                    $message_info = $message_model -> getTemplateInfo(array('code' => 'regist_verify'), $pattern, $replacement);
                    if (!$message_info['is_phone']) {
                        $this -> data -> addBody(-140, array(), __('信息内容创建失败'), 250);
                    }
                    $contents = $message_info['content_phone'];
                    $result = Sms ::send($mobile, $contents);
                    if ($result) {
                        $msg = __('发送成功');
                        $status = 200;
                    } else {
                        $msg = __('发送失败');
                        $status = 250;
                    }
                }
            }
        } elseif ($email && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            //判断邮箱是否已经注册过
            $User_InfoDetail = new User_InfoDetailModel();
            $checkemail = $User_InfoDetail -> checkEmail($email);
            if ($checkemail) {
                $msg = __('该邮箱已注册');
                $status = 250;
            } else {
                $save_result = $this -> _saveCodeCache($email, $check_code, 'verify_code');
                if (!$save_result) {
                    $msg = __('验证码获取失败');
                    $status = 250;
                } else {
                    //发送邮件
                    $message_model = new Message_TemplateModel();
                    $pattern = array('/\[weburl_name\]/', '/\[yzm\]/');
                    $replacement = array(Web_ConfigModel ::value("site_name"), $message_info);
                    $message_info = $message_model -> getTemplateInfo(array('code' => 'regist_verify'), $pattern, $replacement);
                    if (!$message_info['is_email']) {
                        $this -> data -> addBody(-140, array(), __('信息内容创建失败'), 250);
                    }
                    $title = '注册验证';
                    $contents = $message_info['content_email'];
                    $result = Email::send($email, '', $title, $contents);
                    if ($result) {
                        $msg = __('发送成功');
                        $status = 200;
                    } else {
                        $msg = __('发送失败');
                        $status = 250;
                    }
                }
            }
        } else {
            $msg = __('数据有误');
            $status = 250;
        }
        $data = array();
        if (DEBUG === false) {
            $data['user_code'] = $check_code;
        }
        return $this -> data -> addBody(-140, $data, $msg, $status);
    }

    /**
     * 解密数据
     *
     * @param type $value
     *
     * @return type
     */
    private function ecryptDecode($value)
    {
        $ECryptModel = new ECrypt();
        $data = $ECryptModel -> decode($value);
        return $data;
    }

    /**
     * wap 第三方登录接口
     *
     * @param  string data 用户信息数组
     * @param
     *
     * @return type
     */
    public function connect()
    {
        //ucenter.local.yuanfeng021.com/?ctl=Login&met=connect&bind_id=wb_4551A53720464EE84FBD83514454EE70&access_token=08FE7CD67F2BA1223BE002BD71877B11&bind_avator=http://q.qlogo.cn/qqapp/1106211603/4551A53720464EE84FBD83514454EE70/100&bind_gender=1&bind_nickname="\U7406\U60f3\U4e09\U65ec"&openid=4551A53720464EE84FBD83514454EE70&type=qq
        //localhost.pcenter.yuanfeng021.com/?ctl=Login&met=connect&bind_id=wb_4551A53720464EE84FBD83514454EE70&access_token=08FE7CD67F2BA1223BE002BD71877B11&bind_avator=http://q.qlogo.cn/qqapp/1106211603/4551A53720464EE84FBD83514454EE70/100&bind_gender=1&bind_nickname="\U7406\U60f3\U4e09\U65ec"&openid=4551A53720464EE84FBD83514454EE70&type=qq
        $bind_id = request_string('bind_id');
        $access_token = request_string('access_token');
        $openid = request_string('openid');
        $bind_avator = request_string('bind_avator');
        $bind_nickname = request_string('bind_nickname');
        $bind_gender = request_int('bind_gender');
        $ty = request_string('type'); //qq,weixin,weibo
        if ($ty == 'qq') {
            $type = User_BindConnectModel::QQ;
        }
        if ($ty == 'weixin') {
            $type = User_BindConnectModel::WEIXIN;
        }
        if ($ty == 'weibo') {
            $type = User_BindConnectModel::SINA_WEIBO;
        }
        /*$data['bind_id'] = $bind_id;
        $data['access_token'] = $access_token;
        $data['bind_nickname'] = $bind_nickname;
        $data['bind_gender'] = $bind_gender;
        $data['bind_gender'] = $ty;
        $data['bind_gender'] = $type;
        return $this->data->addBody(-140,$data);*/
        //判断当前登录账户
        if (Perm ::checkUserPerm()) {
            $user_id = Perm ::$userId;
        } else {
            $user_id = 0;
        }
        $connect_rows = array();
        $User_BindConnectModel = new User_BindConnectModel();
        $connect_rows = $User_BindConnectModel -> getBindConnect($bind_id);
        if ($connect_rows) {
            $connect_row = array_pop($connect_rows);
        }
        //已经绑定,并且用户正确
        if (isset($connect_row['user_id']) && $connect_row['user_id']) {
            //验证通过, 登录成功.
            if ($user_id && $user_id == $connect_row['user_id']) {
                echo '非法请求,已经登录用户不应该访问到此页面';
                return $this -> data -> addBody('非法请求,已经登录用户不应该访问到此页面');
                die();
            }
            $login_flag = true;
        } else {
            // 下面可以需要封装
            $bind_rows = $User_BindConnectModel -> getBindConnect($bind_id);
            if ($bind_rows && $bind_row = array_pop($bind_rows)) {
                if ($bind_row['user_id']) {
                    //该账号已经绑定
                    echo '非法请求,该账号已经绑定';
                    return $this -> data -> addBody('非法请求,该账号已经绑定');
                    die();
                }
                if ($user_id != 0) {
                    $bind_id_row = $User_BindConnectModel -> getBindConnectByuserid($user_id, $type);
                    if ($bind_id_row) {
                        echo '非法请求,该账号已经绑定';
                        return $this -> data -> addBody('非法请求,该账号已经绑定');
                        die();
                    }
                }
                $data_row = array();
                $data_row['user_id'] = $user_id;
                $data_row['bind_token'] = $access_token;
                $connect_flag = true;
                $User_BindConnectModel -> editBindConnect($bind_id, $data_row);
            } else {
                if ($user_id != 0) {
                    $bind_id_row = $User_BindConnectModel -> getBindConnectByuserid($user_id, $type);
                    if ($bind_id_row) {
                        echo '非法请求,该账号已经绑定';
                        return $this -> data -> addBody('非法请求,该账号已经绑定');
                        die();
                    }
                }
                //插入绑定表
                $bind_array = array();
                $bind_array = array(
                    'bind_id' => $bind_id,
                    'bind_type' => $type,
                    'user_id' => $user_id,
                    'bind_nickname' => $bind_nickname,
                    'bind_avator' => $bind_avator,
                    'bind_gender' => $bind_gender,
                    'bind_openid' => $openid,
                    'bind_token' => $access_token,
                );
                $connect_flag = $User_BindConnectModel -> addBindConnect($bind_array);
            }
            //取得open id, 需要封装
            if ($connect_flag) {
                //选择,登录绑定还是新创建账号 $user_id == 0
                if (!Perm ::checkUserPerm()) {
                    $url = sprintf('%s?ctl=Login&met=select&t=%s&type=%s&from=%s&callback=%s', Yf_Registry ::get('url'), $access_token, $type, request_string('from'), urlencode(request_string('callback') ? : $_GET['callbak']));
                    $msg = 'success';
                    $status = 210;
                    $da['url'] = $url;
                    return $this -> data -> addBody(-140, $da, $msg, $status);
                    die;
                } else {
                    $login_flag = true;
                }
            }
        }
        if ($login_flag) {
            //验证通过, 登录成功.
            if ($user_id && $user_id == $connect_row['user_id']) {
                echo '非法请求,已经登录用户不应该访问到此页面';
                return $this -> data -> addBody('非法请求,已经登录用户不应该访问到此页面');
                die;
            } else {
                $User_InfoModel = new User_InfoModel();
                $result = $User_InfoModel -> userlogin($connect_row['user_id']);
                if ($result) {
                    $msg = 'success';
                    $status = 200;
                    return $this -> data -> addBody(-140, $result, $msg, $status);
                } else {
                    return $this -> data -> addBody('登录失败');
                }
            }
        }
    }

    public function del()
    {
        $bind_id = request_string('bind_id');
        $User_BindConnectModel = new User_BindConnectModel();
        $flag = $User_BindConnectModel -> removeBindConnect($bind_id);
        if ($flag) {
            $msg = 'success';
            $status = 200;
            return $this -> data -> addBody(-140, array(), $msg, $status);
        } else {
            return $this -> data -> addBody('失败');
        }
    }

    /**
     * app发送短信验证码
     * 找回密码
     *
     * @return type
     */
    public function appPhoneCode()
    {
        $app_token = urldecode($_REQUEST['app_token']);
        $request_data = $this -> ecryptDecode($app_token);
        $mobile = $request_data['mobile'];
        $data = array();
        if (!Perm ::checkAppYzm($request_data['verify_code'], $request_data['verify_key'])) {
            return $this -> data -> addBody(-140, $data, __('验证失败'), 250);
        }
        //判断用户是否存在  $mobile
        $User_InfoDetail = new User_InfoDetailModel();
        $checkMobile = $User_InfoDetail -> isUserMobile($mobile);
        if (!$checkMobile) {
            return $this -> data -> addBody(-140, $data, __('请填写注册或绑定的手机号'), 250);
        }
        $check_code = mt_rand(100000, 999999);
        if ($mobile && Yf_Utils_String ::isMobile($mobile)) {
            //缓存数据
            $save_result = $this -> _saveCodeCache($mobile, $check_code, 'verify_code');
            if (!$save_result) {
                $msg = __('发送失败');
                $status = 250;
            } else {
                //发送短消息
                $contents = '您的验证码是：' . $check_code . '。请不要把验证码泄露给其他人。如非本人操作，可不用理会！';
                $result = Sms ::send($mobile, $contents);
                $msg = $result ? __('发送成功') : __('发送失败');
                $status = $result ? 200 : 250;
            }
        } else {
            $msg = __('手机号码有误');
            $status = 250;
        }
        if (DEBUG === false) {
            $data['user_code'] = $check_code;
        }
        return $this -> data -> addBody(-140, $data, $msg, $status);
    }

    public function getMobileYzm()
    {
        $mobile = request_string('mobile');
        $cond_row['code'] = request_string('type') == 'passwd' ? 'edit_passwd' : 'verification';
        $yzm = request_string('yzm');
        if (!Perm ::checkYzm($yzm)) {
            return $this -> data -> addBody(-140, array(), _('图形验证码有误'), 250);
        }
        $Message_TemplateModel = new Message_TemplateModel();
        $de = $Message_TemplateModel -> getTemplateDetail($cond_row);
        $me = $de['content_phone'];
        $code_key = $mobile;
        $code = VerifyCode ::getCode($code_key);
        $me = str_replace("[weburl_name]", $this -> web['web_name'], $me);
        $me = str_replace("[yzm]", $code, $me);
        $str = Sms::send($mobile, $me);
        $status = $str ? 200 : 250;
        $msg = $str ? _('发送成功') : _('发送失败');
        $data = array();
        if (DEBUG === false) {
            $data['user_code'] = $code;
        }
        return $this -> data -> addBody(-140, $data, $msg, $status);
    }

    public function checkMobileYzm()
    {
        $yzm = request_string('yzm');
        $mobile = request_string('mobile');
        if (VerifyCode ::checkCode($mobile, $yzm)) {
            $status = 200;
            $msg = _('success');
        } else {
            $msg = _('failure');
            $status = 250;
        }
        $data = array();
        $this -> data -> addBody(-140, $data, $msg, $status);
    }

    public function editMobileInfo()
    {
        $user_name = request_string('user_name');
        $user_pwd = request_string('user_pwd');
        $userModel = new User_InfoModel();
        //通过用户名和用户密码查找用户
        $cond['user_name'] = $user_name;
        $cond['password'] = md5($user_pwd);
        $user = $userModel -> getByWhere($cond);
        if ($user) {
            $user = current($user);
            $user_id = $user['user_id'];
        } else {
            return $this -> data -> addBody(-140, array(), __('用户信息有误'), 250);
        }
        //检查用户信息
        $cond_user['user_id'] = $user_id;
        $user_info_row = $userModel -> getOne($cond_user);
        if (!$user_info_row) {
            $data['code'] = 3;
            return $this -> data -> addBody(-140, $data, __('用户信息有误'), 250);
        }
        $user_name = $user_info_row['user_name'];
        $rs_row = array();
        $user_mobile = request_string('user_mobile');
        $yzm = request_string('yzm', request_string('auth_code'));
        $data = array();
        if (!VerifyCode ::checkCode($user_mobile, $yzm)) {
            $data['code'] = 1;
            return $this -> data -> addBody(-140, $data, __('验证码错误'), 250);
        }
        //检查手机号是否被使用
        $userInfoDetailModel = new User_InfoDetail();
        $check_user_name = $userInfoDetailModel -> checkUserName($user_mobile, $user_id);
        if ($check_user_name) {
            $data['code'] = 2;
            return $this -> data -> addBody(-140, $data, __('该手机已经被使用'), 250);
        }
        //查找bind绑定表
        $new_bind_id = sprintf('mobile_%s', $user_mobile);
        $User_BindConnectModel = new User_BindConnectModel();
        $bind_info = $User_BindConnectModel -> getOne($new_bind_id);
        if (isset($bind_info['user_id']) && $bind_info['user_id'] != $user_id) {
            $data['code'] = 4;
            return $this -> data -> addBody(-140, $data, __('该手机已经被使用'), 250);
        }
        //开启事务
        $User_InfoDetailModel = new User_InfoDetailModel();
        $User_InfoDetailModel -> sql -> startTransactionDb();
        //查找该用户之前是否已经绑定手机号，如果有的话需要删除
        $user_mobile_bind = $User_BindConnectModel -> getByWhere(array('user_id' => $user_id, 'bind_type' => $User_BindConnectModel ::MOBILE));
        if ($user_mobile_bind) {
            $old_bind_id_row = array_keys($user_mobile_bind);
            //将之前用户绑定的手机号删除
            $flag_remove = $User_BindConnectModel -> removeBindConnect($old_bind_id_row);
            check_rs($flag_remove, $rs_row);
        }
        //该手机号可用，将手机号写入用户详情表中，验证状态为已验证
        if ($user_name) {
            $edit_user_row['user_mobile'] = $user_mobile;
            $edit_user_row['user_mobile_verify'] = 1;
            $flag_edit = $User_InfoDetailModel -> editInfoDetail($user_name, $edit_user_row);
            check_rs($flag_edit, $rs_row);
        } else {
            $flag_edit = true;
        }
        if ($flag_edit === false) {
            $User_InfoDetailModel -> sql -> rollBackDb();
            $data['code'] = 5;
            return $this -> data -> addBody(-140, $data, __('绑定失败'), 250);
        }
        //用户信息表中的手机号修改完成后，修改绑定表中的数据
        //添加mobile绑定.
        //绑定标记：mobile/email/openid  绑定类型+openid
        //插入绑定表
        if (isset($bind_info['user_id']) && $bind_info['user_id'] == $user_id) {
            check_rs(true, $rs_row);
        } else {
            $time = date('Y-m-d H:i:s', time());
            $bind_array = array('bind_id' => $new_bind_id, 'user_id' => $user_id, 'bind_type' => $User_BindConnectModel ::MOBILE, 'bind_time' => $time);
            $flag_add = $User_BindConnectModel -> addBindConnect($bind_array);
            if ($flag_add) {
                //将用户原来绑定的手机号删除
                $bind_id = sprintf('mobile_%s', $user_info_row['user_mobile']);
                $flag_del = $User_BindConnectModel -> removeBindConnect($bind_id);
                check_rs($flag_del, $rs_row);
            }
        }
        $flag = is_ok($rs_row);
        $User_InfoDetailModel -> sync($user_id);
        if ($flag && $User_InfoDetailModel -> sql -> commitDb()) {
            $status = 200;
            $msg = __('操作成功');
        } else {
            $User_InfoDetailModel -> sql -> rollBackDb();
            $msg = __('操作失败');
            $status = 250;
        }
        return $this -> data -> addBody(-140, $data, $msg, $status);
    }

    /**** IM 调用的接口-S  *****/
    //im登录接口
    public function ImLogin()
    {
        $user_name = strtolower($_REQUEST['user_account']);
        if (!$user_name) {
            $user_name = strtolower($_REQUEST['user_name']);
        }
        $password = $_REQUEST['user_password'];
        if (!$password) {
            $password = $_REQUEST['password'];
        }
        if (!strlen($user_name)) {
            $this -> data -> setError('请输入账号');
        }
        if (!strlen($password)) {
            $this -> data -> setError('请输入密码');
        }
        $User_BindConnectModel = new User_BindConnectModel();
        $User_InfoModel = new User_InfoModel();
        $User_InfoDetailModel = new User_InfoDetailModel();
        //查找绑定表中是否存在此用户
        $bind_id = '';
        $user_info_row = array();
        //绑定标记：mobile/email/openid  绑定类型+openid
        {
            if (filter_var($user_name, FILTER_VALIDATE_EMAIL)) {
                //邮件登录
                $bind_id = sprintf('email_%s', $user_name);
            } elseif (Yf_Utils_String ::isMobile($user_name)) {
                //手机号码登录
                $bind_id = sprintf('mobile_%s', $user_name);
            }
            if ($bind_id) {
                //查找bind绑定表
                $User_BindConnectModel = new User_BindConnectModel();
                $bind_info = $User_BindConnectModel -> getOne($bind_id);
                if ($bind_info) {
                    //用户名登录
                    $user_info_row = $User_InfoModel -> getOne($bind_info['user_id']);
                    $user_info_detail = $User_InfoDetailModel -> getOne($user_info_row['user_name']);
                    $user_info_row = $user_info_row + $user_info_detail;
                }
            }
            if ($user_info_row) {
            } else {
                //用户名登录
                $user_info_row = $User_InfoModel -> getInfoByName($user_name);
                $user_info_detail = $User_InfoDetailModel -> getOne($user_name);
                $user_info_row = $user_info_row + $user_info_detail;
            }
        }
        if (!$user_info_row) {
            $this -> data -> setError('账号不存在');
        } else {
            if (md5($password) != $user_info_row['password'] && $password != $user_info_row['password']) {
                $this -> data -> setError('密码错误');
            } else {
                if (3 == $user_info_row['user_state']) {
                    $this -> data -> setError('用户已经锁定,禁止登录!');
                    return false;
                }
                $session_id = $user_info_row['session_id'];
                $arr_field = array();
                $arr_field['session_id'] = $session_id;
                if (true) {
                    $arr_body = $user_info_row;
                    $arr_body['result'] = 1;
                    $data = array();
                    $data['user_id'] = $user_info_row['user_id'];
                    $encrypt_str = Perm ::encryptUserInfo($data, $session_id);
                    $arr_body['k'] = $encrypt_str;
                    $this -> data -> addBody(100, $arr_body);
                } else {
                    $this -> data -> setError('登录失败');
                }
            }
        }
        if (isset($_REQUEST['callback']) && $_REQUEST['callback']) {
            header("Location:" . urldecode($_REQUEST['callback']));
        }
    }

    /**** IM 调用的接口-E  *****/
    public function test()
    {
        $verify_key = '18667108609';
        $code = 123123123;
        $res = $this -> _saveCodeCache($verify_key, $code, $group = 'default');
        var_dump($res);
        $config_cache = Yf_Registry ::get('config_cache');
        $Cache_Lite = new Cache_Lite_Output($config_cache['default']);
        $user_code = $Cache_Lite -> get($verify_key);
        echo $user_code;
    }
}

?>
