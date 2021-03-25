<html class="root61">
<?php
$re_url = '';
$re_url = Yf_Registry::get('re_url');

$from = '';
$callback = $re_url;
$t = '';
$code = '';


// 获取微信分享跳转之后的uu account
$uu_account_wx = @$_GET["u_account"];
session_start();
if ($uu_account_wx) {
    $_SESSION['uu_account_wx'] = $uu_account_wx;//直销会员编号
}
// 获取微信分享跳转之后的uu account
$uu_member_id_wx = @$_GET["MemberID"];
if ($uu_member_id_wx) {
    $_SESSION['uu_member_id_wx'] = $uu_member_id_wx;//直销会员编号
}
extract($_GET);
// if(Web_ConfigModel::value('register')==2)
// {
    // $url = sprintf('%s?ctl=Login&act=activat&t=%s&from=%s&callback=%s', Yf_Registry::get('url'), request_string('t'), request_string('from'), urlencode(request_string('callback')));
    // var_dump(Yf_Registry::get('url'));die;
    // header("location:$url");
    // die;
// }
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-touch-fullscreen" content="yes" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="msapplication-tap-highlight" content="no" />
    <meta name="viewport" content="initial-scale=1,maximum-scale=1,minimum-scale=1" />
    <meta name="referrer" content="no-referrer"/>
    <title>会员注册</title>
    <link rel="stylesheet" href="<?=$this->view->css?>/register.css">
    <link rel="stylesheet" href="<?=$this->view->css?>/base.css">
    <link rel="stylesheet" href="<?=$this->view->css?>/tips.css">
    <link rel="stylesheet" type="text/css" href="<?= $this->view->css ?>/headfoot.css" />
    <link rel="stylesheet" type="text/css" href="<?= $this->view->css ?>/old_member.css" />
    <script src="<?=$this->view->js?>/jquery-1.9.1.js"></script>
    <script src="<?=$this->view->js?>/respond.js"></script>
    <script src="<?=$this->view->js?>/regist.js"></script>
    <script src="<?=$this->view->js?>/base64.js"></script>
    <script src="<?=$this->view->js?>/jqueryCitySelect.js"></script>

</head>
<style>

.field{
    background-color: white;
} 

    .timeSelectBox1 {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        bottom:0;
        width: 100vw;
        /*    height: 100%;*/
        background-color: #00000030;
        text-align: center;
        z-index: 999999;
    }
    .TeStSnContent>p {
    margin: 0;
    height: 50px;
    line-height: 50px;
}
        .TeStSon1{
        display: block;
        width: 40%;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        -webkit-transform: translate(-50%, -50%);
    }
    .TeStSon1>p{
        height: 45px;
        line-height: 45px;
        text-align: left;
        padding-left: 20px;
        font-size: 16px;
        background: #eee;
        margin:0;
        padding-left: 5%;
    }
.loading-indicator {
    color: #444;
    font: bold 20px tahoma,arial,helvetica;
    height: auto;
    margin: 0;
    padding: 10px;
    text-align: center;
}
.loading-msg {
    color: #fff;
    display: block;
    font-size: 18px;
    font-weight: normal;
    margin-top: 20px;
}

</style>
<body>
<!-- 遮罩层开启 -->
<div id="mask_box" class="timeSelectBox1" >
    <div class="loading-indicator">
    <div class="TeStSon1" style="    height: auto;">
        <div class="TeStSnContent TeStSnUd">
            <img style="    width: 80px;" src="ucenter\static\default\images\quan.jpg" alt="">
            <p style="color: #007673;">正在注册</p>
        </div>
    </div>
    </div>
</div>
<!-- 遮罩层结束 -->
<div class="appRegister" >

    <div id="form-header" class="header">
        <div class="logo-con w clearfix">
            <a href="<?=$shop_url?>" class="index_logo">
                <img src="<?= $web['site_logo'] ?>" alt="logo" height="60">
            </a>
            <div class="logo-title">上传身份证照片</div>
        </div>
    </div>
<div class="appStCont container">
    <!-- 上传身份证照片 -->
    <div id="header"><a href="javascript:history.go(-1)" class="back-pre"></a>上传身份证照片</div>
    <div class="main clearfix" id="form-main">
        <div class="reg-form fl">
            <form action="" id="register-form" method="post" novalidate="novalidate"  onsubmit="return false;">
              
                <div id="form-item" class="form-item" style="z-index: 12;">
                    <!-- <label>上传身份证照片正面</label>
                    <input type="file" id="images" class="field re_user_password" autocomplete="off" maxlength="20" placeholder="" default="<i class=i-def></i><?=$pwd_str?>" name="images"> -->
                  
                    <!-- <i class="i-status"></i> -->
                    <div class="IdentityBox Idy_b">
                        <p class="Identity_p">请上传本人身份证<span>正面</span>照片</p>
                        <div class="froutIdentity" id="froutIdentity">
                            <img id='yulan' src="ucenter\static\default\images\login_01\identity_03.png">
                            <p>上传人像页照片</p>
                            <input type="hidden" value="" id="user_froutIdentity" class="identityIt"  name="images">
                        </div>
                    </div>
                </div>
                <div class="IyStandard">
                    <div class="IySdTop">
                        <p class="IySdTopL">请拍摄身份证原件：</p>
                        <p class="IySdTopR"><i></i>上传证件照片要求</p>
                    </div>
                    <ul class="IySdConter">
                        <li>
                            <img src="ucenter\static\default\images\login_01\identity_13.png">
                            <p class="correct_p"><i></i>标准</p>
                        </li>
                        <li>
                            <img src="ucenter\static\default\images\login_01\identity_15.png">
                            <p class="error_p"><i></i>边框缺失</p>
                        </li>
                        <li>
                            <img src="ucenter\static\default\images\login_01\identity_17.png">
                            <p class="error_p"><i></i>照片模糊</p>
                        </li>
                        <li>
                            <img src="ucenter\static\default\images\login_01\identity_19.png">
                            <p class="error_p"><i></i>闪光强烈</p>
                        </li>
                    </ul>

                </div>

                <div>
                    <!-- <button type="submit" class="btn-register IyUploadingBn" onclick="AppNextStep(1)">下一步</button> -->
                    <button type="submit" class="btn-register IyUploadingBn" onclick="identityFront()">下一步</button>
                </div>

            </form>
        </div>
    </div>

 <!--    <input type="hidden" name="callback" class="callback" value="<?php echo urlencode($callback); ?>">
    <input type="hidden" name="t" class="token" value="<?php echo $t; ?>">
    <input type="hidden" name="code" class="code" value="<?php echo $code; ?>">
    <input type="hidden" name="re_url" class="re_url" value="<?php echo $re_url; ?>">
    <div class="main clearfix" id="form-main">
        <div class="reg-form fl">
            <form action="" id="register-form" method="post" novalidate="novalidate"  onsubmit="return false;">
              

                <div id="form-item" class="form-item" style="z-index: 12;">
                    <label>上传身份证照片正面</label>
                    <input type="file" id="images" class="field re_user_password" autocomplete="off" maxlength="20" placeholder="建议至少使用两种字符组合" default="<i class=i-def></i><?=$pwd_str?>" name="images">
                  
                    <i class="i-status"></i>
                    
                </div>
                <div id="form-item" class="form-item" style="z-index: 12;">
                    <label>上传身份证照片负面</label>
                    <input type="file" id="images1" class="field re_user_password" autocomplete="off" maxlength="20" placeholder="建议至少使用两种字符组合" default="<i class=i-def></i><?=$pwd_str?>" name="images1">
                  
                    <i class="i-status"></i>
                    
                </div>

                <div class="input-tip">
                    <span></span>
                </div>

                <div>
                    <button type="submit" class="btn-register" onclick="imgClick()">下一步</button>
                </div>

            </form>
        </div> -->

    </div>

    <!-- 反面 -->
    <div class="appStCont container_b">
        <!-- 上传身份证照片 -->
        <div id="header"><a href="javascript:history.go(-1)" class="back-pre"></a>上传身份证照片</div>
        <div class="main clearfix" id="form-main1">
            <div class="reg-form fl">
                <form action="" id="register-form-reverse" method="post" novalidate="novalidate"  onsubmit="return false;">
                  
                    <div id="forminp" style="display: none;"></div>
                    <div id="form-item" class="form-item" style="z-index: 12;">
                       <!--  <label>上传身份证照片正面</label>
                        <input type="file" id="images" class="field re_user_password" autocomplete="off" maxlength="20" placeholder="" default="<i class=i-def></i><?=$pwd_str?>" name="images"> -->
                      
                        <!-- <i class="i-status"></i> -->
                        <div class="IdentityBox">
                            <p class="Identity_p">请上传本人身份证<span>背面</span>照片</p>
                            <!-- <div class="froutIdentity">
                                <img src="ucenter\static\default\images\login_01\identity_03.png">
                                <p>上传人像页照片</p>
                                <input type="file" id="images" class="field re_user_password identityIt" autocomplete="off" maxlength="20" placeholder="" default="<i class=i-def></i><?=$pwd_str?>" name="images">
                            </div> -->

                            <div id="reverseIdentity" class="froutIdentity reverseIdentity contraryIcon">
                                <img id="yulan2" src="ucenter\static\default\images\login_01\identity_06.png">
                                <p>上传国徽页照片</p>
                                <input type="hidden" id="images1" value="" class="field re_user_password identityIt" name="images1">
                            </div>
                        </div>
                        
                    </div>
                    <div class="IyStandard">
                        <div class="IySdTop">
                            <p class="IySdTopL">请拍摄身份证原件：</p>
                            <p class="IySdTopR"><i></i>上传证件照片要求</p>
                        </div>
                        <ul class="IySdConter">
                            <li>
                                <img src="ucenter\static\default\images\login_01\identity_13.png">
                                <p class="correct_p"><i></i>标准</p>
                            </li>
                            <li>
                                <img src="ucenter\static\default\images\login_01\identity_15.png">
                                <p class="error_p"><i></i>边框缺失</p>
                            </li>
                            <li>
                                <img src="ucenter\static\default\images\login_01\identity_17.png">
                                <p class="error_p"><i></i>照片模糊</p>
                            </li>
                            <li>
                                <img src="ucenter\static\default\images\login_01\identity_19.png">
                                <p class="error_p"><i></i>闪光强烈</p>
                            </li>
                        </ul>

                    </div>

                    <div>
                        <!-- <button type="submit" class="btn-register IyUploadingBn" onclick="AppNextStep(2)">确认上传</button> -->
                        <button type="submit" class="btn-register IyUploadingBn" onclick="imgClick()">确认上传</button>
                    </div>

                </form>
            </div>
        </div>
    </div>




<!-- 新会员注册 -->
<div class="appStCont recruitBox">
    <div id="header"><a href="javascript:history.go(-1)" class="back-pre"></a>新会员注册</div>

    <div class="portraitIcon tc">
        <img src="ucenter/static/default/images/login_01/login_03.png" alt="">
    </div>

    <div class="main clearfix" id="form-main2">
        <div class="reg-form fl" id="reg-form1">
