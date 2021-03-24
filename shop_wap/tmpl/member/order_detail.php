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
    <title>订单详情</title>
    <link rel="stylesheet" type="text/css" href="../../css/base.css">
    <link rel="stylesheet" type="text/css" href="../../css/nctouch_member.css">
    <link rel="stylesheet" href="../../css/iconfont.css">
    <link rel="stylesheet" href="../../css/orderDetails.css">
    <link rel="stylesheet" href="../../css/App-afterSale.css">

</head>
<body>
<header id="header" class="fixed">
    <div class="header-wrap">
        <div class="header-l"><a href="javascript:history.go(-1)"> <i class="back"></i> </a></div>
        <div class="header-title">
            <h1>订单详情</h1>
        </div>
        <div class="header-r">
            <a id="header-nav" href="javascript:void(0);"> <i class="more"></i> <sup></sup> </a>
        </div>
    </div>
    <div class="nctouch-nav-layout">
        <div class="nctouch-nav-menu">
            <span class="arrow"></span>
            <ul>
                <li><a href="../../index.html"><i class="home"></i>首页</a></li>
                <li><a href="../search.html"><i class="search"></i>搜索</a></li>
                <li><a href="javascript:void(0);"><i class="message"></i>消息<sup></sup></a></li>
            </ul>
        </div>
    </div>
</header>
<div class="nctouch-main-layout mb20">
    <div class="nctouch-order-list" id="order-info-container">
        <ul></ul>
    </div>
