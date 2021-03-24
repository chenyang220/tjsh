
$(document).ready(function(){
    var url = ApiUrl + "index.php?ctl=Api_Wap&met=cache&typ=json";
    $.post(url,{},function(data){
        //alert(1);
    })
});

$(function () {
    //加载评价
    $.post(ApiUrl + "/index.php?ctl=Api_Wap&met=version&typ=json",{},function(a){
        if(a.status ==200){
            $.cookie('goods_evaluate',a.data.goods_evaluate);
        }
    });
    ucenterLogin();
});
$(function () {
    if (getQueryString('key') != '') {
        var key = getQueryString('key');
        var username = getQueryString('username');
        addCookie('key', key);
        addCookie('username', username);
        updateCookieCart(key);
    } else {
        var key = getCookie('key');
    }
    
    if (key) {
        $.ajax({
            type: 'post',
            url: ApiUrl + "/index.php?ctl=Buyer_User&met=getUserInfo&typ=json",
            data: {k: key, u: getCookie('id')},
            dataType: 'json',
            //jsonp:'callback',
            success: function (result) {
                if (result.status == 250) {
                    return false;
                }
                checkLogin(result.login);
                if (typeof(result.data.money.user_money) == 'undefined') {
                    $('#user_money').html("￥0");
                } else {
                    $('#user_money').html("￥" + result.data.money.user_money);
                }
                if (typeof(result.data.points.user_points) == 'undefined') {
                    $('#user_points').html('0');
                } else {
                    $('#user_points').html(result.data.points.user_points);
                }
                
                var html = '<div class="mine-head-bg"><div class="member-info">'
                    + '<div class="user-avatar"> <a href=" ' + UCenterApiUrl + '"><img src="' + result.data.user_logo + '"/> </a></div>'
                    + '<div class="user-name"> <span><strong>' + result.data.user_name + '</strong><sup>V' + result.data.user_grade + '</sup></span> </div>'
                    + '</div></div>';
                //渲染页面
                
                $(".member-top").html(html);
                var html = '<span><a href="favorites.html"><em>' + result.data.favorites_goods_num + '</em>'
                    + '<p>商品收藏</p>'
                    + '</a> </span><span><a href="favorites_store.html"><em>' + result.data.favorites_shop_num + '</em>'
                    + '<p>店铺收藏</p>'
                    + '</a> </span><span><a href="views_list.html"><em>' + result.data.footprint_goods_num + '</em>'
                    + '<p>我的足迹</p>'
                    + '</a> </span>';
                
                $(".member-collect").html(html);
                if(result.data.goods_evaluate == 1){
                    var html = '<li><a href="order_list.html?data-state=wait_pay"><i class="cc-01"></i><p>待付款</p></a>' + (result.data.order_count.wait > 0 ? '<b>' + result.data.order_count.wait + '</b>' : '') + '</li>'
                        + '<li><a href="order_list.html?data-state=order_payed"><i class="cc-02"></i><p>待发货</p></a>' + (result.data.order_count.payed > 0 ? '<b>' + result.data.order_count.payed + '</b>' : '') + '</li>'
                        + '<li><a href="order_list.html?data-state=wait_confirm_goods"><i class="cc-03"></i><p>待收货</p></a>' + (result.data.order_count.confirm > 0 ? '<b>' + result.data.order_count.confirm + '</b>' : '') + '</li>'
                        + '<li><a href="order_list.html?data-state=finish"><i class="cc-04"></i><p>待评价</p></a>' + (result.data.order_count.finish > 0 ? '<b>' + result.data.order_count.finish + '</b>' : '') + '</li>'
                        + '<li><a href="member_refund.html"><i class="cc-05"></i><p>售后</p></a>' + (result.data.order_count.return > 0 ? '<b>' + result.data.order_count.return + '</b>' : '') + '</li>';
                }else{
                    var html = '<li class="cccc"><a href="order_list.html?data-state=wait_pay"><i class="cc-01"></i><p>待付款</p></a>' + (result.data.order_count.wait > 0 ? '<b>' + result.data.order_count.wait + '</b>' : '') + '</li>'
                        + '<li class="cccc"><a href="order_list.html?data-state=order_payed"><i class="cc-02"></i><p>待发货</p></a>' + (result.data.order_count.payed > 0 ? '<b>' + result.data.order_count.payed + '</b>' : '') + '</li>'
                        + '<li class="cccc"><a href="order_list.html?data-state=wait_confirm_goods"><i class="cc-03"></i><p>待收货</p></a>' + (result.data.order_count.confirm > 0 ? '<b>' + result.data.order_count.confirm + '</b>' : '') + '</li>'
                        + '<li class="cccc"><a href="member_refund.html"><i class="cc-05"></i><p>售后</p></a>' + (result.data.order_count.return > 0 ? '<b>' + result.data.order_count.return + '</b>' : '') + '</li>';
                }

                //渲染页面
                
                $("#order_ul").html(html);
                if (result.data.directseller_is_open > 0) {
                    var html = '<dl class="mt5">' +
                        '<dt>' +
                        '<a id="distribution" href="directseller.html">' +
                        '<h3><i class="mc-06"></i>分销中心</h3>' +
                        '<h5><i class="arrow-r"></i></h5>' +
                        '</a>' +
                        '</dt>' +
                        '</dl>';
                    $(".member-center").append(html);
                }
                if (result.data.fenxiao_is_open > 0) {
                    var html = '<dl class="mt5">' +
                        '<dt>' +
                        '<a id="distribution" href="fenxiao.html">' +
                        '<h3><i class="mc-06"></i>分销中心</h3>' +
                        '<h5><i class="arrow-r"></i></h5>' +
                        '</a>' +
                        '</dt>' +
                        '</dl>';
                    $(".member-center").append(html);
                }
                
                if (result.data.shop_type == 1 && result.data.distribution_is_open == 1 && !result.data.fenxiao_is_open) {
                    var html = '<dl class="mt5">' +
                        '<dt>' +
                        '<a id="distribution" href="distlog.html">' +
                        '<h3><i class="mc-07"></i>分销明细</h3>' +
                        '<h5><i class="arrow-r"></i></h5>' +
                        '</a>' +
                        '</dt>' +
                        '</dl>';
                    $(".member-center").append(html);
                }
                
                return false;
            }
        });
    } else {
        var html = '<div class="mine-head-bg"><div class="member-info">'
            + '<a class="default-avatar logbtn" href="javascript:void(0);" style="display:block;"></a>'
            + '<a class="to-login logbtn" href="javascript:void(0);">登录</a>'
            + '<a class="to-login" id="regbtn" href="javascript:void(0);"> | 注册</a>'
            + '</div></div>'
            // + '<div class="sign"><a class="logbtn" href="javascript:void(0);"><i class="goods-sign"></i><b class="middle">签到</b></a></div>';

        //渲染页面
        $(".member-top").html(html);
        // var html = '<div class="member-collect"><span><a class="logbtn" href="javascript:void(0);"><em>0</em>'
        //     + '<p>商品收藏</p>'
        //     + '</a> </span><span><a class="logbtn" href="javascript:void(0);"><em>0</em>'
        //     + '<p>店铺收藏</p>'
        //     + '</a> </span><span><a class="logbtn" href="javascript:void(0);"><em>0</em>'
        //     + '<p>我的足迹</p>'
        //     + '</a> </span></div>';
        var html = '<div class="ShoppingLi"><a class="logbtn"><i class="cc-01"></i><p>待付款</p></a></div>'
            + '<div class="ShoppingLi"><a class="logbtn"><i class="cc-02"></i><p>待发货</p></a></div>'
            + '<div class="ShoppingLi"><a class="logbtn"><i class="cc-03"></i><p>待收货</p></a></div>'
            + '<div class="ShoppingLi"><a class="logbtn"><i class="cc-05"></i><p>售后</p></a></div>';
        $(".member-collect").html(html);

        if(getCookie('goods_evaluate') == 1){
            var html = '<li><a class="logbtn"><i class="cc-01"></i><p>待付款</p></a></li>'
                + '<li><a class="logbtn"><i class="cc-02"></i><p>待发货</p></a></li>'
                + '<li><a class="logbtn"><i class="cc-03"></i><p>待收货</p></a></li>'
                + '<li><a class="logbtn"><i class="cc-04"></i><p>待评价</p></a></li>'
                + '<li><a class="logbtn"><i class="cc-05"></i><p>售后</p></a></li>';
        }else{
            var html = '<li class="cccc"><a class="logbtn "><i class="cc-01"></i><p>待付款</p></a></li>'
                + '<li class="cccc"><a class="logbtn "><i class="cc-02"></i><p>待发货</p></a></li>'
                + '<li class="cccc"><a class="logbtn "><i class="cc-03"></i><p>待收货</p></a></li>'
                + '<li class="cccc"><a class="logbtn "><i class="cc-05"></i><p>售后</p></a></li>';
        }

        //渲染页面
        $("#order_ul").html(html);
        // $("#member-collectl").html(html);
        return false;
    }
    
    //滚动header固定到顶部
    $.scrollTransparent();

    $("#paycenter,.paycenter").click(function () {
        window.location.href = PayCenterWapUrl;
    });


});