<!--            <form action="" id="register-form1" class="ItRegister" method="post" novalidate="novalidate"  onsubmit="return false;">-->
            <form action="" id="register-form11" class="ItRegister" method="post" novalidate="novalidate"  onsubmit="return false;">
                <div id="form-item-password" class="form-item" style="z-index: 12;">
                    <!-- <label>辅导员编号：</label> -->
                    <i class="instructorIcon"></i>
                    <input type="text" id="par_member" class="field re_user_password" autocomplete="off" maxlength="7" placeholder="辅导员编号" onchange="instruClick()">
                     <!-- <i class="scanIcon"></i> -->
                </div>
                <div class="input-tip">
                    <span></span>
                </div>
                <div id="form-item-password" class="form-item" style="z-index: 12;">
                    <!-- <label>辅导员姓名：</label> -->
                    <i class="instructorNuam"></i>
                    <input type="text" id="par_name" value="" class="field re_user_password" autocomplete="off" maxlength="30" placeholder="辅导员姓名" default="<i class=i-def></i><?=$pwd_str?>" disabled="disabled">
                </div>
                 <div class="input-tip">
                    <span></span>
                </div>
               <!--  <div class="input-tip">                    <input type="text" id="par_name" class="field re_user_password" autocomplete="off" maxlength="20" placeholder="辅导员姓名" default="<i class=i-def></i><?=$pwd_str?>">

                    <span></span>
                </div> -->
                <div id="form-item-password" class="form-item" style="z-index: 12;">
                    <!-- <label>身份证号码：</label> -->
                    <i class="IdCardNum"></i>
                    <input type="text" id="user_idcard" class="field re_user_password" autocomplete="off" maxlength="18" placeholder="身份证号码" default="<i class=i-def></i><?=$pwd_str?>" disabled="disabled">
                </div>
                <div class="input-tip">
                    <span></span>
                </div>
                <div id="form-item-password" class="form-item" style="z-index: 12;">
                    <!-- <label>会员姓名：</label> -->
                    <i class="memberNume"></i>
                    <input type="text" id="user_name" class="field re_user_password" autocomplete="off" maxlength="30" placeholder="会员姓名" default="<i class=i-def></i><?=$pwd_str?>" disabled="disabled">
                </div>
                <div class="input-tip">
                    <span></span>
                </div>
                <div id="form-item-password" class="form-item" style="z-index: 12;">
                    <!-- <label>会员性别：</label> -->
                    <i class="memberGender "></i>
                    <input type="text" id="user_gender" class="field re_user_password" autocomplete="off" maxlength="16" placeholder="会员性别" default="<i class=i-def></i><?=$pwd_str?>" disabled="disabled">
                </div>
                <div class="input-tip">
                    <span></span>
                </div>
                <div id="form-item-password" class="form-item" style="z-index: 12;">
                    <!-- <label>出生年月：</label> -->
                    <i class="dateOfBirth"></i>
                    <input type="text" id="user_birth" class="field re_user_password" autocomplete="off" maxlength="16" placeholder="出生年月" default="<i class=i-def></i><?=$pwd_str?>" disabled="disabled">
                </div>
                <div class="input-tip">
                    <span></span>
                </div>
               <div id="form-item-password" class="form-item" style="z-index: 12;">
                    <!-- <label>户籍地址：</label> -->
                    <i class="site"></i>
                    <input type="text" id="user_address" class="field re_user_password" autocomplete="off" maxlength="100" placeholder="户籍地址" >
                </div>
                <div class="input-tip">
                    <span></span>
                </div>
                <!-- <div id="form-item-password" class="form-item" style="z-index: 12;"> -->
                    <!-- <label>会员手机：</label> -->
                <!--     <i class="mobileMember"></i>
                    <input type="text" id="user_mobile" class="field re_user_password" autocomplete="off" maxlength="20" placeholder="建议使用常用手机" default="<i class=&quot;i-def&quot;></i>完成验证后，可以使用该手机登录和找回密码" onblur="checkMobile()" onfocus="showTip(this)">
                    <i class="i-status"></i>
                </div>
                <div class="input-tip">
                    <span></span>
                </div>
                <div class="Mobile_div" style="">
                    <div class="form-item form-item-mobile" id="form-item-mobile">
                        <div class="form-item form-item-phonecode"> -->
                        <!-- <label><em class="must">*</em>手机验证码：</label> -->
                <!--         <i class="identifyingCode"></i>
                        <input type="text" name="mobileCode" maxlength="6" id="phoneCode" class="field phonecode  re_mobile" placeholder="请输入手机验证码">
                        <button id="getPhoneCode" class="btn-phonecode" type="button" onclick="get_randcode_phone()">获取验证码</button>
                        <i class="i-status"></i>
                        </div>
                    </div>
                </div>
                 <div class="input-tip">
                    <span></span>
                </div>
                <div id="form-item-password" class="form-item" style="z-index: 12;"> -->
                    <!-- <label>会员邮箱：</label> -->
                 <!--    <i class="eml"></i>
                    <input type="text" id="user_email" class="field re_user_password" autocomplete="off" maxlength="20" placeholder="会员邮箱" default="<i class=&quot;i-def&quot;></i>建议使用常用邮箱地址" onblur="checkEmail()" onfocus="showTip(this)">
                </div>
                <div class="input-tip">
                    <span></span>
                </div> -->
            </form>
            </div>
                <!-- <div id="form-item-password" class="form-item" style="z-index: 12;">
                    <label>会员手机：</label>
                    <input type="text" id="user_mobile" class="field re_user_password" autocomplete="off" maxlength="20" placeholder="建议使用常用手机" default="<i class=&quot;i-def&quot;></i>完成验证后，可以使用该手机登录和找回密码" onblur="checkMobile()" onfocus="showTip(this)">
                    <i class="i-status"></i>
                </div>
                <div class="input-tip">
                    <span></span>
                </div>
                <div class="Mobile_div" style="">
                    <div class="form-item form-item-mobile" id="form-item-mobile">
                        <div class="form-item form-item-phonecode">
                        <label><em class="must">*</em>手机验证码：</label>
                        <input type="text" name="mobileCode" maxlength="6" id="phoneCode" class="field phonecode  re_mobile" placeholder="请输入手机验证码">
                        <button id="getPhoneCode" class="btn-phonecode" type="button" onclick="get_randcode_phone()">获取验证码</button>
                        <i class="i-status"></i>
                    </div>
                </div> -->
               <!--  <div id="form-item-password" class="form-item" style="z-index: 12;">
                    <label>会员邮箱：</label>
                    <input type="text" id="user_email" class="field re_user_password" autocomplete="off" maxlength="20" placeholder="会员邮箱" default="<i class=i-def></i><?=$pwd_str?>">
                </div>
                <div class="input-tip">
                    <span></span>
                </div> -->
                <div class="register_A">
                    <!-- <button type="submit" class="btn-register" onclick="AppNextStep(3)">下一步</button> -->
                    <button type="submit" class="btn-register" onclick="regClick()">下一步</button>
                </div>

     
        </div>
    </div>


