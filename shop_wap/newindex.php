
<?php

    include __DIR__.'/includes/header.php';
    if($_GET['merOrderId'])
    {
        header("location:./tmpl/member/order_list.html");
        die;
    }
    if($_GET['qr']){
            setcookie('is_app_guest',1,time()+86400*366);
            $_COOKIE['is_app_guest'] = 1;
    }
?>
<!DOCTYPE html>
<html lang="en">

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
    <meta name="viewport" content="initial-scale=1,maximum-scale=1,minimum-scale=1,viewport-fit=cover;">
    <title><?php echo __('');?>首页</title>
       <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="Shortcut Icon" href="favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/new-style.css">
    <link rel="stylesheet" href="./css/index-swiper.css">
    <link rel="stylesheet" href="./css/swiper.min.css">
    <link rel="stylesheet" href="./css/nctouch_member.css">
    <link rel="stylesheet" href="./css/homePage.css">
    <link href="./video/css/video-js.min.css" rel="stylesheet">
    <script src="./js/jquery.js"></script>
    <script src="./js/swiper.min.js"></script>
    <script src="./js/jquery.js"></script>
</head>


<body class="fz-0">
    <!-- 搜索 -->
    <div class="head-fixed scroll-bg">
        <div class="head-ser">
<!--             <div class="cohesive " id="cohesive_dev">
                    <i class="icon-ScanCode"></i>
<span class="city-text sub_site_name_span"><?php //echo __('全部');?><<i class="icon-city"></i></span>
            <i class="icon-drapdown"></i>
            </div> -->
            <a href="tmpl/search.html" class="header-inps header-It">
            <i class="icon"></i><span class="search-input" id="keyword"><?php echo __('请输入关键词');?></span>
            </a>
            <?php if($_COOKIE['is_app_guest']){ ?>
                <a class="qrcode_open scan" href="/qrcode_open"><i class="icon-scan"></i><span>扫一扫</span></a>
                <script>
                    if($(window).width()<360){
                        $(".header-inps").css("width","9rem");
                    }else{
                        $(".header-inps").css("width","10.5rem");
                    }

                </script>
            <?php }?>
                <a id="header-nav" class="message colf" onclick="go_message()"><i></i></a>
        </div>
    </div>
    <div class="bgf minBennerBox" style="margin-top: 2rem;">
       
            <div id="main-container1"></div>
       
            <ul id="index_nav" class="nav-class tc pb-20 pt-20 clearfix navigationBar ulControl">
                <!-- <li><a href="tmpl/integral.html"><i></i>
                    <p>营养保健</p>
                </a></li>
                <li><a href="tmpl/group_buy_index.html"><i></i>
                    <p>美容护肤</p>
                </a></li>
                <li><a href="tmpl/store-list.html"><i></i>
                    <p>居家生活</p>
                </a></li>
                <li><a href="tmpl/pintuan_index.html"><i></i>
                    <p>赫选组合</p>
                </a></li>
                <li><a href="tmpl/redpacket_plat.html"><i></i>
                    <p>商城独享</p>
                </a></li> -->
            </ul>

        <!-- <script type="text/javascript">
            if (window.paySiteName)
            {
                document.getElementById('pay_site_name').innerHTML = window.paySiteName;
            }

             function payurl(){
                window.open(PayCenterWapUrl);
              }
        </script> -->
    </div>
    <div class="nctouch-home-layout mrb150" id="main-container2"></div>

    <!--<p class="load-more tc">加载更多</p>-->

    <!-- 底部 -->
    <?php
                include __DIR__.'/includes/footer_menu.php';
        ?>

<script type="text/html" id="slider_list">
    <div class="relative">
        <div class="swiper-container swiper-container-index"  style="overflow:hidden;">
            <div class="swiper-wrapper">
                <% for (var i in item) { %>
                    <div class="swiper-slide">
                        <a href="<%= item[i].url %>">
                            <img src="<%= item[i].image %>" class="main-img">
                        </a>
                    </div>
                <% } %>
            </div>
        </div>
        <div class="swiper-pagination swiper-paginations" id="pagination"></div>
    </div>
</script>
<script type="text/html" id="home1">
    <div class="bgf GoodsShowBox">
        <div class="ad ">
            <a href="<%= url %>" class="tc"><img src="<%= image %>" alt=""><% if (title) { %><div class="class-tit"><span><%= title %></span></div><% } %> </a>
        </div>
    </div>
