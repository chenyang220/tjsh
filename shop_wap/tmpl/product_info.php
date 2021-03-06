<?php 
include __DIR__.'/../includes/header.php';
?>
<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-touch-fullscreen" content="yes" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="msapplication-tap-highlight" content="no" />
    <meta name="viewport" content="initial-scale=1,maximum-scale=1,minimum-scale=1" />
    <title>商品详情</title>
    <!-- 002 -->
    <link rel="stylesheet" type="text/css" href="../css/base.css">
    <link rel="stylesheet" type="text/css" href="../css/nctouch_products_detail.css">
    <link rel="stylesheet" type="text/css" href="../css/NewgoodsDetails.css">
</head>

<body>
    <header id="header" class="posf">
        <div class="header-wrap">
            <div class="header-l">
                <a href="javascript:history.go(-1)"> <i class="back"></i> </a>
            </div>
            <ul class="header-nav">
                <li><a href="javascript:void(0);" id="goodsDetail">商品</a></li>
                <li class="cur"><a href="javascript:void(0);" id="goodsBody">详情</a></li>
                <li id="eval"></li>
                <li><a href="javascript:void(0);" id="goodsRecommendation">推荐</a></li>
            </ul>
            <div class="header-r"><a id="header-nav" href="javascript:void(0);"><i class="more"></i><sup></sup></a> </div>
        </div>
        <div class="nctouch-nav-layout">
            <div class="nctouch-nav-menu"> <span class="arrow"></span>
                <ul>
                    <li><a href="../index.html"><i class="home"></i>首页</a></li>
                    <li><a href="../tmpl/search.html"><i class="search"></i>搜索</a></li>
                    <li><a href="../tmpl/cart_list.html"><i class="cart"></i>购物车<sup></sup></a></li>
                    <li><a href="../tmpl/member/member.html"><i class="member"></i>我的商城</a></li>
                    <li><a href="javascript:void(0);"><i class="message"></i>消息<sup></sup></a></li>
                </ul>
            </div>
        </div>
    </header>
        <div class="nctouch-main-layout" id="fixed-tab-pannel">

        <div class="fixed-tab-pannel" >

        </div>
    </div>
    <!-- <div class="nctouch-main-layout" id="fixed-tab-pannel">
        <div class="fixed-tab-pannel"></div>
    </div> -->
    <footer id="footer"></footer>
    <script type="text/javascript" src="../js/zepto.min.js"></script>
    <script type="text/javascript" src="../js/simple-plugin.js"></script>
    
    <script type="text/javascript" src="../js/common.js"></script>
    <script type="text/javascript" src="../js/tmpl/product_info.js"></script>
    <script type="text/javascript" src="../js/tmpl/footer.js"></script>
</body>
<script>
</script>
</html>
<?php 
include __DIR__.'/../includes/footer.php';
?>