</div>
<script type="text/html" id="order-info-tmpl1">

    <div class="statetIconBox">
        <div class="statetIcon">
            <div class="optimizeopTimizeBox">
                <p class="">交易状态</p>
                <p class=""><%=order_state_con%></p>
            </div>
            <p class="statetShipments"><%= order_status_co %></p>
            <%if (order_cancel_reason != ''){%>
            <div class="info"><%=order_cancel_reason%></div>
            <%}%>
            <%if(order_status == 4){%>
            <div class="time fnTimeCountDown colf fz-28 ShippingCountdown" data-end="<%=order_receiver_date%>">
                <i class="icon-time"></i>
                <span class="ts">
                剩余
                <span class="day">00</span>
                <strong>天</strong>
                <span class="hour">00</span>
                <strong>小时</strong>
                <span class="mini">00</span>
                <strong>分</strong>
                <span class="sec">00</span>
                <strong>秒</strong>
                自动确认收货
            </span>
            </div>
            <% }%>
            <%if(order_status == 1){%>
            <div class="time fnTimeCountDown colf fz-28 ShippingCountdown" data-end="<%=cancel_time%>">
                <i class="icon-time"></i>
                <span class="ts">
                剩余
                <span class="day">00</span>
                <strong>天</strong>
                <span class="hour">00</span>
                <strong>小时</strong>
                <span class="mini">00</span>
                <strong>分</strong>
                <span class="sec">00</span>
                <strong>秒</strong>
                自动关闭订单
            </span>
            </div>
            <% }%>

        </div>
        <div class="statetIconHint">

            <div class="GoodsReceiptBox">
                <i class="locationIcon"></i>
                <ul class="locationUl">
                    <li>
                        <p>收货人 ： <span><%=order_receiver_name%></span></p>
                        <p class="phoneNumber"><%=order_receiver_contact%></p>
                    </li>
                    <li class="locationMessage">
                        <p class="locationMessage">收货人 ： <span><%=order_receiver_address%></span></p>
                    </li>
                </ul>
            </div>

        </div>

    </div>
    <!--   <%if(order_status == 4){%>
      <div class="nctouch-oredr-detail-delivery">
          <a href="<%=WapSiteUrl%>/tmpl/member/order_delivery.html?order_id=<%=order_id%>">
              <span class="time-line">
                  <i></i>
              </span>
              <div class="info">
                  <p id="delivery_content"></p>
                  <time id="delivery_time"></time>
              </div>
              <span class="arrow-r"></span>
          </a>
      </div>
      <%}%> -->
    <!-- 门店自提 -->
    <% if(chain_id > 0){ %>
    <div class="order-ziti-addr col5 bgf">
        <dl class="pt-30 pl-20 pr-20">
            <dt>店铺地址：</dt>
            <dd>
                <%=chain_info.chain_province+chain_info.chain_city+chain_info.chain_county+chain_info.chain_address%>
            </dd>
        </dl>
        <dl class="pt-30 pb-30 pl-20 pr-20 relative wp100 box-size">
            <dt>联系电话：</dt>
            <dd><%=chain_info.chain_mobile%></dd>
            <a onclick="dial('<%=chain_info.chain_mobile%>')" href="javascript:void(0)" class="btn-phone"> <i class="icon icon-phone"></i> </a>
        </dl>
        <dl class="pt-30 pb-30 pl-20 pr-20 bort1 borb1">
            <dt>提货码：</dt>
            <% if(chain_code.chain_code_id){ %>
            <dd><%=chain_code.chain_code_id%></dd>
            <% }else{ %>
            <dd>无</dd>
            <% } %>
        </dl>
    </div>
    <% } %>
    <!--店铺信息-->
    <div class="nctouch-order-item mt-20">
        <div class="nctouch-order-item-head bgf">
            <%if (shop_self_support){%>
            <a class="storeBox" href="<%=WapSiteUrl%>/tmpl/store.html?shop_id=<%=shop_id%>">
                <i class="storeIcon"></i>
                <p class="storeName"><%=shop_name%></p>
                <i class="arrowsR"></i>
                <p class="paymentStatus"><%=order_state_con%></p>
            </a>
            <% }else{ %>
            <a class="storeBox" href="<%=WapSiteUrl%>/tmpl/store.html?shop_id=<%=shop_id%>">
                <i class="storeIcon"></i>
                <p class="storeName"><%=shop_name%></p>
                <i class="arrowsR"></i>
                <p class="paymentStatus"><%=order_state_con%></p>
            </a>
            <%}%>
        </div>
        <div class="nctouch-order-item-con nctouch-order-item-con-cart">
            <% for(var k in goods_list){ %>
            <% for(var i in goods_list[k]){%>

            <div class="goods-block">
                <a href="<%=WapSiteUrl%>/tmpl/product_detail.html?goods_id=<%=goods_list[k][i].goods_id%>" class="clearfix wp100">
                    <div class="">
                        <div class="goods-pic">
                            <img src="<%=goods_list[k][i].goods_image%>">
                            <!-- 1113拼团图标 -->
                            <!-- <b class="icon-tg"></b> -->
                        </div>
                        <dl class="goods-info">
                            <dt class="goods-name"><%=goods_list[k][i].goods_name%></dt>
                            <% var order_spec_info = '';
                            if(goods_list[k][i].order_spec_info && goods_list[k][i].order_spec_info.length > 0){
                            for(var j in goods_list[k][i].order_spec_info){
                            order_spec_info += goods_list[k][i].order_spec_info[j] + '; ';
                            }
                            %>
                            <dd class="goods-type one-overflow">
                                <%=order_spec_info%>
                            </dd>
                            <% } %>
                        </dl>
                    </div>
                    <div class="goods-subtotal">
                        <span class="goods-price">￥<em><%=goods_list[k][i].goods_price%></em></span>

                        <span class="goods-num fz-24 colbc">x<%=goods_list[k][i].order_goods_num%></span>
                    </div>
                </a>
            </div>

            <%}%>
<!--             <a class="storeBox expressageH viewdelivery-order" href="javascript:void(0);" order_id="<%=order_id%>" express_id="<%=order_shipping_express_id%>" shipping_code="<%=order_shipping_code%>">
                <i class="EeIcon"></i>
                <div class="expressageState">
                    <p class="EeSeP">已签收，签收人是代理点代签</p>
                    <p class="EeTime">2018-09-12  14:23:33</p>

                </div>

                <i class="EeArrowsR"></i>
            </a> -->
            <%}%>

            <div class="costBox">
                <dl>
                    <dt>运费：</dt>
                    <dd><sapn>￥</sapn><%=order_shipping_fee%></dd>
                </dl>
                <dl>
                    <dt>发票邮费：</dt>
                    <dd><sapn>￥</sapn><%=order_invoice_fee%></span></dd>
                </dl>
                <dl>
                    <dt>实付款<span class="hintP">(含运费)</span></dt>
                    <dd class="sumCost"><sapn>￥</sapn><%=order_payment_amount%></dd>
                </dl>
            </div>
