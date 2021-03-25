<html class="root61">
<?php
$re_url = '';
$re_url = Yf_Registry::get('re_url');

$from = '';
$callback = $re_url;
$t = '';
$code = '';

extract($_GET);
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
	<title>找回会员编号</title>
	<link rel="stylesheet" href="<?=$this->view->css?>/register.css">
	<link rel="stylesheet" href="<?=$this->view->css?>/base.css">
    <link rel="stylesheet" href="<?=$this->view->css?>/tips.css">
	<link rel="stylesheet" type="text/css" href="<?= $this->view->css ?>/headfoot.css" />
    <link rel="stylesheet" type="text/css" href="<?= $this->view->css ?>/old_member.css" />
    <link rel="stylesheet" type="text/css" href="<?= $this->view->css ?>/forgetPassword.css"/>
	<script src="<?=$this->view->js?>/jquery-1.9.1.js"></script>
	<script src="<?=$this->view->js?>/respond.js"></script>
    <script src="<?=$this->view->js?>/regist.js"></script>
</head>

<body>
<div id="form-header" class="header">
	<div class="logo-con w clearfix">
<!--		<a href="--><?//=$shop_url?><!--" class="index_logo">-->
<!--			<img src="--><?//= $web['site_logo'] ?><!--" alt="logo" height="60">-->
<!--		</a>-->
        <a href="<?=Yf_Registry::get('shop_api_url')?>" class="index_logo">
            <img src="<?= $web['site_logo'] ?>" alt="logo" height="60">
        </a>
		<div class="logo-title">找回会员编号</div>
		<div class="have-account">已有账号 <a href="<?=sprintf('%s?ctl=Login&met=index&t=%s&from=%s&callback=%s', Yf_Registry::get('url'), request_string('t'), request_string('from'), urlencode(request_string('callback')))?>" target="_blank">请登录</a></div>
	</div>

</div>
<div class="container w">
	<div id="aaa">
		<div id="header"><a href="javascript:history.go(-1)" class="back-pre"></a>找回会员编号</div>
        <div class="portraitIcon tc">
            <img src="<?= $web['site_logo'] ?>" alt="">
        </div>
        <div class="main clearfix" id="form-main">
			<div class="reg-form fl">
				<form action="" id="register-form" method="post" novalidate="novalidate" onsubmit="return false;">

					<input type="hidden" name="from" class="from" value="<?php echo $from;?>">
					<input type="hidden" name="callback" class="callback" value="<?php echo urlencode($callback);?>">
					<input type="hidden" name="t" class="t" value="<?php echo $t;?>">
					<input type="hidden" name="code" class="code" value="<?php echo $code;?>">
					<input type="hidden" name="re_url" class="re_url" value="<?php echo $re_url;?>">

					<!--chrome autocomplete off bug hack-->
					<input style="display:none" name="hack">
					<input type="password" style="display:none" name="hack1">
					<div class="Mobile_div">
						<div class="item-phone-wrap">
	                        <div class="form-item form-item-mobile" id="form-item-mobile">
<!--	                            <label class="select-country" id="select-country">真实姓名：-->
<!--	                            </label>-->
                                <i class="instructorIcon"></i>
	                            <span class="clear-btn JS-account js_clear_btn clear-icon" style="top:17px;right:110px;"></span>
	                            <input type="text" id="user_name"  class="field re_user_mobile" placeholder="请输入您的真实姓名" maxlength="11" default="<i class=&quot;i-def&quot;></i>完成验证后，可以使用该姓名登录和找回密码" onblur="" onfocus="showTip(this)" autocomplete="off">
	                            <i class="i-status"></i>
	                        </div>
	                        <div class="input-tip">
	                            <span></span>
	                        </div>
	                      
	                    </div>
					</div>
					<div id="form-item-password" class="form-item" style="z-index: 12;">
<!--						<label>身份证号：</label>-->
                        <i class="IdCardNum"></i>
						<input type="text" id="user_idcard" class="field re_user_password" autocomplete="off" maxlength="20" placeholder="请输入您的身份证号" default="<i class=i-def></i><?=$user_idcard?>" >
	                    <i class="i-status"></i>
					</div>
					<div class="input-tip">
						<span></span>
					</div>

					<div>
						<button type="submit" class="btn-register" onclick="mebidClick()">下一步</button>
					</div>
				</form>
			</div>
		</div>
	</div>