</script>
<script type="text/html" id="home2">
    <div class="bgf GoodsShowBox">
        <div class="module1">
            <% if (title) { %>
            <div class="common-tit tc">
                <h4 class="gg"><%= title %><i></i></h4>
            </div>
            <% } %>
            <!-- 布局一（1/3） -->
            <div class="layout1 layout-1 clearfix">
                <div class="big fl"><a href="<%= square_url %>"><img src="<%= square_image %>" alt=""></a></div>
                <div class="small clearfix fr">
                    <a href="<%= rectangle1_url %>" class="mrb22 fr"><img src="<%= rectangle1_image %>" alt=""></a><a href="<%= rectangle2_url %>" class="fr"><img src="<%= rectangle2_image %>" alt=""></a>
                </div>
            </div>
        </div>
    </div>
</script>
<script type="text/html" id="home3">

    <div class="bgf GoodsShowBox" name="002">
        <% if (title) { %>
        <div class="common-tit tc">
                <h4 class="gg"><%= title %><i></i></h4>
        </div>
        <% } %>
        <div class="layout2">
            <ul class="clearfix"><a href="www.baidu.com" target="_ba" class="tc"><img style="width:100%;" src="<%= image %>" alt=""></a></ul>
            <ul class="clearfix">
                <% for (var i in item) { %>
                <li class="clearfix MnBrSon"><a class="MnBrA" href="<%= item[i].url %>"><img src="<%= item[i].image %>" alt=""></a>
                    <p class="GsBnNmP"><%= item[i].image_shop_name %></p>
                </li>
                <% } %>
            </ul>
        </div>
    </div>
</script>
<script type="text/html" id="home5">
    <div class="bgf">
        <% if (title) { %>
        <div class="common-tit tc">
            <h4 class='fz-32'><%= title %></h4>
        </div>
        <% } %>
        <div class="layout3">
            <ul class="clearfix">
                <% for (var i in item) { %>
                <li><a style="display: inline-block;" href="<%= item[i].url %>"><img src="<%= item[i].image %>" alt=""></a></li>
                <% } %>
            </ul>
        </div>
    </div>
</script>
<style type="text/css">
    .common-tit>h4>i{
/*        width: 0.9rem;
        height: 0.9rem;
        display: inline-block;
        background: url(./images/wap2_45.png) no-repeat center;
        background-size: contain;
        vertical-align: middle;
        margin-left: 0.5rem;
        margin-top: -2.6px;*/
    }
    .gg{
        font-size: 0.7rem;
        color: black;
        letter-spacing:0!important;
    }
    .layout2 li:nth-child(1){
        float: none;
        width: 95%;
        height: 37.6vw;
    }
</style>
<script type="text/html" id="home4">
    <div class="bgf">
        <% if (title) { %>
            <div class="common-tit tc">
                <h4 class="gg"><%= title %><i></i></h4>
            </div>
        <% } %>
            <div class="layout1 layout-2 clearfix">
                <div class="small fl clearfix">
                    <a href="<%= rectangle1_url %>" class="mrb22 fl"><img src="<%= rectangle1_image %>" alt=""></a><a href="<%= rectangle2_url %>" class="fl"><img src="<%= rectangle2_image %>" alt=""></a>
                </div>
                <div class="big fr"><a href="<%= square_url %>"><img src="<%= square_image %>" alt=""></a></div>
            </div>
    </div>
</script>
<script type="text/html" id="goods">
    <div class="bgf">
        <% if (title) { %>
        <div class="common-tit tc">
            <h4 class="gg"><%= title %><i></i></h4>
        </div>
        <% } %>

        <ul class="new-goods clearfix bgf5">
            <% for (var i in item) { %>
            <li class="bgf"><a href="tmpl/product_detail.html?goods_id=<%= item[i].goods_id %>">
                    <div class="overhide"><div class="table"><span class="img-area"><img src="<%= item[i].goods_image %>" alt=""></span></div></div>
                    <h5 class="fz-28 col2 more-overflow pt-20"><%= item[i].goods_name %></h5>
                    <b class="fz-30 pl-10 pr-10 mb-20 mt-20">￥<%= item[i].goods_promotion_price %></b>
                </a>
            </li>
            <% } %>
        </ul>
    </div>
</script>
<div class="GoodsShowBox VideoGoodsList hide" id="zhibosss" >
<div class="GoodsHt">
<!--    0013-->
    <a>精彩直播<i></i></a>
</div>
<div class="m GsVideo">
    <video id="my-video" class="video-js vjs-fluid" preload='Metadata' controls >
        <source id="source" src="https://videocdn.taobao.com/oss/taobao-ugc/af6e0b45e78b45639559d790f167dec7/1467464224/video.mp4" type="video/mp4">
        <source src="movie.mp4" type="video/mp4">
        <source src="movie.ogg" type="video/ogg"> 您的浏览器不支持 HTML5 播放器。
    </video>

