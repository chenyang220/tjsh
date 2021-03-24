<?php
include __DIR__ . '/../../includes/header.php';
?>  <!doctype html>
<html lang="en">
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
        <title>申请售后</title>
        <link rel="stylesheet" type="text/css" href="../../css/base.css">
        <link rel="stylesheet" type="text/css" href="../../css/nctouch_member.css">
        <link rel="stylesheet" type="text/css" href="../../css/App-afterSale.css">
        <link rel="stylesheet" type="text/css" href="../../css/orderDetails.css">
        <style>
            .word {
                font-size: 0.5rem;
                color: #888;
            }
            .timeSelectBox{

                 background-color: rgba(0, 0, 0, 0.43137254901960786);
            }
        </style>
</head>
<body style="background-color:#fff;">
    <header id="header">
        <div class="header-wrap">
            <div class="header-l"><a href="javascript:history.go(-1)"> <i class="back"></i> </a></div>
            <div class="header-title">
                <h1>申请售后</h1>
            </div>
            <div class="header-r"><a id="header-nav" href="javascript:void(0);"><i class="more"></i><sup></sup></a>
            </div>
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
    </header>    <footer id="footer"></footer>
<div id="order-info-container"></div>
<div class="afterSaleCause">
        <p>申请原因 ：</p>
        <p class="selectCause" id="click-reason">请选择<i></i></p>
        <input type="hidden" id="refundReasons">
    </div>
    <div class="remarkBox ">
        <p>备注 ：</p>
        <textarea name="buyer_message" id="buyer_message" rows="1" cols="30"  oninput="autoTextAreaHeight(this)" placeholder="选填" maxlength="200"></textarea>
    </div>


    <button class="afterSaleBn btn-l">确认</button>
<script type="text/html" id="order-info-tmpl">
<ul class="scheduleMe" style="padding:0.7rem 0.4rem 0rem 0.4rem!important;">
                    <li><p class="">订单号 ：</p><p class="CeMeR"><%=order.id%></p></li>
                    <li><p class="">PV ：</p><p class="CeMeR"><%=order.common_pv%></p></li>
                </ul>
</script>

<?php
include __DIR__ . '/../../includes/footer.php';
?>

<!--弹窗-->
    <div class="timeSelectBox">

        <div class="afterSaleCauseSelest">
            <p>申请原因</p>
            <div id="refundReason" class="arSeCeOn">
                
            </div>
            <button class="reasonSubmitBn">确认</button>
        </div>
    </div>
    <script type="text/javascript" src="../../js/zepto.min.js"></script>
    <script type="text/javascript" src="../../js/template.js"></script>
    <script type="text/javascript" src="../../js/common.js"></script>
    <script type="text/javascript" src="../../js/simple-plugin.js"></script>
    <script type="text/javascript" src="../../js/tmpl/return.js"></script>
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <script>
         $("#click-reason").click(function(){
            $(".timeSelectBox").css("display","inline-block");
            $(document.body).css({
                "overflow-x":"hidden",
                "overflow-y":"hidden"
            });
            preventBubble();
        })
        function preventBubble(event) {
             var e = arguments.callee.caller.arguments[0] || event; //若省略此句，下面的e改为event，IE运行可以，但是其他浏览器就不兼容
            if (e && e.stopPropagation) {
                e.stopPropagation();
            } else if (window.event) {
                window.event.cancelBubble = true;
            }
        }
        function closeCover(){
            $(".timeSelectBox").css("display","none");
            $(document.body).css({
                "overflow-x":"auto",
                "overflow-y":"auto"
            });
            preventBubble();
        }
        $(".timeSelectBox").click(function(){
            closeCover();
        })
        $(".reasonSubmitBn").click(function(){
            closeCover();
            var gender = document.getElementsByName('reason-refund');
            for (var i = 0; i < gender.length; i++) {
                if (gender[i].checked) {
                    id = gender[i].value;
                }
            }
            var text = $("."+id).text();
            $("#click-reason").text(text);
            $("#refundReasons").val(id);
        })
        $(".afterSaleCauseSelest").click(function(){
            preventBubble();
        })


        function autoTextAreaHeight(o) {
            o.style.height = o.scrollTop + o.scrollHeight + "px";
        }
        $(function () {
            var ele = document.getElementById("buyer_message");
            autoTextAreaHeight(ele);
        })

    </script>
</body>
</html>