<!--    遮盖层-->



	
		<div id="sss" style="display: none" class="timeSelect">
<!--			<div id="header"><a href="javascript:history.go(-1)" class="back-pre"></a>会员编号</div>-->
            <div class="backdropBox">
		    <div class="main clearfix BdSon" id="form-main">
		        <div class="reg-form fl">
		            <form action="" id="register-form4" method="post" novalidate="novalidate"  onsubmit="return false;">
		                <div style="text-align: center" class="MemberNumber">
		                    <h3>您的会员编号是：</h3>
		                  	<p id="member_id">xxxxx</p>
		                </div>
		                
		                <div class="Bn_popup">
		                    <button type="submit" class="btn-register" onclick="logClick()">返回登录</button>
		                </div>

		            </form>
		        </div>
		    </div>
            </div>
		</div>
		
	<?php
	include $this->view->getTplPath() . '/' . 'footer.php';
	?>
</div>

<script>

	var check_type = <?=$reg_row['reg_checkcode']['config_value']?>;
	var pwdLength = <?=$reg_row['reg_pwdlength']['config_value']?>

	var form_account = $("#re_user_account");
	var form_pwd = $("#re_user_password");
	var form_rpwd = $("#form-equalTopwd");
	var form_mobile = $("#re_user_mobile");
    var form_email = $("#re_user_email");
	var form_authcode = $("#form-authcode");

	suggestsList = {};
	function get_randfunc(obj)
	{
		var sj = new Date();
		url = obj.src;
		obj.src = url + '?' + sj;
	}
	var icons = {
		def: '<i class="i-def"></i>',
		error: '<i class="i-error"></i>',
		weak: '<i class="i-pwd-weak"></i>',
		medium: '<i class="i-pwd-medium"></i>',
		strong: '<i class="i-pwd-strong"></i>'
	};

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

	var weakPwds = [
	];

	function filterKey(e) {
		var excludedKeys = [13, 9, 16, 17, 18, 20, 35, 36, 37, 38,
			39,
			40, 45, 144, 225
		];
		return $.inArray(e.keyCode, excludedKeys) !== -1;
	}

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

	//显示提示语
	function showTip(e)
	{
		var msg = $(e).attr('default');

		if(!$(e).parent().next().find("span").html())
		{
			$(e).parent().next().find("span").html(msg);
		}


	}

	function getStringLength(str){
		if(!str){
			return;
		}
		var bytesCount=0;
		for (var i = 0; i < str.length; i++)
		{
			var c = str.charAt(i);
			if (/^[\u0000-\u00ff]$/.test(c))
			{
				bytesCount += 1;
			}
			else
			{
				bytesCount += 2;
			}
		}
		return bytesCount;
	}

 
    function mebidClick(){
    
        user_name  	= $('#user_name').val(); //用户名
        user_idcard = $('#user_idcard').val();


        if (!user_name) {
            return Public.tips.alert('请输入您的真实姓名');
        }
        if (!user_idcard) {
            return Public.tips.alert('请输入您的身份证号');
        }

        

        var params = {
            "user_name": user_name,  
            "user_idcard": user_idcard
        };


        var ajaxurl = './index.php?ctl=Login&met=findmebid&typ=json&';
		$.ajax({
			type: "POST",
			url: ajaxurl,
			dataType: "json",
			async: false,
			data: params,
			success: function (respone)
			{
				if(respone.status == 200){
          			$("#form-main").css("display","none");
                    $("#member_id").text(respone.data['MemberID']);
                    $("#sss").css("display","block");
                    $("#aaa").css("display","none");
                }else{
                	Public.tips.alert('失败，'+respone.msg);
                    //三秒后跳转首页
                    return;
                }
			}
		});

    }


	function logClick(){
		window.location.href = '<?=sprintf('%s?ctl=Login&met=index&t=%s&from=%s&callback=%s', Yf_Registry::get('url'), request_string('t'), request_string('from'), urlencode(request_string('callback')))?>';

	}
    

</script>
</body>

</html>