<!-- 新会员注册 app 下一步-->
<div class="appStCont recruitBox_b">
    <div id="header"><a href="javascript:history.go(-1)" class="back-pre"></a>新会员注册</div>

    <div class="portraitIcon">
        <img src="ucenter/static/default/images/login_01/login_03.png" alt="">
    </div>

    <div class="main clearfix" id="form-main2">
        <div class="reg-form fl" id="reg-form1">
            <form action="" id="register-form1" class="ItRegister" method="post" novalidate="novalidate"  onsubmit="return false;">
                
                <div id="form-item-password" class="form-item" style="z-index: 12;">
                    <!-- <label>会员手机：</label> -->
                    <i class="mobileMember"></i>
                    <input type="text" id="user_mobile" class="field re_user_password" autocomplete="off" maxlength="11" placeholder="建议使用常用手机" default="<i class=&quot;i-def&quot;></i>完成验证后，可以使用该手机登录和找回密码" onblur="checkMobile()" onfocus="showTip(this)">
                    <i class="i-status"></i>
                </div>
                <div class="input-tip">
                    <span></span>
                </div>
                <div class="Mobile_div" style="">
                    <div class="form-item form-item-mobile" id="form-item-mobile">
                        <div class="form-item form-item-phonecode">
                        <!-- <label><em class="must">*</em>手机验证码：</label> -->
                        <i class="identifyingCode"></i>
                        <input type="text" name="mobileCode" maxlength="6" id="phoneCode" onblur="checkRcode()" class="field phonecode  re_mobile" placeholder="请输入手机验证码">
                        <button style="color: #fff;border-radius: 10px;height: 30px;font-size: 11px;display: inherit;margin: auto;background-color: #007673;" style="height: 30px;font-size: 11px;" id="getPhoneCode" class="btn-phonecode" type="button" onclick="get_randcode_phone()">获取验证码</button>
                        <i class="i-status"></i>
                        </div>
                    </div>
                </div>
                 <div class="input-tip">
                    <span></span>
                </div>
                <div id="form-item-password" class="form-item" style="z-index: 12;">
                    <!-- <label>会员邮箱：</label> -->
                    <i class="eml"></i>
                    <input type="text" id="user_email" class="field re_user_password" autocomplete="off" maxlength="30" placeholder="会员邮箱" default="<i class=i-def></i><?=$pwd_str?>" onblur="checkEmail()" onfocus="showTip(this)">
                </div>
                <div class="input-tip">
                    <span></span>
                </div>
            </form>
            </div>
                <input type="hidden" name="regstep" id="regstep1" class="from" value="1">
                   <div class="register_A">
                    <!-- <button type="submit" class="btn-register" onclick="AppNextStep(4)">下一步</button> -->
                    <button type="submit" class="btn-register" onclick="reg1Click()">下一步</button>
                </div>
        </div>
    </div>


    <div class="appStCont membership">
        <div id="header"><a href="javascript:history.go(-1)" class="back-pre"></a>优惠顾客资料</div>
        <div class="main clearfix" id="form-main3">
            <div class="reg-form fl">
                <form action="" id="register-form2" method="post" novalidate="novalidate"  onsubmit="return false;">
                    
                  <div id="form-item1" class="form-item" style="z-index: 12;">
                    <div class="UpBankCard"> 
                        
                        <p><i class="PhotographCion"></i>拍照上传银行卡照片</p>
                        <!-- <input type="file" id="bankimg" class="field re_user_password" autocomplete="off" maxlength="20" placeholder="" default="<i class=i-def></i><?=$pwd_str?>" name="bankimg" onchange="bankImg()">
                        <i class="BankCardIcon"></i> -->

                        <div class="BankCardIcon1" id="userbankimg" style="width: 240px;height: 151px!important;">
                            <img id='bankimages' src="ucenter/static/default/images/login_01/bankCard_07.png" width="240" height="151">
                            <input type="hidden" value="" id="bankimg" class=""  name="images">
                        </div>
                    </div>
                    </div>
                    
                   
                    <div id="form-item-password" class="form-item" style="z-index: 12;">
                        <label>银行卡号</label>
                        <input type="text" id="bankaccount" class="field re_user_password" maxlength="21" placeholder="银行卡号" default="<i class=i-def></i><?=$pwd_str?>" disabled="disabled">
                    </div>
                    <div class="input-tip">
                        <span></span>
                    </div>
                    <div id="form-item-password" class="form-item" style="z-index: 12;">
                        <label>银行类别</label>
                        <select id="bankno" class="field re_user_password">
                            <option value="">请选择</option>
                            <option value="102">中国工商银行</option>
                            <option value="103">中国农业银行</option>
                            <option value="301">交通银行</option>
                        </select>
                        <!-- <input type="number" id="bankno" class="field re_user_password" autocomplete="off" maxlength="20" placeholder="银行类别" default="<i class=i-def></i><?=$pwd_str?>"> -->
                    </div>
                    <div class="input-tip">
                        <span></span>
                    </div>
                    <div id="form-item-password" class="form-item" style="z-index: 12;">
                        <label>银行支行名称</label>
                        <input type="texttext" id="banksubranch" class="field re_user_password" autocomplete="off" maxlength="50" placeholder="银行支行名称" default="<i class=i-def></i><?=$pwd_str?>">
                    </div>
                    <div class="input-tip">
                        <span></span>
                    </div>
                    <div id="form-item-password" class="form-item" style="z-index: 12;">
                        <label>银行分行</label>
                        <input type="text" id="bankbranch" class="field re_user_password" autocomplete="off" maxlength="50" placeholder="银行分行" default="<i class=i-def></i><?=$pwd_str?>" >
                    </div>
                    <div class="input-tip">
                        <span></span>
                    </div>
                    <div id="form-item-password" class="form-item" style="z-index: 12;">
                        <label>开户行所在省</label>
                         <select id="province" class="field re_user_password">
                        <option value="载入中">载入中</option>
                         </select>
                        <!-- <input type="text" id="bankprovince" class="field re_user_password" autocomplete="off" maxlength="20" placeholder="开户行所在省" default="<i class=i-def></i><?=$pwd_str?>" > -->
                    </div>
                    <div class="input-tip">
                        <span></span>
                    </div>
                    <div id="form-item-password" class="form-item" style="z-index: 12;">
                        <label>开户行所在市</label>
                         <select id="city" class="field re_user_password">
                        <option value="载入中">载入中</option>
                         </select>
                        <!-- <input type="text" id="bankcity" class="field re_user_password" autocomplete="off" maxlength="20" placeholder="开户行所在市" default="<i class=i-def></i><?=$pwd_str?>" > -->
                    </div>

                        
                    <div class="input-tip">
                        <span class="radioBox"><input type="checkbox" class="input_check" id="check" checked>
                            <label for="check"></label>
                            <p class="LookThat">我以同意<span>尚赫</span>优惠顾客规章</span></p>
                    </div>
                </form>

                <input type="hidden" name="regstep" id="regstep2" class="from" value="2">
                <div class="register_B">
                    <!-- <button type="submit" class="btn-register" onclick="AppNextStep(5)">下一步</button> -->
                    <button type="submit" class="btn-register" onclick="reg2Click()">下一步</button>
                </div>
            </div>
        </div>
    </div>

    <div class="appStCont setPassword">
        <div id="header"><a href="javascript:history.go(-1)" class="back-pre"></a>设置密码</div>
        <div class="main clearfix" id="form-main4">
            <div class="reg-form fl">
                <form action="" id="register-form3" method="post" novalidate="novalidate"  onsubmit="return false;">
                    <div class="pas">
                        <div id="form-item-password" class="form-item" style="z-index: 12;">
                            <label><em class="must">*</em>新 密 码</label>
                            <span class="close-btn js_clear_btn clear-icon"></span>
                            <input type="password" id="re_user_password" class="field re_user_password" maxlength="16" placeholder="6-16位字母数字区分大小写" default="<i class=i-def></i><?= $pwd_str ?>" onfocus="checkPwd()" onblur="pwdCallback()">
                            <span class="clear-btn eye-icon"></span>
                            <i class="i-status"></i>
                        </div>
                        <div class="input-tip">
                            <span></span>
                        </div>

                    </div>
                    
                    <div id="form-item-rpassword" class="form-item pas">
                        <label>确 认 密 码</label>

                        <span class="close-btn js_clear_btn clear-icon"></span>
                        <input type="password" name="form-equalTopwd" id="form_equalTopwd" class="field" placeholder="请再次填写密码" maxlength="16" default="<i class=&quot;i-def&quot;></i>请再次输密码" onblur="checkRpwd()" onfocus="showTip(this)">

                        <span class="clear-btn eye-icon"></span>
                        <i class="i-status"></i>
                    </div>
                    <div class="input-tip">
                        <span></span>
                    </div>
                    <div class="register_B">
                        <!-- <button type="submit" class="btn-register" onclick="AppNextStep(6)">确认</button> -->
                        <button type="submit" class="btn-register" onclick="reg3Click()">确认</button>
                    </div>

                </form>
            </div>
        </div>
    </div>


    <div class="appStCont registerSucceed">
        <div id="header"><a href="javascript:history.go(-1)" class="back-pre"></a>申请成功</div>
        <div class="main clearfix" id="form-main5">
            <div class="reg-form fl">
                <form action="" id="register-form4" method="post" novalidate="novalidate"  onsubmit="return false;">
                    <div class="informationBox">
                        <h3><i></i>恭喜完成资料验证!</h3>
                        <br><br>
                        <div class="inNameBox">
                            <p class="InNume">您的会员编号是：<span class="member_id" id="member_id">4553355<span></p>
                            <p class="InNume">您的辅导员编号是：<span id="paren_member">10239</span></p>
                        </div>
                        <div class="QRCodeIcon">
                            <!-- <img src="ucenter\static\default\images\login_01\twoDimensionCode.png" id="qrurl"> -->
                            <div id="qrcodeCanvas" src="" data-src="ucenter\static\default\images\login_01\twoDimensionCode.png"></div>
                        </div>
                        <p class="hint">提示：您的二维码可以在我的-我的个人资料中查看</p>
                        <div>
                            <button type="submit" class="btn-register" onclick="reg4Click()">进入首页</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- 规章弹窗 -->
    <div class="timeSelectBox">
        <div class="TeStSon">
            <p class="TeStSon_p"><?= $reg_row['reg_protocol']['config_value'] ?></p>
            <button class="TeStSon_bn">同意并继续</button>
        </div>

    </div>

</div>

