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
    <meta name="format-detection" content="telephone=no"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="msapplication-tap-highlight" content="no" />
    <meta name="viewport" content="initial-scale=1,maximum-scale=1,minimum-scale=1" />
    <title>售后详情</title>
    <link rel="stylesheet" type="text/css" href="../../css/base.css">
    <link rel="stylesheet" type="text/css" href="../../css/nctouch_member.css">
    <link rel="stylesheet" type="text/css" href="../../css/App-afterSale.css">
</head>
<body>
<header id="header">
    <div class="header-wrap">
        <div class="header-l"> <a href="javascript:history.go(-1)"> <i class="back"></i> </a> </div>
    <span class="header-title">
    <h1>售后详情</h1>
    </span>
    </div>
</header>
<div class="nctouch-main-layout" id="refund-info-div"> </div>
<footer id="footer"></footer>
<script type="text/html" id="refund-info-script">
   <div class="statetIconBox">
    <%if(return_state==8){%>
    <div class="statetIcon">
        <p class="underway">处理中</p>
    </div>
    <div class="statetIconHint">
        <p>您已经成功发起售后申请，请耐心等待商家梳理。</p>
        <div class="revocationBnBox">
            <button id="revocationBn" class="revocationBn">撤销申请</button>
        </div>
    </div>
    <%}else if(return_state==2 || return_state==3 || return_state==4){%>
    <div class="statetIcon">
        <p class="accomplish ">处理中</p>
        <p class="accomplishTime"><%=return_add_time%></p>
    </div>
    <%}else if(return_state==5){%>
    <div class="statetIcon">
        <p class="accomplish ">处理完成</p>
        <p class="accomplishTime"><%=return_finish_time%></p>
    </div>
    <%}else if(return_state==9){%>
    <div class="statetIcon">
        <p class="accomplish ">交易关闭</p>
        <p class="accomplishTime"><%=return_finish_time%></p>
    </div>
    <%}%>
</div>
<%if(return_state_text=='处理中'){%>
<div class="scheduleBox">
    <p class="scheduleHd">处理进度</p>
    <div class="stepBox">
        <!-- 1 -->
        <div class="stepSon">
           <div class="SpCircle"></div>
            <p class="StP">售后申请</p>
            <p class="StTime"><%=return_add_time%></p>
        </div>
        <!-- 2 -->
        <div class="stepSon">
           <div class="SpCircle"></div>
            <div class="SpLine"></div>
            <p class="StP">处理中</p>
            <p class="StTime"><%=return_add_time%></p>
        </div>
        <!-- 3 -->
        <div class="stepSon">
           <div class="SpCircle  defaultFlow">
               <img src="../../images/afterSaleB_05.png">
           </div>
            <div class="SpLine  defaultFlow"></div>
            <p class="StP defaultFlowP">处理完成</p>
            <p class="StTime EndStTime"><%=return_finish_time%></p>
        </div>
    </div>
</div>
<%}else if(return_state_text=='处理完成'){%>
<div class="scheduleBox">
    <p class="scheduleHd">处理进度</p>
    <div class="stepBox">
        <!-- 1 -->
        <div class="stepSon">
           <div class="SpCircle"></div>
            <p class="StP">售后申请</p>
            <p class="StTime"><%=return_add_time%></p>
        </div>
        <!-- 2 -->
        <div class="stepSon">
           <div class="SpCircle"></div>
            <div class="SpLine"></div>
            <p class="StP">处理中</p>
            <p class="StTime"><%=return_add_time%></p>
        </div>
        <!-- 3 -->
        <div class="stepSon">
           <div class="SpCircle  ">
               <img src="images/afterSaleB_05.png">
           </div>
            <div class="SpLine  "></div>
            <p class="StP ">处理完成</p>
            <p class="StTime "><%=return_finish_time%></p>
        </div>
    </div>
</div>
<%}%>

<div class="scheduleBox">
    <p class="scheduleHd">退款信息</p>
                </div>
                <ul class="scheduleMe">
                    <li><p class="">售后申请原因 ：</p><p class="CeMeR"><%=return_reason%></p></li>
                    <li><p class="">申请时间 ：</p><p class="CeMeR"><%=return_add_time%></p></li>
                    <li><p class="">退货编号 ：</p><p class="CeMeR"><%=return_code%></p></li>
                </ul>
</div>
<footer>
    <div class="footContact">
        <img src="../../images/afterSaleB_09.png">
        <p>在线客服</p>
    </div>
    <div class="footContact ftCtR">
        <img src="../../images/afterSaleB_06.png">
        <p><a style="color:white;" href="tel:02283719600">拨打电话</a></p>
    </div>
</footer>
    <!-- 弹窗 -->
    <div class="timeSelectBox">
        <div class="revocationAlert">
            <p>您将撤销本次申请,如果问题未解决,您还可以再次发起,确定继续吗?</p>
            <div class="RnBnBox">
                <button class="RnConfirmBn" order_return_id="<%=order_return_id%>">确定</button>
                <button id="RnCancelBn" class="RnCancelBn">取消</button>
            </div>
        </div>
    </div>
</script>
<script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
<script type="text/javascript" src="../../js/zepto.min.js"></script>
<script type="text/javascript" src="../../js/template.js"></script>
<script type="text/javascript" src="../../js/common.js"></script>
<script type="text/javascript" src="../../js/simple-plugin.js"></script>
<script type="text/javascript" src="../../js/tmpl/member_refund_info.js"></script>
</body>
</html>
<?php 
include __DIR__.'/../../includes/footer.php';
?>