</div>
    <div class="BuyNowBox ByNwBx_b" id="buy1" style="display: none;">
        <a href="" id="url1">
            <img style="width: 100%;" src="" id="images1">
        </a>
    </div>
    <div class="BuyNowBox ByNwBx_b" id="buy2" style="display: none;">
        <a href="" id="url2">
            <img style="width: 100%;" src="" id="images2">
        </a>
    </div>
    <div class="BuyNowBox ByNwBx_b" id="buy3" style="display: none;">
        <a href="" id="url3">
            <img style="width: 100%;" src="" id="images3">
        </a>
    </div>
    </div>

<script type="text/javascript" src="js/swiper.min.js"></script>
<script type="text/javascript" src="js/zepto.min.js"></script>
<script type="text/javascript" src="js/template.js"></script>
<script type="text/javascript" src="js/common.js"></script>
<script type="text/javascript" src="js/index.js"></script>
<script type="text/javascript" src="js/tmpl/footer.js"></script>
<script type="text/javascript" src="js/addtohomescreen.js"></script>
<script src="video/js/video.min.js"></script> 
<script src="https://vjs.zencdn.net/5.19/lang/zh-CN.js"></script>
<script type="text/javascript">
            var myPlayer = videojs('my-video');
            // videojs("my-video").ready(function(){
            //     var myPlayer = this;
            //     myPlayer.play();
            //     myPlayer.pause();
            // });              
</script> 
<script>
    addToHomescreen({
            message:'如要把应用程式加至主屏幕,请点击%icon, 然后<strong>加至主屏幕</strong>'
    });
    $('.logbtn').click(function(){
        if(getCookie('id')){
            $(".logbtn").attr("href","tmpl/member/signin.html");
        }
    });
    function initialize() {
        // 百度地图API功能
        var geolocation = new BMap.Geolocation();
        var geoc = new BMap.Geocoder();
        geolocation.getCurrentPosition(function(r){
            if(this.getStatus() == BMAP_STATUS_SUCCESS){
                var mk = new BMap.Marker(r.point);
                window.coordinate = {'lng':r.point.lng, lat:r.point.lat};
                geoc.getLocation(r.point, function(rs){
                    var addComp = rs.addressComponents;

                    if(addComp.province != null && addComp.province != 'undefined' && addComp.province != ''){
                        // var addressStr = "province:"+ addComp.province + ",city:" + addComp.city + ",district:" + addComp.district + ",street:" + addComp.street + ",streetnumber:" + addComp.streetNumber;
                        // addCookie('lbs_geo',addressStr);
                        //获取分站信息
                        window.addressStr = addComp.province + ", " + addComp.city + ", " + addComp.district + ", " + addComp.street + ", " + addComp.streetNumber;
                        $.post(ApiUrl + "/index.php?ctl=Base_District&met=getLocalSubsiteWap&typ=json&ua=wap",{province:addComp.province,city:addComp.city,district:addComp.district,street:addComp.street},function(result){

                              if(result.status == 200){
                                  addCookie('sub_site_id',result.data.subsite_id,0);
                              }else{
                                  addCookie('sub_site_id',0,0);
                              }
                              window.location.reload();
                        },'json');
                    }
                });
            } else {
                alert('failed'+this.getStatus());
            }
        },{enableHighAccuracy: true})
    }

    function loadScriptSubsite() {
        var script = document.createElement("script");
        script.src = "//api.map.baidu.com/api?v=2.0&ak=5At3anZe83x8oOpFap42Gt8eHYpy3wm9&callback=initialize";//此为v2.0版本的引用方式
        document.body.appendChild(script);

    }

    function go_message(){
        if(!getCookie('key')){
            window.location.href = ShopWapUrl+'/tmpl/member/login.html';
        }else{
            window.location.href = ShopWapUrl+'/tmpl/member/chat_list.html';
        }
    }
</script>

<script>
    $(function(){
        var userAgentInfo = /iphone/gi.test(navigator.userAgent) && (screen.height == 812 && screen.width == 375);
        if(userAgentInfo==true){
            $(".footer").css("padding-bottom","34px");

        }
    })
</script>
</body>
<!--<script>-->
<!--    function A() {-->
<!--        loadScriptSubsite();-->
<!--        if ($("#main-container1").children().length == 0) {-->
<!--            $(".js-nav-class").css("margin-top", "2rem");-->
<!--        }-->
<!--    }-->
<!---->
<!--    $(function () {-->
<!--        setTimeout("A()", 1000);-->
<!--    });-->
<!---->
<!--</script>-->

</html>
<?php
include __DIR__.'/includes/footer.php';
?>
