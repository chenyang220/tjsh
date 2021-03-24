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
    <link rel="stylesheet" type="text/css" href="../css/base.css">
    <link rel="stylesheet" type="text/css" href="../css/nctouch_products_detail.css">
    <link rel="stylesheet" type="text/css" href="../css/NewgoodsDetails.css">
</head>

<body>
    <header id="header" class="posf">
        <div class="header-wrap">
            <div class="header-l">
                <span> <i class="back"></i> </span>
            </div>
            <ul class="header-nav">
                <li><a  id="goodsDetail">商品</a></li>
                <li class="cur"><a  id="goodsBody">详情</a></li>
                <li><a  id="goodsEvaluation">评价</a></li>
                <li><a  id="goodsRecommendation">推荐</a></li>
            </ul>
            <div class="header-r"><i class="more"></i><sup></sup> </div>
        </div>
    </header>
    <div class="nctouch-main-layout" id="fixed-tab-pannel">
        <div class="fixed-tab-pannel"></div>
    </div>
    <script type="text/javascript" src="../js/zepto.min.js"></script>
    <script type="text/javascript" src="../js/simple-plugin.js"></script>
    
    <script type="text/javascript" src="../js/common.js"></script>
   <script type="text/javascript" src="../js/tmpl/product_infoPreview.js"></script>

</body>

</html>
<?php 
include __DIR__.'/../includes/footer.php';
?>