<!--            <div class="return-tips tr">-->
                <!-- 退款状态 -->
<!--                <div class="figureOutBox">-->
<!--                    <p class="commodityPrices">共计 <span><%=order_from%></span> 件商品，合计<span><i> ￥ </i><%=order_payment_amount%></span> (含运费 <span><%=order_shipping_fee%></span> 元)</p>-->
<!--                    <% if(goods_return_status ==8){ %>-->
<!--                    <a href="<%=WapSiteUrl%>/tmpl/member/member_refund_info.html?refund_id=<%=order_refund_id%>" class="goods-returnss">处理中</a>-->
<!--                    <% }%>-->
<!---->
<!--                    <% if(goods_return_status == 5){ %>-->
<!--                    <a href="<%=WapSiteUrl%>/tmpl/member/member_refund_info.html?refund_id=<%=order_refund_id%>" class="goods-returnss">处理完成</a>-->
<!--                    <% }%>-->
<!--                    <% if(goods_return_status==15 || goods_return_status==9){ %>-->
<!--                    <% if(order_status==4 || order_status==5 || order_status==6){%>-->
<!--                    <% if(goods_return_status!=8&&goods_return_status!=5){%>-->
<!--                    <a href="javascript:void(0)" order_id="<%=order_id%>" order_goods_id="<%=order_goods_id%>" class="goods-returns">申请售后</a>-->
<!--                    <% }}}%>-->
<!--                </div>-->