<!-- PC端页面 -->
<div class="pcRegisterBox">
    <div id="form-header" class="header">
        <div class="logo-con w clearfix">
            <a href="<?=Yf_Registry::get('shop_api_url')?>" class="index_logo">
                <img src=" ucenter/static/default/images/login_01/login_03.png" alt="logo" height="60">
            </a>
            <div class="logo-title"><p>注册</p></div>
        </div>
    </div>
    <div class="main ">
        <div class="pcRrStop">
            <div class="Rr">
                <div class="RrL">
                      <p class="RrLNumber RrLFirst">1</p>
                      <p class="RrL_p">上传身份证照片</p>
                </div>
            </div>
            <!-- 2 -->
            <div class="Rr firstStep">

                <div class="innerWire">
                    <p>············></p>
                </div>

                <div class="RrL">
                      <p class="RrLNumber">2</p>
                      <p class="RrL_p RrL_pDefault">填写注册基本信息</p>
                </div>

            </div>
            <!-- 3 -->
            <div class="Rr firstStep">

                <div class="innerWire">
                    <p>············></p>
                </div>

                <div class="RrL">
                      <p class="RrLNumber">3</p>
                      <p class="RrL_p RrL_pDefault">&nbsp&nbsp&nbsp优惠顾客资料&nbsp&nbsp&nbsp</p>
                </div>

            </div>
             <!-- 4 -->
            <div class="Rr firstStep">
                <div class="innerWire">
                    <p>············></p>
                    <!-- <p>···················<span class="IrSpan">></span></p> -->
                </div>
                <div class="RrL">
                    <p class="RrLNumber">4</p>
                    <p class="RrL_p RrL_pDefault">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp设置密码&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</p>
                </div>
            </div>
            <div class="Rr firstStep">
                <div class="innerWire">
                    <p>············></p>
                    <!-- <p>···················<span class="IrSpan">></span></p> -->
                </div>
                <div class="RrL">
                      <p class="RrLNumber">5</p>
                      <p class="RrL_p RrL_pDefault">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp申请成功&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</p>
                </div>
            </div>
        </div>
    <!-- PC-1-->
    <style type="text/css">
        #pcfroutIdentity .webuploader-pick{
            width: 240px;
            height: 151px;
        }
        #reverseIdentity .webuploader-pick{
            width: 240px;
            height: 151px; 
        }
        .webuploader-pick{
            width: 100%;
            height: 100%;
        }

    </style>
    <div class="pcStCont PCItIdentity">
        <form action="" id="register-form111" method="post" novalidate="novalidate"  onsubmit="return false;">
            <div>
                <p class="PCIdentity_p">请上传本人身份证照片：</p>
                <div class="pcFront">
                    <div class="ItIdentity" id="pcfroutIdentity" style="width: 240px;height: 151px!important;">
                        <img id='pcyulan' src="ucenter/static/default/images/login_01/bankCard_03.jpg" width="240" height="151">
                        <!-- <input type="hidden" id="images" class="field re_user_password PCidentityIt-a" autocomplete="off" maxlength="20" placeholder="" default="<i class=i-def></i><?=$pwd_str?>" name="images"> -->
                        <input type="hidden" value="" id="pcuser_froutIdentity" class="identityIt"  name="images">
                    </div>
                    <p>身份证人像面</p>
                </div>

                <div class="pcFront">
                    <div class="ItIdentity" id="reverseIdentity" style="width: 240px;height: 151px!important;">
                        <img id="pcyulan1" src="ucenter/static/default/images/login_01/bankCard_05.jpg" width="240" height="151">
                        <!-- <input type="file" id="images1" class="field re_user_password PCidentityIt-b" autocomplete="off" maxlength="20" placeholder="" default="<i class=i-def></i><?=$pwd_str?>" name="images1"> -->
                        <input type="hidden" value="" id="pcimages1" class="field re_user_password identityIt" name="pcimages1">
                    </div>
                    <p>身份证国徽面</p>
                </div>
            </div>
            <div class="IyStandard">
                <div class="IySdTop">
                    <p class="IySdTopL">请拍摄身份证原件：</p>
                    <p class="IySdTopR PCIySdTopR"><i></i>上传证件照片要求</p>
                </div>
                <ul class="IySdConter PCIySdConter">
                    <li>
                        <img src="ucenter\static\default\images\login_01\identity_13.jpg">
                        <p class="correct_p PCcorrect_p"><i></i>标准</p>
                    </li>
                    <li>
                        <img src="ucenter\static\default\images\login_01\identity_15.jpg">
                        <p class="error_p "><i></i>边框缺失</p>
                    </li>
                    <li>
                        <img src="ucenter\static\default\images\login_01\identity_17.jpg">
                        <p class="error_p"><i></i>照片模糊</p>
                    </li>
                    <li>
                        <img src="ucenter\static\default\images\login_01\identity_19.jpg">
                        <p class="error_p"><i></i>闪光强烈</p>
                    </li>
                </ul>

                <!-- <button type="submit" class="btn-PCIdentity" onclick="nextStep(1)">下一步</button> -->
                <button type="submit" class="btn-PCIdentity" onclick="imgClick()">下一步</button>
            </div>
        </form>
    </div>
    <!-- PC-2-->
    <div class="pcStCont pcdata">

        <div class="reg-form " id="reg-form1">
            <form action="" id="register-form1" class="ItRegister" method="post" novalidate="novalidate"  onsubmit="return false;">
                <div id="form-item-password" class="form-item" style="z-index: 12;">
                    <label>辅导员编号 </label>

                    <input type="text" id="par_member" class="field PCfield re_user_password" autocomplete="off" maxlength="7" placeholder="辅导员编号" default="<i class=i-def></i><?=$pwd_str?>" onchange="instruClick()">
                </div>
                <div class="input-tip">
                    <span></span>
                </div>
                <div id="form-item-password" class="form-item" style="z-index: 12;">
                    <label>辅导员姓名 </label>

                    <input type="text" id="par_name" value="" class="field re_user_password" autocomplete="off" maxlength="30" placeholder="辅导员姓名" default="<i class=i-def></i><?=$pwd_str?>" disabled="disabled">
                </div>
                 <div class="input-tip">
                    <span></span>
                </div>

                <div id="form-item-password" class="form-item" style="z-index: 12;">
                    <label>身份证号码 </label>

                    <input type="texttext" id="user_idcard" class="field re_user_password" autocomplete="off" maxlength="18" placeholder="身份证号码" default="<i class=i-def></i><?=$pwd_str?>" disabled="disabled">
                </div>
                <div class="input-tip">
                    <span></span>
                </div>
                <div id="form-item-password" class="form-item" style="z-index: 12;">
                    <label>会员姓名 </label>

                    <input type="text" id="user_name" class="field re_user_password" autocomplete="off" maxlength="30" placeholder="会员姓名" default="<i class=i-def></i><?=$pwd_str?>" disabled="disabled">
                </div>
                <div class="input-tip">
                    <span></span>
                </div>
                <div id="form-item-password" class="form-item" style="z-index: 12;">
                    <label>性别 </label>

                    <input type="text" id="user_gender" class="field re_user_password" autocomplete="off" maxlength="16" placeholder="会员性别" default="<i class=i-def></i><?=$pwd_str?>" disabled="disabled">
                </div>
                <div class="input-tip">
                    <span></span>
                </div>
                <div id="form-item-password" class="form-item" style="z-index: 12;">
                    <label>出生年月 </label>

                    <input type="text" id="user_birth" class="field re_user_password" autocomplete="off" maxlength="16" placeholder="出生年月" default="<i class=i-def></i><?=$pwd_str?>" disabled="disabled">
                </div>
                <div class="input-tip">
                    <span></span>
                </div>
               <div id="form-item-password" class="form-item" style="z-index: 12;">
                    <label>户籍地址 </label>

                    <input type="text" id="user_address" class="field re_user_password" autocomplete="off" maxlength="100" placeholder="户籍地址" disabled="disabled">
                </div>
                <div class="input-tip">
                    <span></span>
                </div>
                <div id="form-item-password" class="form-item" style="z-index: 12;">
                    <label>手机号 </label>
                        <input type="text" id="user_mobile" class="field re_user_password" autocomplete="off" maxlength="11" placeholder="建议使用常用手机" default="<i class=&quot;i-def&quot;></i>完成验证后，可以使用该手机登录和找回密码" onblur="checkMobile()" onfocus="showTip(this)">
                    <i class="i-status"></i>
                </div>
                <div class="input-tip">
                    <span></span>
                </div>
                <div class="Mobile_div" style="">
                    <div class="form-item form-item-mobile" id="form-item-mobile">
                        <div class="form-item form-item-phonecode">
                        <label>手机验证码 </label>

                        <input type="text" name="mobileCode" maxlength="6" id="phoneCode" onblur="checkRcode()" class="field phonecode  re_mobile" placeholder="请输入手机验证码">
                        <button style="height: 30px;font-size: 11px;" id="getPhoneCode" class="btn-phonecode" type="button" onclick="get_randcode_phone()">获取验证码 </button>
                        <i class="i-status"></i>
                        </div>
                    </div>
                </div>
                 <div class="input-tip">
                    <span></span>
                </div>
                <div id="form-item-password" class="form-item" style="z-index: 12;">
                    <label>会员邮箱 </label>
                    <input type="text" id="user_email" class="field re_user_password" autocomplete="off" maxlength="30" placeholder="会员邮箱" default="<i class=i-def></i><?=$pwd_str?>" onblur="checkEmail()" onfocus="showTip(this)">
                </div>
                <div class="input-tip">
                    <span></span>
                </div>
            </form>
        </div>
        <button type="submit" class=" btn-PCData" onclick="reg1Click()">下一步</button>
    </div>
    <!-- PC-3 -->
    <style type="text/css">
        #userbankimg>div{
            width: 240px!important;
            height: 151px!important;
        }
    </style>
    <div class="pcStCont pcClientData">

        <div class="reg-form">

            <form action="" id="register-form22" method="post"  novalidate="novalidate" onsubmit="return false;">

                <div id="form-item1" class="form-item FmIm" style="z-index: 12;">
                    <div class="UpBankCard">
                        <p><i class="PhotographCion"></i>拍照上传银行卡照片</p>
                        <div class="BankCardIcon1" id="userbankimg" style="width: 240px;height: 151px!important;">

                            <img id='bankimages' src="ucenter/static/default/images/login_01/bankCard_07.png" width="240" height="151">
                            <input type="hidden" value="" id="bankimg" class=""  name="images">


                        </div>

                    </div>
                </div>

                <div id="form-item-password" class="form-item" style="z-index: 12;">
                    <label>银行卡号</label>
                    <input type="text" id="bankaccount" class="field re_user_password" autocomplete="off" maxlength="21" placeholder="银行卡号" default="<i class=i-def></i>4-16个字符。" disabled="disabled">
                </div>
                <div class="input-tip">
                    <span></span>
                </div>
                <div id="form-item-password" class="form-item" style="z-index: 12;">
                    <label>银行类别</label>
                    <select id="bankno" class="field re_user_password">
                         <option value="0">请选择</option>
                        <option value="102">中国工商银行</option>
                        <option value="103">中国农业银行</option>
                        <option value="301">交通银行</option>
                    </select>

                </div>
                <div class="input-tip">
                    <span></span>
                </div>
                <div id="form-item-password" class="form-item" style="z-index: 12;">
                    <label>银行支行名称</label>
                    <input type="texttext" id="banksubranch" class="field re_user_password" autocomplete="off" maxlength="50" placeholder="银行支行名称" default="<i class=i-def></i>4-16个字符。">
                </div>
                <div class="input-tip">
                    <span></span>
                </div>
                <div id="form-item-password" class="form-item" style="z-index: 12;">
                    <label>银行分行</label>
                    <input type="text" id="bankbranch" class="field re_user_password" autocomplete="off" maxlength="50" placeholder="银行分行" default="<i class=i-def></i>4-16个字符。">
                </div>
                <div class="input-tip">
                    <span></span>
                </div>
                <div id="form-item-password" class="form-item" style="z-index: 12;">
                    <label>开户行所在省</label>
                    <select id="province" class="field re_user_password">
                        <option value="载入中">载入中</option>
                         </select>

                </div>
                <div class="input-tip">
                    <span></span>
                </div>
                <div id="form-item-password" class="form-item" style="z-index: 12;">
                    <label>开户行所在市</label>
                    <select id="city" class="field re_user_password">
                        <option value="载入中">载入中</option>
                         </select>

                </div>

                    <div class="input-tip">
                        <span></span>
                    </div>

                <div class="input-tip">
                    <span class="radioBox"><input type="checkbox" class="input_check" id="check" checked=""><label for="check"></label><p class="LookThat">我以同意<span>尚赫</span>优惠顾客规章</p>
                </div>

                <!-- <button type="submit" class="btn-register" onclick="nextStep(3)">下一步</button> -->
                <button type="submit" class="btn-register" onclick="reg2Click()">下一步</button>
            </form>
        </div>
    </div>
    <!-- PC-4 -->
    <div class="pcStCont pcSetpPassword">
        <div class="reg-form PCPassword">
            <form action="" id="register-form3" method="post" novalidate="novalidate"  onsubmit="return false;">
                <div class="pas">
                    <div id="form-item-password" class="form-item" style="z-index: 12;">
                        <label>新 密 码</label>
                        <span class="close-btn js_clear_btn clear-icon"></span>
                        <input type="password" id="re_user_password" class="field re_user_password" maxlength="16" placeholder="6-16位字母数字区分大小写" default="<i class=i-def></i><?= $pwd_str ?>" onfocus="checkPwd()" onblur="pwdCallback()">
                        <span class="clear-btn eye-icon"></span>
                        <i class="i-status"></i>
                    </div>
                    <div class="input-tip">
                        <span></span>
                    </div>

                </div>

                <div id="form-item-rpassword" class="form-item pas">
                    <label>确 认 密 码</label>

                    <span class="close-btn js_clear_btn clear-icon"></span>
                    <input type="password" name="form-equalTopwd" id="form_equalTopwd" class="field" placeholder="请再次填写密码" maxlength="16" default="<i class=&quot;i-def&quot;></i>请再次输密码" onblur="checkRpwd()" onfocus="showTip(this)">

                    <span class="clear-btn eye-icon"></span>
                    <i class="i-status"></i>
                </div>
                <div class="input-tip">
                    <span></span>
                </div>
                <div class="register_B">
                    <!-- <button type="submit" class="btn-register" onclick="nextStep(4)">确认</button> -->
                    <button type="submit" class="btn-register" onclick="reg3Click()">确认</button>
                </div>
            </form>
        </div>




    </div>

    <!-- PC-5 -->
    <div class="pcStCont PCsucceed">
        <div class="reg-form">
            <form action="" id="register-form4" method="post" novalidate="novalidate" onsubmit="return false;">
                <div class="informationBox">
                    <h3><i></i>恭喜您成为尚赫会员!</h3>
                    <br><br>
                    <div class="inNameBox">
                        <p class="InNume">您的会员编号是：<span class="member_id" id="member_id">4553355<span></span></span></p>
                        <p class="InNume">您的辅导员编号是：<span id="paren_member">10239</span></p>
                    </div>
                    <div class="QRCodeIcon">
                        <!-- <img src="ucenter\static\default\images\login_01\twoDimensionCode.png" id="qrurl"> -->
                        <div id="qrcodeCanvas" src="" data-src="ucenter\static\default\images\login_01\twoDimensionCode.png"></div>
                    </div>
                    <p class="hint">提示：您的二维码可以在我的-我的个人资料中查看</p>

                    <!-- <button type="submit" class="btn-PCsucceed">完成</button> -->
                    <button type="submit" class="btn-PCsucceed" onclick="reg4Click()">进入首页</button>
                </div>
            </form>
        </div>
    </div>

