<?php
    include __DIR__ . '/../../includes/header.php';
?>
<!DOCTYPE html>
<html lang="zh">

	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-touch-fullscreen" content="yes">
		<meta name="format-detection" content="telephone=no">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="format-detection" content="telephone=no">
		<meta name="msapplication-tap-highlight" content="no">
		<meta name="viewport" content="initial-scale=1,maximum-scale=1,minimum-scale=1,viewport-fit:cover;">
		<title>账号管理</title>
		<link rel="stylesheet" type="text/css" href="../../css/base.css">
		<link rel="stylesheet" type="text/css" href="../../css/nctouch_member.css">
	</head>

	<body>
		<header id="header">
			<div class="header-wrap">
				<div class="header-l">
					<a href="javascript:history.go(-1)"> <i class="back"></i> </a>
				</div>
				<div class="header-title">
					<h1>账号管理</h1>
				</div>
			</div>
		</header>
		<div class="account-management">
			<!-- <a href="javascript:;">
				<h3><i class="new-mc1"></i>微信</h3>
				<h5><span>未绑定<span><i  class="arrow-r btn-bind"></i></h5>
			</a> -->
			<a href="javascript:;">
				<h3><i class="new-mc1"></i>修改登录密码</h3>
				<h5><i class="arrow-r ucenter"></i></h5>
			</a>

		</div>
		<a id="logoutbtn" class="account-login" href="javascript:;">退出登录</a>
    <script type="text/javascript" src="../../js/zepto.js"></script>
    <script type="text/javascript" src="../../js/common.js"></script>
    <script type="text/javascript" src="../../js/jquery.js"></script>
    <script type="text/javascript" src="../../js/jquery.cookie.js"></script>
    <script type="text/javascript" src="../../js/tmpl/member_account.js"></script>
    <script type="text/javascript" src="../../js/tmpl/footer.js"></script>

    <script type="text/javascript">
        var key = getCookie('key');

	    if(!key) {
	        var login_url   = UCenterApiUrl + '?ctl=Login&met=index&typ=e';
	        window.location.href = login_url;
	    }

		$(".ucenter").click(function () {
	        window.location.href = UCenterApiUrl+'?ctl=User&met=passwd';
	    });
	    $('.btn-bind').click(function(){
		    var url = encodeURIComponent(UCenterApiUrl);
		    location.href = UCenterApiUrl+'?ctl=Connect_Weixin&met=login'+'&callback='+url;
		   });
	    var ajaxurl = UCenterApiUrl+'?ctl=User&met=wxAccount&typ=json';
        $.ajax({
            type: "POST",
            url: ajaxurl,
            dataType: "json",
            data: {k: getCookie('key'), u: getCookie('id')},
            success: function (respone) {
                if (respone.data) {
                	$(".btn-bind").prev('span').html('已绑定:');
                	$('.btn-bind').removeClass('btn-bind');
                    return false;
                }else{
                
                    // verify_code = 1;
                }
            }
        });
	</script>	
	</body>				

<?php
    include __DIR__ . '/../../includes/footer.php';
?>
</html>