<!--            </div>-->
            <style type="text/css">
                .nctouch-order-item-con .goods-returns {display: inline-block; font-size: 0.6rem;padding: 0.15rem 0.6rem ; border: solid 0.05rem #4d9e9c; border-radius: 0.6rem; color: #4d9e9c !important; background-color: #FFF;}
                .nctouch-order-item-con .goods-returnss {display: inline-block; font-size: 0.6rem;padding: 0.15rem 0.6rem ; border: solid 0.05rem #4d9e9c; border-radius: 0.6rem; color: #4d9e9c !important; background-color: #FFF;margin-bottom: 10px;}
            </style>
            <div class="serviceBox">
                <img src="../../images/afterSaleB_10.png">
                <p>联系客服</p>
            </div>
<!--            <div class="scheduleBox seBxB">-->
<!--                -->
<!--                <% if(shop_phone){ %>-->
<!--                <span class="to-call">-->
<!--                <a href="tel:<%=shop_phone%>" tel="<%=shop_phone%>"><i class="tel"></i>拨打电话</a>-->
<!--            </span>-->
<!--                <% } %>-->
<!--                <button class="CopyBn" onclick="copyUrl3();">复制</button>-->
                <ul class="scheduleMe">
                    <li><p class="text" >订单编号：</p><p id="CeMeR"><%=order_id%></p></li>
                    <li><p class="">创建时间：</p><p class="CeMeR"><%=order_create_time%></p></li>
                    <% if(payment_time !== '0000-00-00 00:00:00'){%>
                    <li><p class="" >付款时间：</p><p class="CeMeR"><%=payment_time%></p></li>
                    <%}%>
                    <% if(chain_id > 0){ %>
                    <% if(order_finished_time !== '0000-00-00 00:00:00'){%>
                    <li><p class="" >提货时间：</p><p class="CeMeR"><%=order_finished_time%></p></li>
                    <%}%>
                    <% } %>
                    <% if(order_buyer_evaluation_time !== '0000-00-00 00:00:00'){%>
                    <li><p class="" >评价时间：</p><p class="CeMeR"><%=order_buyer_evaluation_time %></p></li>
                    <%}%>
                </ul>
<!--            </div>-->

<!--              <div class="indentSelect">
                <button >取消订单</button>
                <button class="optFor">订单支付</button>
            </div> -->


            <div class="nctouch-oredr-detail-bottom">
                <!--退款/货状态-->
                <% if (order_return_status == 1 || order_refund_status == 1) {%>
                <p>退款/退货中...</p>
                <% } %>
                <!--取消状态-->
                <% if (order_status == 1 || (order_status == 3 && payment_id == 2)) {%>
                <!-- <a href="javascript:void(0)" order_id="<%=order_id%>" class="btn cancel-order">取消订单</a> -->
                <% } %>
                <!--物流信息-->
                <% if (order_status == 4) { %>
                <a href="javascript:void(0)" order_id="<%=order_id%>" express_id="<%=order_shipping_express_id%>" shipping_code="<%=order_shipping_code%>" class="btn viewdelivery-order" onclick='l()'>查看物流</a>
                <%}%>
                <!--确认收货-->
                <% if (order_status == 4){ %>
                <a href="javascript:void(0)" order_id="<%=order_id%>" class="btn key sure-order">确认收货</a>
                <% } %>
                <!--评价订单-->
                <% if (order_status == 6 && order_buyer_evaluation_status == 0 && is_eval != 0) {%>
                <% if (order_refund_status < 1){ %>
                <a href="javascript:void(0)" order_id="<%=order_id%>" class="btn key evaluation-order">评价订单</a>
                <% } %>
                <% } %>
                <!--自提订单-->
                <%if(chain_id > 0){ %>
                <!--查看评价-->
                <% if (order_buyer_evaluation_status == 1 && order_refund_status < 1){ %>
                <a href="javascript:void(0)" order_id="<%=order_id%>" class="btn evaluation-again-order"> 查看评价 </a>
                <% } %>

                <% } else { %>
                <!--追评-->
                <% if (order_buyer_evaluation_status == 1 && order_refund_status < 1 && is_eval != 0){ %>
                <a href="javascript:void(0)" order_id="<%=order_id%>" class="btn evaluation-again-order"> 追加评价 </a>
                <% } %>

                <% } %>
                <!--订单支付-->
                <% if(order_status == 1 && order_payment_amount > 0){ %>
                <!-- <a href="javascript:" onclick="payOrder('<%= payment_number %>','<%=order_id %>')" data-paySn="<%=order_id %>" class="btn key check-payment">订单支付</a> -->
                <% } %>
            </div>
</script>
<script type="text/html" id="order-info-tmpl">

    <div class="statetIconBox">
        <div class="statetIcon">
            <div class="optimizeopTimizeBox">
                <p class="">交易状态</p>
                <p class=""><%=order_state_con%></p>
            </div>
            <p class="statetShipments"><%= order_status_co %></p>
            <%if (order_cancel_reason != ''){%>
            <div class="info"><%=order_cancel_reason%></div>
            <%}%>
            <%if(order_status == 4){%>
            <div class="time fnTimeCountDown colf fz-28 ShippingCountdown" data-end="<%=order_receiver_date%>">
                <i class="icon-time"></i>
                <span class="ts">
                剩余
                <span class="day">00</span>
                <strong>天</strong>
                <span class="hour">00</span>
                <strong>小时</strong>
                <span class="mini">00</span>
                <strong>分</strong>
                <span class="sec">00</span>
                <strong>秒</strong>
                自动确认收货
            </span>
            </div>
            <% }%>
            <%if(order_status == 1){%>
            <div class="time fnTimeCountDown colf fz-28 ShippingCountdown" data-end="<%=cancel_time%>">
                <i class="icon-time"></i>
                <span class="ts">
                剩余
                <span class="day">00</span>
                <strong>天</strong>
                <span class="hour">00</span>
                <strong>小时</strong>
                <span class="mini">00</span>
                <strong>分</strong>
                <span class="sec">00</span>
                <strong>秒</strong>
                自动关闭订单
            </span>
            </div>
            <% }%>

        </div>
        <div class="statetIconHint">
<!--            <a class="storeBox expressageH viewdelivery-order" href="javascript:void(0);" order_id="<%=order_id%>" express_id="<%=order_shipping_express_id%>" shipping_code="<%=order_shipping_code%>">-->
<!--                <i class="EeIcon"></i>-->
<!--                <div class="expressageState">-->
<!--                    <p class="EeSeP">已签收，签收人是代理点代签</p>-->
<!--                    <p class="EeTime">2018-09-12  14:23:33</p>-->
<!---->
<!--                </div>-->

<!--                <i class="EeArrowsR"></i>-->
<!--            </a>-->
            <div class="GoodsReceiptBox">
                <i class="locationIcon"></i>
                <ul class="locationUl">
                    <li>
                        <p>收货人 ： <span><%=order_receiver_name%></span></p>
                        <p class="phoneNumber"><%=order_receiver_contact%></p>
                    </li>
                    <li class="locationMessage">
                        <p class="locationMessage">收货地址 ： <span><%=order_receiver_address%></span></p>
                    </li>
                </ul>
            </div>

        </div>

    </div>

    <!--发票信息-->
    <% if(invoice){%>
    <div class="invoiceBox">
        <div class="IeHd" onclick="piao(this)">
            <% if(invoice.invoice_state!=2){%>
            <p>发票信息</p>
            <% }else{%>
            <p>电子发票信息</p>
            <% }%>
            <i class="moreBn"></i>
        </div>
        <% if(invoice.invoice_state!=2){%>
        <div class="moreInformation">
            <div class="corporateMe">
                <p>公司信息</p>
                <dl>
                    <dt>单位名称：</dt>
                    <dd><%=invoice.invoice_title%></dd>
                </dl>
                <dl>
                    <dt>纳税人识别码：</dt>
                    <dd><%=invoice.invoice_code%></dd>
                </dl>
                <dl>
                    <dt>注册地址：</dt>
                    <dd><%=invoice.invoice_reg_addr%></dd>
                </dl>
                <dl>
                    <dt>注册电话：</dt>
                    <dd><%=invoice.invoice_reg_phone%></dd>
                </dl>
                <dl>
                    <dt>开户银行：</dt>
                    <dd><%=invoice.invoice_reg_bname%></dd>
                </dl>
                <dl>
                    <dt>银行账户：</dt>
                    <dd><%=invoice.invoice_reg_baccount%></dd>
                </dl>
                </dl>
            </div>

            <div class="corporateMe">
                <p>收票人信息</p>
                <dl>
                    <dt>发票内容：</dt>
                    <dd><%=invoice.invoice_statu_txt%></dd>
                </dl>
                <dl>
                    <dt>收票人姓名：</dt>
                    <dd><%=invoice.invoice_rec_name%></dd>
                </dl>
                <dl>
                    <dt>收票人手机号：</dt>
                    <dd><%=invoice.invoice_rec_phone%></dd>
                </dl>
                <dl>
                    <dt>收票人省份：</dt>
                    <dd><%=invoice.invoice_rec_province%></dd>
                </dl>
                <dl>
                    <dt>详细地址：</dt>
                    <dd><%=invoice.invoice_goto_addr%></dd>
                </dl>

            </div>

        <%}else{%>
         <div class="moreInformation">
           <div class="corporateMe">

                <dl>
                    <dt>发票抬头：</dt>
                    <dd><%=invoice.invoice_title%></dd>
                </dl>                <%if(order_invoice_url){%>
                <dl>
                    <dt>下载地址：</dt>
                    <dd><a href="<%=order_invoice_url%>" >点击下载发票</a></dd>
                </dl>
                <% }%>
            </div>
            </div>

        <%}%>
        </div>
        <div class="IeHd paymentHd">
            <p>付款方式</p>
            <p class="paymentR">在线付款</p>
        </div>
    </div>
    <% }%>
    <!--   <%if(order_status == 4){%>
      <div class="nctouch-oredr-detail-delivery">
          <a href="<%=WapSiteUrl%>/tmpl/member/order_delivery.html?order_id=<%=order_id%>">
              <span class="time-line">
                  <i></i>
              </span>
              <div class="info">
                  <p id="delivery_content"></p>
                  <time id="delivery_time"></time>
              </div>
              <span class="arrow-r"></span>
          </a>
      </div>
      <%}%> -->
    <!-- 门店自提 -->
    <% if(chain_id > 0){ %>
    <div class="order-ziti-addr col5 bgf">
        <dl class="pt-30 pl-20 pr-20">
            <dt>店铺地址：</dt>
            <dd>
                <%=chain_info.chain_province+chain_info.chain_city+chain_info.chain_county+chain_info.chain_address%>
            </dd>
        </dl>
        <dl class="pt-30 pb-30 pl-20 pr-20 relative wp100 box-size">
            <dt>联系电话：</dt>
            <dd><%=chain_info.chain_mobile%></dd>
            <a onclick="dial('<%=chain_info.chain_mobile%>')" href="javascript:void(0)" class="btn-phone"> <i class="icon icon-phone"></i> </a>
        </dl>
        <dl class="pt-30 pb-30 pl-20 pr-20 bort1 borb1">
            <dt>提货码：</dt>
            <% if(chain_code.chain_code_id){ %>
            <dd><%=chain_code.chain_code_id%></dd>
            <% }else{ %>
            <dd>无</dd>
            <% } %>
        </dl>
    </div>
    <% } %>
    <!--店铺信息-->
    <div class="nctouch-order-item mt-20">
        <div class="nctouch-order-item-head bgf">
            <%if (shop_self_support){%>
            <a class="storeBox" href="<%=WapSiteUrl%>/tmpl/store.html?shop_id=<%=shop_id%>">
                <i class="storeIcon"></i>
                <p class="storeName"><%=shop_name%></p>
                <i class="arrowsR"></i>
                <p class="paymentStatus"><%=order_state_con%></p>
            </a>
            <% }else{ %>
            <a class="storeBox" href="<%=WapSiteUrl%>/tmpl/store.html?shop_id=<%=shop_id%>">
                <i class="storeIcon"></i>
                <p class="storeName"><%=shop_name%></p>
                <i class="arrowsR"></i>
                <p class="paymentStatus"><%=order_state_con%></p>
            </a>
            <%}%>
        </div>
        <div class="nctouch-order-item-con nctouch-order-item-con-cart">
            <% for(i=0; i < goods_list.length; i++){%>
            <div class="goods-block">
                <a href="<%=WapSiteUrl%>/tmpl/product_detail.html?goods_id=<%=goods_list[i].goods_id%>" class="clearfix wp100">
                    <div class="">
                        <div class="goods-pic">
                            <img src="<%=goods_list[i].goods_image%>">
                            <!-- 1113拼团图标 -->
                            <!-- <b class="icon-tg"></b> -->
                        </div>
                        <dl class="goods-info">
                            <dt class="goods-name"><%=goods_list[i].goods_name%></dt>
                            <% var order_spec_info = '';
                            if(goods_list[i].order_spec_info && goods_list[i].order_spec_info.length > 0){
                            for(var j in goods_list[i].order_spec_info){
                            order_spec_info += goods_list[i].order_spec_info[j] + '; ';
                            }
                            %>
                            <dd class="goods-type one-overflow">
                                <%=order_spec_info%>
                            </dd>
                            <% } %>
                        </dl>
                    </div>
                    <div class="goods-subtotal">
                        <span class="goods-num fz-24 colbc">x<%=goods_list[i].order_goods_num%></span>
                    </div>
                </a>
            </div>

            <%}%>
            <div class="costBox">
                <dl>
                    <dt>运费：</dt>
                    <dd><sapn>￥</sapn><%=order_shipping_fee%></dd>
                </dl>
                <dl>
                    <dt>发票邮费：</dt>
                    <dd><sapn>￥</sapn><%=order_invoice_fee%></span></dd>
                </dl>
                <dl>
                    <dt>实付款<span class="hintP">(含运费)</span></dt>
                    <dd class="sumCost"><sapn>￥</sapn><%=order_payment_amount%></dd>
                </dl>
            </div>


<!--            <div class="return-tips tr">-->
<!--                <!-- 退款状态 -->
<!--                <div class="figureOutBox">-->
<!--                    <p class="commodityPrices">共计 <span><%=order_from%></span> 件商品，合计<span><i> ￥ </i><%=order_payment_amount%></span> (含运费 <span><%=order_shipping_fee%></span> 元)</p>-->
<!--                    <% if(goods_return_status ==8 || goods_return_status==2 || goods_return_status==3 || goods_return_status==4){ %>-->
<!--                    <a href="<%=WapSiteUrl%>/tmpl/member/member_refund_info.html?refund_id=<%=order_refund_id%>" class="goods-returnss">处理中</a>-->
<!--                    <% }%>-->
<!---->
<!--                    <% if(goods_return_status == 5){ %>-->
<!--                    <a href="<%=WapSiteUrl%>/tmpl/member/member_refund_info.html?refund_id=<%=order_refund_id%>" class="goods-returnss">处理完成</a>-->
<!--                    <% }%>-->
<!--                    <% if(goods_return_status==15 || goods_return_status==9){ %>-->
<!--                    <% if(order_status==4 || order_status==5 || order_status==6){%>-->
<!--                    <% if(goods_return_status!=8&&goods_return_status!=5){%>-->
<!--                    <a href="javascript:void(0)" order_id="<%=order_id%>" order_goods_id="<%=order_goods_id%>" class="goods-returns">申请售后</a>-->
<!--                    <% }}}%>-->
<!--                </div>-->
<!---->
<!--            </div>-->
            <style type="text/css">
                .nctouch-order-item-con .goods-returns {display: inline-block; font-size: 0.6rem;padding: 0.15rem 0.6rem ; border: solid 0.05rem #4d9e9c; border-radius: 0.6rem; color: #4d9e9c !important; background-color: #FFF;margin-bottom: 10px;}
                .nctouch-order-item-con .goods-returnss {display: inline-block; font-size: 0.6rem;padding: 0.15rem 0.6rem ; border: solid 0.05rem #4d9e9c; border-radius: 0.6rem; color: #4d9e9c !important; background-color: #FFF;margin-bottom: 10px;}
            </style>
            <div class="serviceBox">
                <img src="../../images/afterSaleB_10.png">
                <p ><a href="https://www.sobot.com/chat/pc/index.html?sysNum=6f1b506019f34559a19e45da79151f82&channelFlag=2" style="color: white">联系客服</a></p>
            </div>
<!--            <div class="scheduleBox seBxB">-->
<!--                -->
<!--                <% if(shop_phone){ %>-->
<!--                <span class="to-call">-->
<!--                <a href="tel:<%=shop_phone%>" tel="<%=shop_phone%>"><i class="tel"></i>拨打电话</a>-->
<!--            </span>-->
<!--                <% } %>-->
<!--                <button class="CopyBn" onclick="copyUrl2();">复制</button>-->

                <ul class="scheduleMe">
                    <li><p class="">订单编号：</p><p id="CeMeRs"><%=order_id%></p></li>
                    <li><p class="">创建时间：</p><p class="CeMeR"><%=order_create_time%></p></li>
                    <% if(payment_time !== '0000-00-00 00:00:00'){%>
                    <li><p class="" >付款时间：</p><p class="CeMeR"><%=payment_time%></p></li>
                    <%}%>
                    <% if(chain_id > 0){ %>
                    <% if(order_finished_time !== '0000-00-00 00:00:00'){%>
                    <li><p class="" >提货时间：</p><p class="CeMeR"><%=order_finished_time%></p></li>
                    <%}%>
                    <% } %>
                    <% if(order_buyer_evaluation_time !== '0000-00-00 00:00:00'){%>
                    <li><p class="" >评价时间：</p><p class="CeMeR"><%=order_buyer_evaluation_time %></p></li>
                    <%}%>
                </ul>

<!--            </div>-->

<!--             <div class="indentSelect">
                <button >取消订单</button>
                <button class="optFor">订单支付</button>
            </div> -->

            <div class="nctouch-oredr-detail-bottom">
                <!--退款/货状态-->
                <% if (order_return_status == 1 || order_refund_status == 1) {%>
                <p>退款/退货中...</p>
                <% } %>
                <!--取消状态-->
                <% if (order_status == 1 || (order_status == 3 && payment_id == 2)) {%>
                <a href="javascript:void(0)" order_id="<%=order_id%>" class="btn cancel-order">取消订单</a>
                <% } %>
                <!--物流信息-->
                <% if (order_status == 4) { %>
                <a href="javascript:void(0)" order_id="<%=order_id%>" express_id="<%=order_shipping_express_id%>" shipping_code="<%=order_shipping_code%>" class="btn viewdelivery-order">查看物流</a>
                <%}%>
                <!--确认收货-->
                <% if (order_status == 4){ %>
                <a href="javascript:void(0)" order_id="<%=order_id%>" class="btn key sure-order">确认收货</a>
                <% } %>
                <!--评价订单-->
                <% if (order_status == 6 && order_buyer_evaluation_status == 0 && is_eval != 0) {%>
                <% if (order_refund_status < 1){ %>
                <a href="javascript:void(0)" order_id="<%=order_id%>" class="btn key evaluation-order">评价订单</a>
                <% } %>
                <% } %>
                <!--自提订单-->
                <%if(chain_id > 0){ %>
                <!--查看评价-->
                <% if (order_buyer_evaluation_status == 1 && order_refund_status < 1){ %>
                <a href="javascript:void(0)" order_id="<%=order_id%>" class="btn evaluation-again-order"> 查看评价 </a>
                <% } %>

                <% } else { %>
                <!--追评-->
                <% if (order_buyer_evaluation_status == 1 && order_refund_status < 1 && is_eval != 0){ %>
                <a href="javascript:void(0)" order_id="<%=order_id%>" class="btn evaluation-again-order"> 追加评价 </a>
                <% } %>

                <% } %>
                <!--订单支付-->
                <% if(order_status == 1 && order_payment_amount > 0){ %>
                <a href="javascript:" onclick="payOrder('<%= payment_number %>','<%=order_id %>')" data-paySn="<%=order_id %>" class="btn key check-payment">订单支付</a>
                <% } %>
            </div>
</script>

<script type="text/javascript" src="../../js/zepto.min.js"></script>
<script type="text/javascript" src="../../js/template.js"></script>
<script type="text/javascript" src="../../js/common.js"></script>
<script type="text/javascript" src="../../js/simple-plugin.js"></script>
<script type="text/javascript" src="../../js/tmpl/order_detail.js"></script>
<script type="text/javascript" src="../../js/jquery.timeCountDown.js"></script>
<!--<textarea id="input"></textarea>-->
<script>
    // 更多发票信息
    function  piao(e){
            if($('.moreInformation').css("display") == "none"){
                $('.moreBn').addClass("overturn");
                $(".moreInformation").css("display","block");
            }else{
                $('.moreBn').removeClass("overturn");
                $(".moreInformation").css("display","none");
            }

    }
</script>
</body>
</html>
<?php
include __DIR__ . '/../../includes/footer.php';
?>
<script type="text/javascript">
function copyUrl2(){
    var text = $("#CeMeRs").text();
    var input = document.getElementById("input");
    input.value = text; // 修改文本框的内容
    input.select(); // 选中文本
    document.execCommand("copy"); // 执行浏览器复制命令
    alert("复制成功");
}
function copyUrl3()
{
    var text = $("#CeMeR").text();
    var input = document.getElementById("input");
    input.value = text; // 修改文本框的内容
    input.select(); // 选中文本
    document.execCommand("copy"); // 执行浏览器复制命令
    alert("复制成功");
}

</script>