<?php
    include __DIR__ . '/../../includes/header.php';
?>
<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-touch-fullscreen" content="yes"/>
    <meta name="format-detection" content="telephone=no"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black"/>
    <meta name="format-detection" content="telephone=no"/>
    <meta name="msapplication-tap-highlight" content="no"/>
    <meta name="viewport" content="initial-scale=1,maximum-scale=1,minimum-scale=1"/>
    <title>购物说明</title>
    <link rel="stylesheet" type="text/css" href="../../css/base.css">
    <link rel="stylesheet" type="text/css" href="../../css/nctouch_member.css">
    <link rel="stylesheet" type="text/css" href="../../css/nctouch_products_list.css">
</head>
<style type="text/css">
    *{
        background: rgb(255,255,255);
    }
</style>
<body>
<header id="header" class="fixed">
    <div class="header-wrap">
        <div class="header-l">
            <a href="member.html"> <i class="back"></i> </a>
        </div>
        <div class="header-tab" style="margin: 0 0">
            <!-- <a href="javascript:void(0);" class="cur">商品收藏</a> -->
            <h1 style="font-size: 0.818rem;line-height: 2rem;height: 2rem;">购物说明</h1>
            <!-- <a href="favorites_store.html">店铺收藏</a> -->
        </div>
        <div class="header-r"><a id="header-nav" href="javascript:void(0);"><i class="more"></i><sup></sup></a></div>
    </div>
    <div class="nctouch-nav-layout">
        <div class="nctouch-nav-menu"><span class="arrow"></span>
            <ul>
                <li><a href="../../index.html"><i class="home"></i>首页</a></li>
                <li><a href="../search.html"><i class="search"></i>搜索</a></li>
                <li><a href="javascript:void(0);"><i class="message"></i>消息<sup></sup></a></li>
            </ul>
        </div>
    </div>
</header>
<div class="nctouch-main-layout">
    <div class="grid">

    </div>
</div>
<div class="fix-block-r">
    <a href="javascript:void(0);" class="gotop-btn gotop hide" id="goTopBtn"><i></i></a>
</div>
<footer id="footer" class="bottom"></footer>

<script type="text/javascript" src="../../js/zepto.min.js"></script>
<script type="text/javascript" src="../../js/template.js"></script>
<script type="text/javascript" src="../../js/common.js"></script>
<script type="text/javascript" src="../../js/simple-plugin.js"></script>
<script type="text/javascript" src="../../js/ncscroll-load.js"></script>
<script type="text/javascript" src="../../js/tmpl/footer.js"></script>
</body>
<script type="text/javascript">
    $.ajax({
            type: "post",
            url: ApiUrl + "/index.php?ctl=Article_Base&met=getArticleBase&typ=json",
            data: {article_id:15},
            dataType: "json",
            success: function (e) {
                $(".grid").html(e.data.article_desc)
            }
        });
    // https://www.sunhopego.cn/bbc_tjsh/shop/index.php?ctl=Article_Base&met=index&article_id=15
</script>
</html>
<?php
    include __DIR__ . '/../../includes/footer.php';
?>