</div>
<!-- 规章弹窗 -->
    <div class="timeSelectBox">
        <div class="TeStSon">
            <p class="TeStSon_p"><?= $reg_row['reg_protocol']['config_value'] ?></p>
            <button class="TeStSon_bn">同意并继续</button>
        </div>

    </div>

    <?php
    include $this->view->getTplPath() . '/' . 'footer.php';
    ?>
</div>
    <script src="<?=$this->view->js?>/upload/upload_image.js"></script>
    <script src="<?= $this->view->js?>/webuploader.js"></script>
    <link href="<?= $this->view->css?>/webuploader.css" rel="stylesheet">
    <script type="text/javascript" src="<?= $this->view->js ?>/jquery.qrcode.js"></script>
    <script type="text/javascript" src="<?= $this->view->js ?>/utf.js"></script>
    <style>
        @media screen and (max-width: 768px){
            .webuploader-container {
                height: 8.6rem!important;
            }
            .froutIdentity >.webuploader-pick> img {
                width: 100%;
            }
            .webuploader-pick
            {
                width: 100%!important;
                height: 100%!important;*/

            }
            .webuploader-pick>img{
                width: 100%;
                height:100%;
            }

        }
        @media screen and (max-width: 321px){
            .form-item label {
                width: 100% !important;
            }
            
            #reverseIdentity #rt_rt_1cih8qevb11pmkj1dqst2c13fja{
                width: 270px!important;
                height: 150px!important;
            }
        }
       #rt_rt_1cio4fpdcp3p199k15p1rkh1gv31>label{
                width: 100% !important;
                border:1px solid red;
        }
</style>
<script>
/*// 获取微信分享跳转之后的uu account
var uu_account_wx = getQueryString("u_account");
if (uu_account_wx) {
    setCookie("uu_account_wx",uu_account_wx,1);  //直销会员编号
}

// 获取微信分享跳转之后的uu account
var uu_member_id_wx = getQueryString("MemberID");
if (uu_member_id_wx) {
    setCookie("uu_member_id_wx",uu_member_id_wx,1);  //直销会员编号
}*/
    var BASE_URL = "<?=Yf_Registry::get('base_url')?>";
    var SITE_URL = "<?=Yf_Registry::get('url')?>";
    var wp;
   
    var w = $(window).width();

    
    if( w > 765){
        $(".appRegister").remove();
        $(".pcRegisterBox").css("display","block");
        wp = 1; //PC模式
    }else{
        wp = 2; //手机模式
        $(".pcRegisterBox").remove();
         $(".appRegister").css("display","block");
    }


    // 规章弹窗
      $(".LookThat").click(function(){
          
        $(".timeSelectBox").css("display","inline-block");
        $(document.body).css({
            "overflow-x":"hidden",
            "overflow-y":"hidden"
        });
        event.stopPropagation();
    })
    $(".TeStSon_bn").click(function(){
        $(".timeSelectBox").css("display","none");
        $(document.body).css({
            "overflow-x":"auto",
            "overflow-y":"auto"
        });
        event.stopPropagation();
    })




    // pc注册判断步骤
    function registerProcess(s){
        $(".innerWire p").css({"color":"#777"});
        $(".RrLNumber").css({"background-color":"#fff","color":"#777","border":"1px solid #777"});
        $(".RrL_pDefault").css("color","#777");
         for(var i=0; i<s; i++){
             $(".firstStep").eq(i).children("div:first-child").children("p").css
             ("color","#04736d");
             $(".firstStep").eq(i).children("div:last-child").children("p:first-child").css({
                 "background-color":"#04736d","color":"#fff","border":"1px solid #04736d"})
             $(".firstStep").eq(i).children("div:last-child").children("p:last-child").css({
                 "color":"#04736d"})
         }
    }

    function nextStep(a){
        console.log(a);
        registerProcess(a);
        $(".pcStCont").css("display","none");
        if(a ==1){
            $(".pcdata").css("display","block")
        }else if(a ==2){
            $(".pcClientData").css("display","block")
        }else if(a ==3){
            $(".pcSetpPassword").css("display","block")
        }else if(a ==4){
            $(".PCsucceed").css("display","block")
        }

    }
    function AppNextStep(a){
        $(".appStCont").css("display","none");
        if(a ==1){
            $(".container_b").css("display","block");
                //图片上传
            var uploadImage2 = new UploadImage({

                thumbnailWidth: 498,
                thumbnailHeight: 282,
                imageContainer: '#yulan2',
                uploadButton: '#reverseIdentity',
                inputHidden: '#images1',
                callback: function () {
                    $('#images1').isValid();
                }
            });
        }else if(a ==2){
            $(".recruitBox").css("display","block");
        }else if(a ==3){
            $(".recruitBox_b").css("display","block");
        }else if(a ==4){
            $(".membership").css("display","block");
        }else if(a ==5){
            $(".setPassword").css("display","block");
        }else if(a ==6){
            $(".registerSucceed").css("display","block");
        }

    }

    $(function(){
        //图片上传
        var uploadImage = new UploadImage({

            thumbnailWidth: 498,
            thumbnailHeight: 282,
            imageContainer: '#yulan',
            uploadButton: '#froutIdentity',
            inputHidden: '#user_froutIdentity',
            callback: function () {
                $('#user_froutIdentity').isValid();
            }
        });
    })
    //PC身份证正面
    $(function(){
        //图片上传
        var uploadImage = new UploadImage({

            thumbnailWidth: 498,
            thumbnailHeight: 282,
            imageContainer: '#pcyulan',
            uploadButton: '#pcfroutIdentity',
            inputHidden: '#pcuser_froutIdentity',
            callback: function () {
                $('#pcuser_froutIdentity').isValid();
            }
        });
    })
    //PC身份证反面
    $(function(){
        //图片上传
        var uploadImage = new UploadImage({

            thumbnailWidth: 498,
            thumbnailHeight: 282,
            imageContainer: '#pcyulan1',
            uploadButton: '#reverseIdentity',
            inputHidden: '#pcimages1',
            callback: function () {
                $('#pcimages1').isValid();
            }
        });
    })
    //app银行卡
    $(function(){
        //图片上传
        var uploadImage = new UploadImage({

            thumbnailWidth: 498,
            thumbnailHeight: 282,
            imageContainer: '#bankimages',
            uploadButton: '#userbankimg',
            inputHidden: '#bankimg',
            callback: function () {
                $('#bankimg').isValid();
                bankImg();
            }
        });
    })
    
    //一步插入数据库
    var param = new Array();

    //身份证图片上传
    function imgClick(){

        if (wp == 1) {
            // alert(123);
            var user_froutIdentity  = $('#pcuser_froutIdentity').val();
            // alert(user_froutIdentity);
            var images1 = $('#pcimages1').val();

        }else{
            var user_froutIdentity  = $('#user_froutIdentity').val();
            var images1 = $('#images1').val();
        }

        if (!user_froutIdentity) {
            return Public.tips.alert('请上传身份证正面图片');
        }
        if (!images1) {
            return Public.tips.alert('请上传身份证反面图片');
        }

        param['ImageIDNo']  = user_froutIdentity;
        param['ImageIDNo2'] = images1;

        $.ajax({ 
              url:'./index.php?ctl=Login&met=regidapi&typ=json',  
              type:'POST',
              data:{'user_froutIdentity':user_froutIdentity,'images1':images1},  
              success:function (res){

                if(res.status == 100)
                {  
                    
                    //跳转到老会员首次登录激活流程
                    var b        = new Base64();  
                    var idcard   = b.encode(res.data[0]['idcard']);
                    var memberid = b.encode(res.data[0]['MemberID']);
                    var name     = b.encode(res.data[0]['name']);
                    var img      = b.encode(param['ImageIDNo']);
                    var img2     = b.encode(param['ImageIDNo2']);

                    //如果本商城也已注册，则直接跳转到登录
                    if (res.data[0]['dirlogin']) {
                    
                        Public.tips.alert('该身份证已注册会员，请直接登录');

                        
                       setTimeout(function(){  window.location.href = '<?= sprintf('%s?ctl=Login&met=index&t=%s&from=%s&callback=%s', Yf_Registry::get('url'), request_string('t'), request_string('from'), urlencode(request_string('callback'))) ?>'; }, 3000);
                        // window.location.href = '<?= sprintf('%s?ctl=Login&met=index&t=%s&from=%s&callback=%s', Yf_Registry::get('url'), request_string('t'), request_string('from'), urlencode(request_string('callback'))) ?>';


                    }else{
                        Public.tips.alert('您已经是老会员，请去激活！');
                        setTimeout(function(){ window.location.href = '<?=sprintf('%s?ctl=Login&act=activat&t=%s&from=%s&callback=%s', Yf_Registry::get('url'), request_string('t'), request_string('from'), urlencode(request_string('callback')))?>&idcard='+idcard+'&memberid='+memberid+'&name='+name+'&img='+img+'&img2='+img2; }, 3000);
                        //跳转老会员激活
                        
                        // window.location.href = '<?=sprintf('%s?ctl=Login&act=activat&t=%s&from=%s&callback=%s', Yf_Registry::get('url'), request_string('t'), request_string('from'), urlencode(request_string('callback')))?>&idcard='+idcard+'&memberid='+memberid+'&name='+name+'&img='+img+'&img2='+img2;

                        
       
                        function delayURL(url,time){
                             setTimeout("top.location.href = '" + url + "'",time);
                             }
                        url = "<?=sprintf('%s?ctl=Login&act=activat&t=%s&from=%s&callback=%s', Yf_Registry::get('url'), request_string('t'), request_string('from'), urlencode(request_string('callback')))?>&idcard='+idcard+'&memberid='+memberid+'&name='+name+'&img='+img+'&img2='+img2";     




                    }
                    

                    // setTimeout("location.href = <?=sprintf('%s?ctl=Login&act=activat&t=%s&from=%s&callback=%s', Yf_Registry::get('url'), request_string('t'), request_string('from'), urlencode(request_string('callback')))?>",4000);
                }else if(res.status == 200){
                    if(<?=Web_ConfigModel::value('register')?>==2)
                    {
                        Public.tips.alert('新会员注册暂时关闭，您无法注册');
                        return;
                    }
                    setCookie("cardinfo",JSON.stringify(res.data),1);  //序列化 反序列化JSON.parse()

                    //把回传的身份证信息显示出来
                    $("#user_idcard").attr("value",res.data[3]);
                    $("#user_name").attr("value",res.data[2]);
                    $("#user_gender").attr("value",res.data[4]);
                    $("#user_birth").attr("value",res.data[1]);
                    $("#user_address").attr("value",res.data[0]);
                    if (wp == 1) {
                        nextStep(1)
                    }else{
                       AppNextStep(2) 
                    }
                    //如果存在 则自动填充数据
                    
                    //获取通过微信分享跳转注册页面的cookie
                    // var u_account = getCookie('uu_account_wx');
                    var u_account = "<?php echo @$_SESSION['uu_account_wx']?>";
    
                    if (u_account) {
                        instruClickbyWx(u_account);
                    }else{
                        //获取通过微信分享跳转注册页面的cookie
                        // var uu_member_id_wx = getCookie('uu_member_id_wx');
                        var uu_member_id_wx = "<?php echo @$_SESSION['uu_member_id_wx']?>";
        
                        if (uu_member_id_wx) {
                            instruClickbyWx(uu_member_id_wx);
                        }
                    }

                    
     
                }else{ 

                    Public.tips.error(res.msg);
                    //Public.tips.error("<?=_('验证失败！')?>");
                }  
              },  
              error:function (res){  
                console.log(res);  
              }  
        });
    }

    // 身份证正面判断
    function identityFront(){
        var user_froutIdentity = $('#user_froutIdentity').val()
        if (!user_froutIdentity) {
            return Public.tips.alert('请上传身份证正面图片');
        }
        console.info($('#user_froutIdentity').val());
        $.ajax({
              url:'./index.php?ctl=Login&met=regidapi&typ=json',  
              type:'POST',
              data:{'user_froutIdentity':user_froutIdentity},  
              success:function (res){

                if(res.status == 100)
                {  
                    AppNextStep(1);
                    // Public.tips.alert('该身份证已注册会员！');
                    // return;
                }else if(res.status == 200){
                    AppNextStep(1)
                }else{
                    Public.tips.alert(res.msg);
                    return;
                }  
              },  
              error:function (res){  
                return  Public.tips.alert('错误');
              }  
        });

    }

    
    function afterreset(){
        window.location.href = '<?=sprintf('%s?ctl=Login&met=index&t=%s&from=%s&callback=%s', Yf_Registry::get('url'), request_string('t'), request_string('from'), urlencode(request_string('callback')))?>';
    }

    //自动带出身份证信息
    // var cardinfo = JSON.parse(getCookie("cardinfo"));

    // if (cardinfo) {
    //     $("#user_idcard").attr("value",cardinfo[3]);
    //     $("#user_name").attr("value",cardinfo[2]);
    //     $("#user_gender").attr("value",cardinfo[4]);
    //     $("#user_birth").attr("value",cardinfo[1]);
    //     $("#user_address").attr("value",cardinfo[0]);
    // }
    //用辅导员编号，进行上线会员资格检查
    function instruClick(){
        //如果是手动输入，7位纯数字
        var par_member = $("#par_member").val();  //直销会员编号
        if (!par_member) {
            return Public.tips.alert('请输入辅导员编号');
        }
        var reg = /^[0-9]{7}$/;
        if (!reg.test(par_member)) {
            
            Public.tips.alert('请输入正确的辅导员编号');
            $("#par_name").val(""); //置成空
            return false;
        }
        //var par_member = '9191919';
        //var idno = cardinfo[3]; //调用上线会员资格检查接口的会员的身份证号
        var idno = $("#user_idcard").val();
        var ajaxurl = './index.php?ctl=Login&met=CheckParent&typ=json';
        $.ajax({
            type: "POST",
            url: ajaxurl,
            data:{"IDNo": idno,"ParentMemberID": par_member},
            dataType: "json",
            success: function (respone) {
                if (respone.status == 200) {
              
                    setCookie("BelongSalon",respone.data['BelongSalon'],1); //归属沙龙编号
                    setCookie("ParentMemberName",respone.data['ParentMemberName'],1);  //辅导员姓名

                    setCookie("par_member",par_member,1);  //直销会员编号
      
                    $('#par_name').val(respone.data['ParentMemberName']);
                   
                } else {
                    Public.tips.alert("会员编号不存在");
                    $('#par_name').val(""); //置成空
                    
                    return false;
                }
            }
        });
    }
