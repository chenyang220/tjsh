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
    <title>商品收藏</title>
    <link rel="stylesheet" type="text/css" href="../../css/base.css">
    <link rel="stylesheet" type="text/css" href="../../css/nctouch_member.css">
    <link rel="stylesheet" type="text/css" href="../../css/nctouch_products_list.css">
</head>

<body>
<header id="header" class="fixed">
    <div class="header-wrap">
        <div class="header-l">
            <a href="member.html"> <i class="back"></i> </a>
        </div>
        <div class="header-tab" style="margin: 0 0">
            <!-- <a href="javascript:void(0);" class="cur">商品收藏</a> -->
            <h1 style="font-size: 0.818rem;line-height: 2rem;height: 2rem;">商品收藏</h1>
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
        <ul class="goods-secrch-list fav-list" id="favorites_list"></ul>
    </div>
</div>
<div class="fix-block-r">
    <a href="javascript:void(0);" class="gotop-btn gotop hide" id="goTopBtn"><i></i></a>
</div>
<footer id="footer" class="bottom"></footer>
<script type="text/html" id="sfavorites_list">
    <%if(typeof(items)!='undefined' && items.length>0){%>
    <% for (var k in items) { var v = items[k]['detail']; %>
    <li class="goods-item" id="favitem_<%=v.goods_id %>">
        <a href="<%=WapSiteUrl%>/tmpl/product_detail.html?goods_id=<%=v.goods_id %>"> <span class="goods-pic"><img src="<%=$image_thumb(v.goods_image, 306, 306) %>"/></span>
            <dl class="goods-info">
                <dt class="goods-name"><h4 class="more-overflow"><%=v.goods_name %></h4></dt>
            </dl>
            <dd class="goods-sale">
                <span class="goods-price">￥<em><%=v.goods_price %></em></span>
            </dd>
        </a> <a href="javascript:void(0);" nc_type="fav_del" data_id="<%=v.goods_id %>" class="fav-del"></a>
    </li>
    <%}%>
    <li class="loading">
        <div class="spinner"><i></i></div>
        数据读取中
    </li>
    <%}else{%>
    <div class="nctouch-norecord favorite-goods">
        <div class="norecord-ico"><i></i></div>
        <dl>
            <dt>您还没有关注任何商品</dt>
            <dd>可以去看看哪些商品值得收藏</dd>
        </dl>
        <a href="<%=WapSiteUrl%>" class="btn">随便逛逛</a>
    </div>
    <%}%>
</script>

<script type="text/javascript" src="../../js/zepto.min.js"></script>
<script type="text/javascript" src="../../js/template.js"></script>
<script type="text/javascript" src="../../js/common.js"></script>
<script type="text/javascript" src="../../js/simple-plugin.js"></script>
<script type="text/javascript" src="../../js/ncscroll-load.js"></script>
<script type="text/javascript" src="../../js/tmpl/favorites.js"></script>
<script type="text/javascript" src="../../js/tmpl/footer.js"></script>
</body>

</html>
<?php
    include __DIR__ . '/../../includes/footer.php';
?>
