<?php 
include __DIR__.'/../../includes/header.php';
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
    <title>售后列表</title>
    <link rel="stylesheet" type="text/css" href="../../css/base.css">
    <link rel="stylesheet" type="text/css" href="../../css/nctouch_member.css">
    <link rel="stylesheet" href="../../css/iconfont.css">
    <link rel="stylesheet" type="text/css" href="../../css/nctouch_member.css">
    <link rel="stylesheet" type="text/css" href="../../css/App-afterSale.css">
</head>

<body>
    <header id="header">
        <div class="header-wrap">
            <div class="header-l">
                <a href="member.html"> <i class="back"></i> </a>
            </div>
            <div class="header-title">
                <h1>申请售后</h1>
            </div>
            <div class="header-r"> <a id="header-nav" href="javascript:void(0);"><i class="more"></i><sup></sup></a> </div>
        </div>
        <div class="nctouch-nav-layout">
            <div class="nctouch-nav-menu"> <span class="arrow"></span>
                <ul>
                    <li><a href="../../index.html"><i class="home"></i>首页</a></li>
                    <li><a href="../search.html"><i class="search"></i>搜索</a></li>
                    <li><a href="javascript:void(0);"><i class="message"></i>消息<sup></sup></a></li>
                </ul>
            </div>
        </div>
    </header>
    <div class="nctouch-main-layout">
        <div class="nctouch-order-list">
            <ul id="refund-list">
            </ul>
        </div>
    </div>
    <div class="fix-block-r">
        <a href="javascript:void(0);" class="gotop-btn gotop hide" id="goTopBtn"><i></i></a>
    </div>
    <footer id="footer" class="bottom"></footer>
    <script type="text/html" id="refund-list-tmpl">
        <% var refund_list = items; %>
        <% if (refund_list.length > 0){%>
            <% for(var i = 0;i<refund_list.length;i++){
	%>
                <li class=" <%if(i>0){%>mt-20<%}%>">
                    <div class="scheduleBox">
                    <a class="storeBox" href="">
                        <i class="storeIcon"></i>
                        <p class="storeName"><%=refund_list[i].seller_user_account%></p>
                        <i class="arrowsR"></i>
                    </a>
                        <div class="nctouch-order-item-con nctouch-order-item-con-cart">

                    <div class="goods-block">
                        <a href="javascript:void(0);" class="clearfix wp100">
                            <ul class="scheduleMe">
                                <li><p class="">申请退款原因 ：</p><p class="CeMeR"><%=refund_list[i].return_reason%></p></li>
                                <li><p class="">退款订单号 ：</p><p class="CeMeR"><%=refund_list[i].order_number%></p></li>
                                <li></li>
                                <li><p class="">PV ：</p><p class="CeMeR"><%=refund_list[i].order_pv%></p></li>
                                <li><p class="">申请时间 ：</p><p class="CeMeR"><%=refund_list[i].return_add_time%></p></li>
                                <li><p class="">退货编号 ：</p><p class="CeMeR"><%=refund_list[i].return_code%></p></li>
                            </ul>
                        </a>
                        <div class="return-tips tr">
                            <!-- 退款状态 -->
                            <% if(refund_list[i].return_state==5){%>
                            <p class="statesAchieve"><i></i>处理完成</p>
                            <% } else if(refund_list[i].return_state==2 || refund_list[i].return_state==3 || refund_list[i].return_state==4 || refund_list[i].return_state==8) {%>
                            <p class="statesAchieve StInHand"><i></i>处理中</p>
                            <%}else if(refund_list[i].return_state==9){%><p class="statesAchieve StShut"><i></i>申请关闭</p><%}%>
                            <a style="width: 83px;text-align:center;padding-top:7px;" href="<%=WapSiteUrl%>/tmpl/member/member_refund_info.html?refund_id=<%=refund_list[i].order_return_id%>" class="achieveBndd">查看详情</a>
                        </div>
                    </div>
                </div>
            </div>
                </li>
                <%}%>
                    <% if (hasmore) {%>
                        <li class="loading">
                            <div class="spinner"><i></i></div>订单数据读取中...</li>
                        <% } %>
                            <%}else {%>
                                <div class="nctouch-norecord refund">
                                    <div class="norecord-ico"><i></i></div>
                                    <dl>
                                        <dt>您还没有退款信息</dt>
                                        <dd>已购订单详情可申请退款</dd>
                                    </dl>
                                </div>
                                <%}%>
    </script>
    <script type="text/javascript" src="../../js/zepto.min.js"></script>
    <script type="text/javascript" src="../../js/template.js"></script>
    
    <script type="text/javascript" src="../../js/common.js"></script>
    <script type="text/javascript" src="../../js/simple-plugin.js"></script>
    <script type="text/javascript" src="../../js/ncscroll-load.js"></script>
    <script type="text/javascript" src="../../js/tmpl/member_refund.js"></script>
    <script type="text/javascript" src="../../js/tmpl/footer.js"></script>

</body>
<style type="text/css">
.achieveBndd{
    right: 10px;
    height: 29px;
    font-size: 0.6rem;
    border-radius: 4px;
    outline: none;
    float: right;
    background-color: #f3f5f7;
    margin: 5px 0px 15px 0px;
    border: 1px solid #4d9e9c;
    color: #4d9e9c;
}
</style>
</html>
<?php 
include __DIR__.'/../../includes/footer.php';
?>