//微信分享跳转注册页面  用辅导员编号，进行上线会员资格检查
function instruClickbyWx(u_account){
    //如果是手动输入，7位纯数字
    var par_member = u_account;  //直销会员编号
    var idno = $("#user_idcard").val();
    var ajaxurl = './index.php?ctl=Login&met=CheckParent&typ=json';
    $.ajax({
        type: "POST",
        url: ajaxurl,
        data:{"IDNo": idno,"ParentMemberID": par_member},
        dataType: "json",
        success: function (respone) {
            if (respone.status == 200) {
          
                setCookie("BelongSalon",respone.data['BelongSalon'],1); //归属沙龙编号
                setCookie("ParentMemberName",respone.data['ParentMemberName'],1);  //辅导员姓名

                setCookie("par_member",par_member,1);  //直销会员编号
  
                $('#par_name').val(respone.data['ParentMemberName']);
                $('#par_member').val(par_member);
            } else {
                Public.tips.alert("会员编号不存在");
                $('#par_name').val(""); //置成空
                $('#par_member').val("");//置成空
                return false;
            }
        }
    });
}
    //验证手机
    function checkMobile() {

        var form_mobile = $("#user_mobile");
        hideError(form_mobile);
        var mobile = $("#user_mobile").val();
        if (mobile) {
            //先匹配是否为手机号
            if (/^1[34578]\d{9}$/.test(mobile)) {
                //验证该手机号是否被注册过
                var ajaxurl = './index.php?ctl=Login&met=checkMobile&typ=json&mobile=' + mobile;
                $.ajax({
                    type: "POST",
                    url: ajaxurl,
                    dataType: "json",
                    async: false,
                    success: function (respone) {
                        if (respone.status == 250) {
                            var errormsg = icons.error + '该手机号已被注册';
                            onKeyupHandler($("#user_mobile"), errormsg);
                            mobile_check = false;
                            $("#getPhoneCode").attr('onclick','');
                        } else {
                            $("#form-item-mobile").addClass("form-item-valid");
                            $("#form-item-mobile").next().find("span").html("");
                            mobile_check = true;
                            $("#getPhoneCode").attr('onclick','get_randcode_phone()');
                        }
                    }
                });
            } else {
                var errormsg = icons.error + '请输入正确的手机号';
                onKeyupHandler(form_mobile, errormsg);
                mobile_check = false;
                $("#getPhoneCode").attr('onclick','');
            }
        } else {
            $("#form-item-mobile").next().find("span").html("");
        }
    }

    //获取注册验证码
    function get_randcode_phone() {

        var mobile_check = false;
        var form_mobile = $("#user_mobile");
        //手机号码
        var mobile = $("#user_mobile").val();
        if (!mobile) {
            var errormsg = icons.error + '请填写手机号';
            onKeyupHandler(form_mobile, errormsg);
            return;
        }

        if (!window.randStatus) {
            return;
        }
        //先匹配是否为手机号
        if(!isNaN(mobile) && mobile.length == 11)
        {
            $("#form-item-mobile").next().find("span").html("");
            result = true;
        }else{
            var errormsg = icons.error + '请输入正确的手机号';
            onKeyupHandler(form_mobile, errormsg);
            result = false;
        }

        var ajaxurl = './index.php?ctl=Login&met=reg1Code&typ=json';
        
        $.ajax({
            type: "POST",
            url: ajaxurl,
            dataType: "json",
            async: false,
            data: "mobile=" + mobile,
            success: function (respone) {
                if (respone.status == 250) {
                    var errormsg = icons.error + respone.msg;
                    onKeyupHandler(form_mobile, errormsg);
                } else if (respone.status == 230) {
                    var errormsg = icons.error + respone.msg;
                    onKeyupHandler(form_mobile, errormsg);
                } else {
                    window.countDown();
                    alert(respone.data['user_code']);
                    setCookie("phone_code",respone.data['user_code'],1);
                    setCookie("user_mobile",mobile,1);

                    param['user_mobile2'] = mobile;
                    param['phoneCode2']   = respone.data['user_code'];

                    Public.tips.alert('请查看手机短信获取验证码!');
                    return false;
                }
            }
        });
    }

    msg = "<?=_('获取验证码')?>";
    var delayTime = 60;
    window.randStatus = true;
    window.countDown = function () {
        window.randStatus = false;
        delayTime--;
        $('.btn-phonecode').html(delayTime + "<?=_(' 秒后重新获取')?>");
        if (delayTime == 0) {
            delayTime = 60;
            $('.btn-phonecode').html(msg);
            clearTimeout(t);
            window.randStatus = true;
        } else {
            t = setTimeout(countDown, 1000);
        }
    };

    //检验手机和短信验证码
    function checkRcode(){
        
        if (!$("#user_mobile").val()) {
            Public.tips.alert('请输入手机号!');
            return false;
        }else{

            if (!param['phoneCode2']) {
              
                // Public.tips.alert('请点击获取验证码!');
                return false;
            }
        }

        if (!$("#phoneCode").val()) {
        
            Public.tips.alert('请输入短信验证码!');
            return false;
        }

        var reg = /^[0-9]{6}$/;
        if (!reg.test($("#phoneCode").val())) {
            Public.tips.alert('请输入正确的短信验证码');
            return false;
        }

        var user_code   = $("#phoneCode").val();//getCookie("phone_code");
        var user_mobile = $("#user_mobile").val();//getCookie("user_mobile");

        var ajaxurl = './index.php?ctl=Login&met=phoneCode&typ=json';

        $.ajax({
            type: "POST",
            url: ajaxurl,
            dataType: "json",
            async: false,
            data: {'user_code':user_code,'user_mobile':user_mobile},
            success: function (respone) {
                if (respone.status == 250) {
                    Public.tips.alert('请输入的正确的手机号和验证码!'); //超过60秒会验证失败
                    return false;
                }else{
                
                    // verify_code = 1;
                }
            }
        });

    }
    //新会员注册
    function regClick(){

        //获取cookie身份证信息
        var cardinfo = JSON.parse(getCookie("cardinfo"));

        param['par_member']  = $('#par_member').val();
        param['par_name']    = $('#par_name').val();
        param['user_idcard'] = $('#user_idcard').val();
        param['user_name']   = $('#user_name').val();
        param['user_gender'] = $('#user_gender').val();
        param['user_birth']  = $('#user_birth').val();
        param['user_address']= $('#user_address').val();

        if (param['user_gender'] == "男") {
            param['user_gender'] = '1';
        }else if(param['user_gender'] == "女"){
            param['user_gender'] = '0';
        }else{
            param['user_gender'] = '2';
        } 

        if (!param['par_member']) {
            return Public.tips.alert('请输入辅导员编号');
        }
        if (!param['par_name']) {
            return Public.tips.alert('请输入辅导员姓名');
        }
        if (!param['user_idcard']) {
            return Public.tips.alert('请输入身份证号码');
        }
        if (!param['user_name']) {
            return Public.tips.alert('请输入会员姓名');
        }
        if (!param['user_gender']) {
            return Public.tips.alert('请输入会员性别');
        }
        if (!param['user_birth']) {
            return Public.tips.alert('请输入出生年月');
        }
        if (!param['user_address']) {
            return Public.tips.alert('请输入户籍地址');
        }
        
        //填写的值和接口返回的值进行验证
        if ($('#par_member').val() != getCookie("par_member")) {
            return Public.tips.alert('您输入的辅导员编号和扫描的二维码不一致');
        }
        // if ($('#par_name').val() != getCookie("ParentMemberName")) { //辅导员姓名
        //     return Public.tips.alert('您输入的辅导员姓名和扫描的二维码不一致');
        // }
        if ($('#user_idcard').val() != cardinfo[3]) {
            return Public.tips.alert('您输入的身份证号码和上传的身份证照片上不一致');
        }
        if ($('#user_name').val() != cardinfo[2]) {
            return Public.tips.alert('您输入的姓名和上传的身份证照片上不一致');
        }
        if ($('#user_gender').val() != cardinfo[4]) {
            return Public.tips.alert('您输入的性别和上传的身份证照片上不一致');
        }
        if ($('#user_birth').val() != cardinfo[1]) {
            return Public.tips.alert('您输入的出生年月和上传的身份证照片上不一致');
        }
        if ($('#user_address').val() != cardinfo[0]) {
            return Public.tips.alert('您输入的户籍地址和上传的身份证照片上不一致');
        }


        AppNextStep(3)
    }
    //新会员注册
    function reg1Click(){

        //获取cookie身份证信息
        var cardinfo = JSON.parse(getCookie("cardinfo"));

        if (wp == 1) {

            param['par_member']  = $('#par_member').val();
            param['par_name']    = $('#par_name').val();
            param['user_idcard'] = $('#user_idcard').val();
            param['user_name']   = $('#user_name').val();
            param['user_gender'] = $('#user_gender').val();
            param['user_birth']  = $('#user_birth').val();
            param['user_address']= $('#user_address').val();
            param['user_mobile'] = $('#user_mobile').val();
            param['user_code']   = $('#phoneCode').val();
            param['user_email']  = $('#user_email').val();
            param['phone_code']  = param['phoneCode2']; //获取验证码
            param['BelongSalon'] = getCookie("BelongSalon"); //归属沙龙

            if (param['user_gender'] == "男") {
                param['user_gender'] = '1';
            }else if(param['user_gender'] == "女"){
                param['user_gender'] = '0';
            }else{
                param['user_gender'] = '2';
            }
            if (!param['par_member']) {
                return Public.tips.alert('请输入辅导员编号');
            }
            if (!param['par_name']) {
                return Public.tips.alert('请输入辅导员姓名');
            }
            if (!param['user_idcard']) {
                return Public.tips.alert('请输入身份证号码');
            }
            if (!param['user_name']) {
                return Public.tips.alert('请输入会员姓名');
            }
            if (!param['user_gender']) {
                return Public.tips.alert('请输入会员性别');
            }
            if (!param['user_birth']) {
                return Public.tips.alert('请输入出生年月');
            }
            if (!param['user_address']) {
                return Public.tips.alert('请输入户籍地址');
            }

            if (!param['user_mobile']) {
                return Public.tips.alert('请输入手机号');
            }
            if (!param['phone_code']) {
                return Public.tips.alert('请点击获取短信验证码');
            }
            if (!param['user_code']) {
                return Public.tips.alert('请输入短信验证码');
            }else if(param['user_code']!=param['phone_code']){
                return Public.tips.alert('您输入的短信验证码不正确');
            }
            var form_email = $("#user_email");
            hideError(form_email);
            var email = $("#user_email").val();
            var reg = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            //先匹配是否为邮箱
            if (!reg.test(email)) {
                var errormsg = icons.error + '请输入正确的邮箱';
                onKeyupHandler(form_email, errormsg);
                email_check = false;
                return Public.tips.alert('请输入正确的邮箱');
            }
            //填写的值和接口返回的值进行验证
            if ($('#par_member').val() != getCookie("par_member")) {
                return Public.tips.alert('您输入的辅导员编号和扫描的二维码不一致');
            }
            if ($('#par_name').val() != getCookie("ParentMemberName")) { //辅导员姓名
                return Public.tips.alert('您输入的辅导员姓名和扫描的二维码不一致');
            }
            if ($('#user_idcard').val() != cardinfo[3]) {
                return Public.tips.alert('您输入的身份证号码和上传的身份证照片上不一致');
            }
            // if ($('#user_name').val() != cardinfo[2]) {
            //     return Public.tips.alert('您输入的姓名和上传的身份证照片上不一致');
            // }
            if ($('#user_gender').val() != cardinfo[4]) {
                alert(param['user_gender']);alert(cardinfo[4]);
                return Public.tips.alert('您输入的性别和上传的身份证照片上不一致');
            }
            if ($('#user_birth').val() != cardinfo[1]) {
                return Public.tips.alert('您输入的出生年月和上传的身份证照片上不一致');
            }
            if ($('#user_address').val() != cardinfo[0]) {
                return Public.tips.alert('您输入的户籍地址和上传的身份证照片上不一致');
            }
            if ($('#user_mobile').val() != param['user_mobile2']) {
                return Public.tips.alert('请不要修改已输入的手机号');
            }

        } else {
            var email = $("#user_email").val();
            var reg = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            param['user_mobile'] = $('#user_mobile').val();
            param['user_code']   = $('#phoneCode').val();
            param['user_email']  = $('#user_email').val();
            param['phone_code']  = param['phoneCode2']; //获取验证码

            param['BelongSalon'] = getCookie("BelongSalon"); //归属沙龙


            if (!param['user_mobile']) {
                return Public.tips.alert('请输入手机号');
            }
            if (!param['phone_code']) {
                return Public.tips.alert('请点击获取短信验证码');
            }
            if (!param['user_code']) {
                return Public.tips.alert('请输入短信验证码');
            }else if(param['user_code']!=param['phone_code']){
                return Public.tips.alert('您输入的短信验证码不正确');
            }
            if (!param['user_email']) {
                return Public.tips.alert('请输入会员邮箱');
            }

            //填写的值和接口返回的值进行验证
            if ($('#user_mobile').val() != param['user_mobile2']) {
                return Public.tips.alert('请不要修改已输入的手机号');
            }

            if(!reg.test(email)){
                return Public.tips.alert('请输入正确的邮箱地址');
            }

        }



        if (wp == 1) {
            nextStep(2)
        } else {
            AppNextStep(4)
        }


    }

    //优惠顾客资料-上传银行卡图片
    function bankImg(){

        if (wp == 1) {

            var bankimg  = $('#bankimg').val();
            if (!bankimg) {
                return Public.tips.alert('请上传银行卡正面图片');
            }
        } else {

            var bankimg  = $('#bankimg').val();
            if (!bankimg) {
                return Public.tips.alert('请上传银行卡正面图片');
            }
            //var form = new FormData($("#register-form2")[0]);  
        }
        param['ImageBank'] = bankimg;
     
        $.ajax({ 
              url:'./index.php?ctl=Login&met=bankcardapi&typ=json',  
              type:'POST',
              data:{'bankimg':bankimg},  
              success:function (res){
                 if(res.msg == '成功'){
                   
                    //setCookie("bankinfo",JSON.stringify(res.data),1);  //序列化 反序列化JSON.parse()
                    setCookie("bankaccount",res.data['bank_card_number'],1);
                    $("#bankaccount").attr("value",res.data['bank_card_number']);
                }else{ 
                    Public.tips.error('银行卡识别失败');
                }  
              },  
              error:function (res){  
                console.log(res);  
              }  
        });
    }

    //自动带出银行卡信息
   
    // var bankinfo = JSON.parse(getCookie("bankinfo"));

    // if (bankinfo) {

    //     $("#bankaccount").attr("value",bankinfo['bank_card_number']);
    //     $("#bankno").attr("value",bankinfo['BIN_CARDNAME']);
    //     $("#banksubranch").attr("value",bankinfo[4]);
    //     $("#bankbranch").attr("value",bankinfo[1]);
    // }

    //优惠顾客资料-银行卡资料提交
    function reg2Click(){
        
    
        param['bankaccount']  = $('#bankaccount').val();
        param['bankno']       = $('#bankno option:selected').val();
        param['banksubranch'] = $('#banksubranch').val();
        param['bankbranch']   = $('#bankbranch').val();
        param['bankprovince'] = $('#province option:selected').attr("value");
        param['bankcity']     = $('#city option:selected').attr("value");

        //判断是否上传银行卡图片
        if (!$('#bankimg').val()) {
            return Public.tips.alert('请上传银行卡正面图片');
        }

        //验证输入值不能为空
        if (!param['bankaccount']) {
            return Public.tips.alert('请输入银行卡号');
        }
        if (param['bankno'] == 0) {
            return Public.tips.alert('请选择银行类别');
        }
        if (!param['banksubranch']) {
            return Public.tips.alert('请输入银行支行名称');
        }
        if (!param['bankbranch']) {
            return Public.tips.alert('请输入银行分行');
        }
        if (param['bankprovince'] == 0) {
            return Public.tips.alert('请选择开户行所在省');
        }
        if (param['bankcity'] == 0) {
            return Public.tips.alert('请选择开户行所在市');
        }
         //判断是否选中我已阅读用户手册
        if (!$('#check').is(':checked')) {
            Public.tips.alert('请确认是否同意尚赫优惠顾客规章');
            return;
        }


        //填写的值和接口返回的值进行验证
        if (param['bankaccount'] != getCookie("bankaccount")) {
            return Public.tips.alert('您输入的银行卡号和上传的银行卡照片上不一致');
        }

        console.log(param);
        if (wp == 1) {
            nextStep(3)
        } else {
            AppNextStep(5)
        }
        
    }


    //设置密码
    function reg3Click(){
 
        param['re_user_password'] = $('#re_user_password').val();//新密码
        param['user_password']    = $('#form_equalTopwd').val();//新密码
        var token = $(".token").val();
        
        if (!param['re_user_password']) {
            return Public.tips.alert('请输入新密码');
        }
        if (!param['user_password']) {
            return Public.tips.alert('请输入确认密码');
        }
        if (param['re_user_password'] != param['user_password']) {
            return Public.tips.alert('两次密码输入不一致');
        }
        var params = {
            "par_member": param['par_member'],  //辅导直销员编号
            "par_name": param['par_name'],  //辅导员姓名
            "user_idcard": param['user_idcard'],  
            "user_name": param['user_name'],  
            "user_gender": param['user_gender'],  
            "user_birth": param['user_birth'],  
            "user_address": param['user_address'],
            "user_mobile": param['user_mobile'], 
            "user_code": param['user_code'],  
            "user_email": param['user_email'],  
            "bankaccount": param['bankaccount'],  //银行账号
            "bankno": param['bankno'],  //银行类别
            "banksubranch": param['banksubranch'],  //银行支行名称
            "bankbranch": param['bankbranch'],  //银行分行名称
            "bankprovince": param['bankprovince'],  //主键
            "bankcity": param['bankcity'],  //主键
            "user_password": param['user_password'],    //传输确认密码
            "ImageIDNo":param['ImageIDNo'],
            "ImageIDNo2":param['ImageIDNo2'],
            "ImageBank":param['ImageBank'],
            "BelongSalon":param['BelongSalon'],
            "t": token
        };
        $("#mask_box").show();
        var ajaxurl = './index.php?ctl=Login&met=register1&typ=json';
        $.ajax({
            type: "post",
            url: ajaxurl,
            dataType: "json",
            data:params,
            success: function (respone)
            {
                $("#mask_box").hide();
                if(respone.status == 200){
                    $(".member_id").html(respone.data['MemberID']);
                    $("#paren_member").html(respone.data['par_member']);
                    $("#qrurl").attr('src', respone.data['qrurl']);
                    if (wp == 1) {
                        nextStep(4)
                    } else {
                        AppNextStep(6)
                    }
                    
                    //生成二维码
                    $("#qrcodeCanvas").qrcode({
                        render : "canvas",    //设置渲染方式，有table和canvas，使用canvas方式渲染性能相对来说比较好
                        text : respone.data['qrurl'],    //扫描二维码后显示的内容,可以直接填一个网址，扫描二维码后自动跳向该链接
                        width : "100",               //二维码的宽度
                        height : "100",              //二维码的高度
                        background : "#ffffff",       //二维码的后景色
                        foreground : "#000000",        //二维码的前景色
                        src: 'ucenter/static/default/images/20180730135300.jpg'             //二维码中间的图片
                     });


                }else{
                    Public.tips.alert('注册失败，'+respone.msg);
                    //三秒后跳转首页
                    return;
                }
            },
            error:function (respone) {//请求失败后调用的函数
               
                alert('注册失败,请联系客服');
            }
        });
    }
    //验证邮箱
    function checkEmail() {
        var form_email = $("#user_email");
        hideError(form_email);
        var email = $("#user_email").val();
        if (email) {
            var reg = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            //先匹配是否为邮箱
            if (!reg.test(email)) {
                var errormsg = icons.error + '请输入正确的邮箱';
                onKeyupHandler(form_email, errormsg);
                email_check = false;
            }
        } else {
            $("#form-item-email").next().find("span").html("");
        }
    }
    function reg4Click(){
        //window.location.href = "./index.php?ctl=User&met=getUserInfo";
        window.location.href = '<?=Yf_Registry::get('shop_api_url')?>';
    }

    var icons = {
        def: '<i class="i-def"></i>',
        error: '<i class="i-error"></i>',
        weak: '<i class="i-pwd-weak"></i>',
        medium: '<i class="i-pwd-medium"></i>',
        strong: '<i class="i-pwd-strong"></i>'
    };
     function hideError(input, msg) {
        var item = input.parent();
        var msg = msg || input.attr('default');
 
        item.removeClass('form-item-error form-item-valid');
        item.next().find('span').removeClass('error').html(msg).show();
        item.next().removeClass('phone-bind-tip');
        item.removeClass('phone-binded');
        item.next().removeClass('email-bind-tip');
        item.removeClass('email-binded');
    }

    /**输入过程中处理标签的状态**/
    function onKeyupHandler(input, msg) {
        var item = input.parent();
        if (!item.hasClass('form-item-error')) {
            item.addClass('form-item-error')
        }
        item.removeClass('form-item-valid');
        item.next().find('span').addClass('error').html(msg).show();
    }
    //检测密码
    function checkPwd() {

        var form_pwd = $("#re_user_password");
        var msg = form_pwd.attr('default');


        var s = form_pwd.parent().next().find("span").html();
        if(!s)
        {   
            form_pwd.parent().next().find("span").html(msg);
        }

        form_pwd.on('keyup', function (e) {
            var value = $(this).val();
            pwdStrengthRule(form_pwd, value);
        })
    }
    function pwdCallback()
    {   var form_pwd = $("#re_user_password");
        var user_pwd = $("#re_user_password").val();
        var form_rpwd = $("#form_equalTopwd");
        hideError(form_pwd);

        if (/[~'!@#￥$%^&*()-+_=:\.。—·【】\[\]"、》《<>?？/\|`]+/.test(user_pwd)) {
            var errormsg = icons.error + "密码不能包含特殊字符";
            onKeyupHandler(form_pwd, errormsg);
            return;
        }

        if (user_pwd) {
            var flag = true;
            var reg_number = <?=$reg_row['reg_number']['config_value'] ? $reg_row['reg_number']['config_value'] : 0 ?>;
            var reg_lowercase = <?=$reg_row['reg_lowercase']['config_value'] ? $reg_row['reg_lowercase']['config_value'] : 0 ?>;
            var reg_uppercase = <?=$reg_row['reg_uppercase']['config_value'] ? $reg_row['reg_uppercase']['config_value'] : 0 ?>;
            var reg_symbols = <?=$reg_row['reg_symbols']['config_value'] ? $reg_row['reg_symbols']['config_value'] : 0 ?>;
            var reg_pwdlength = <?=$reg_row['reg_pwdlength']['config_value'] ? $reg_row['reg_pwdlength']['config_value'] : 0 ?>;
            var reg = '';
            reg_number > 0 && (reg += '0-9');
            reg_lowercase > 0 && (reg += 'a-z');
            reg_uppercase > 0 && (reg += 'A-Z');
            reg_symbols > 0 && (reg += "~'!@#￥$%^&*()-/+_=:.。】、—,，【;；：“”’？?）（`·{}《》<>！[…");
            if (reg !== '') {
                reg = new RegExp('^[' + reg + ']+$');
                !reg.test(user_pwd) && (flag = false);
            }

            //必须包含数字
            if (reg_number > 0) {
                if (/[0-9]+/.test(user_pwd)) {
                    flag = flag && true;
                } else {
                    flag = flag && false;
                }
            }

            //必须小写字母
            if (reg_lowercase > 0) {
                if (/[a-z]+/.test(user_pwd)) {
                    flag = flag && true;
                } else {
                    flag = flag && false;
                }
            }

            //必须大写字母
            if (reg_uppercase > 0) {
                if (/[A-Z]+/.test(user_pwd)) {
                    flag = flag && true;
                } else {
                    flag = flag && false;
                }
            }

            //必须字符
            if (reg_symbols > 0) {
                if (/[~'!@#￥$%^&*()-+_=:\.。—·【】\[\]"、》《<>?？/\|`]+/.test(user_pwd)) {
                    flag = flag && true;
                } else {
                    flag = flag && false;
                }
            }

            if (reg_pwdlength > 0) {
                if (user_pwd.length >= <?=$reg_row['reg_pwdlength']['config_value']?>) {
                    flag = flag && true;
                } else {
                    flag = flag && false;
                }
            }

            if (flag) {
                pwd_check = true;
                $("#form-item-password").addClass("form-item-valid");
                $("#form-item-password").next().find("span").html("");
                $("#form-item-password").removeClass("pending");
            } else {
                pwd_check = false;
                $("#form-item-password").removeClass("pending");
                var errormsg = icons.error + "<?= $pwd_str ?>";
                onKeyupHandler(form_pwd, errormsg);
            }
        } else {
            pwd_check = false;
            $("#form-item-password").removeClass("pending");
            $("#form-item-password").next().find("span").html("");
        }
    }
    function checkRpwd()
    {   
        var form_rpwd = $("#form_equalTopwd");
        var rpwd = $("#form_equalTopwd").val();  //确认密码
        var pwd = $("#re_user_password").val();

        hideError(form_rpwd);

        if(rpwd)
        {
            if(rpwd == pwd)
            {
                $("#form-item-rpassword").addClass("form-item-valid");
                $("#form-item-rpassword").next().find("span").html("");
            }
            else
            {
                $("#form-item-rpassword").removeClass("form-item-valid");
                var errormsg = icons.error + '两次密码输入不一致';
                onKeyupHandler(form_rpwd, errormsg);
            }
        }
        else
        {
            $("#form-item-rpassword").next().find("span").html("");
        }

    }
    function pwdStrengthRule(element, value) {
        var pwdLength = '<?=$reg_row['reg_pwdlength']['config_value']?>';
        var level = 0;
        var typeCount=0;
        var flag = true;
        var valueLength=getStringLength(value);
        if (valueLength < pwdLength) {
                element.parent().removeClass('form-item-valid').removeClass('form-item-error');
                element.parent().next().find('span').removeClass('error').html($(element).attr('default'));
                return;
            }

        for (key in pwdStrength) {
            if (pwdStrength[key].reg.test(value)) {
                typeCount++;
            }
        }
        if(typeCount==1){
            if(valueLength>10){
                level=2;
            }else{
                level=1;
            }
        }else if(typeCount==2){
            if(valueLength<11&&valueLength>5){
                level=2;
            }
            if(valueLength>10){
                level=3;
            }
        }else if(typeCount==3){
            if(valueLength>6){
                level=3;
            }
        }

        if ($.inArray(value, weakPwds) !== -1) {
            flag = false;
            level=1;
        }

        if (flag && level > 0) {
            element.parent().removeClass('form-item-error').addClass(
                'form-item-valid');
        } else {
            element.parent().addClass('form-item-error').removeClass(
                'form-item-valid');
        }
        if (pwdStrength[level] !== undefined) {
            pwdStrength[level]>3?pwdStrength[level]=3:pwdStrength[level];
            element.parent().next().html('<span>' + pwdStrength[level].msg +
                '</span>')
        }
        return flag;
    }
    function getStringLength(str) {
        if (!str) {
            return;
        }
        var bytesCount = 0;
        for (var i = 0; i < str.length; i++) {
            var c = str.charAt(i);
            if (/^[\u0000-\u00ff]$/.test(c)) {
                bytesCount += 1;
            } else {
                bytesCount += 2;
            }
        }
        return bytesCount;
    }
    var pwdStrength = {
        1: {
            reg: /^.*([\W_])+.*$/i,
            msg: icons.weak + '有被盗风险,建议使用字母、数字和符号两种及以上组合'
        },
        2: {
            reg: /^.*([a-zA-Z])+.*$/i,
            msg: icons.medium + '安全强度适中，可以使用三种以上的组合来提高安全强度'
        },
        3: {
            reg: /^.*([0-9])+.*$/i,
            msg: icons.strong + '你的密码很安全'
        }
    };

    var weakPwds = [];

    //显示提示语
    function showTip(e)
    {
        var msg = $(e).attr('default');

        if(!$(e).parent().next().find("span").html())
        {
            $(e).parent().next().find("span").html(msg);
        }
    }
    

// 已同意判断
$('#check').click(function(){
        if(document.getElementById("check").checked){
            $('.enterBt').css('background-color','white');
            $('.enterBt').css('border','1px solid red');
            $('.enterBt').attr('is_ok','ok')
        }else{
            $('.enterBt').css('background-color','#999');
            $('.enterBt').css('border','1px solid #666');
            $('.enterBt').attr('is_ok','no')
        }
    })
    
function getQueryString(name){
    var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
    var r = window.location.search.substr(1).match(reg);
    if (r!=null) return r[2]; return '';
}
</script>
</body>

</html>