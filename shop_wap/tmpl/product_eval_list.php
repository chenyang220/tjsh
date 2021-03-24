<?php 
include __DIR__.'/../includes/header.php';
?>
<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="Author" contect="U2FsdGVkX1+liZRYkVWAWC6HsmKNJKZKIr5plAJdZUSg1A==">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-touch-fullscreen" content="yes" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="msapplication-tap-highlight" content="no" />
    <meta name="viewport" content="initial-scale=1,maximum-scale=1,minimum-scale=1" />
    <title>商品列表</title>
    <link rel="stylesheet" type="text/css" href="../css/base.css">
    <link rel="stylesheet" type="text/css" href="../css/nctouch_products_detail.css">
    <link rel="stylesheet" type="text/css" href="../css/nctouch_common.css">
</head>

<body>
    <header id="header" class="posf">
        <div class="header-wrap">
            <div class="header-l">
                <a href="javascript:history.go(-1)"> <i class="back"></i> </a>
            </div>
            <ul class="header-nav">
                <li><a href="javascript:void(0);" id="goodsDetail">商品</a></li>
                <li><a href="javascript:void(0);" id="goodsBody">详情</a></li>
                <li class="cur"><a href="javascript:void(0);" id="goodsEvaluation">评价</a></li>
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
    <div class="nctouch-main-layout">
        <div class="nctouch-tag-nav">
            <ul>1
                <li class="selected"><a href="javascript:void(0);" data-state="">全部</a></li>
                <li><a href="javascript:void(0);" data-state="1">好评</a></li>
                <li><a href="javascript:void(0);" data-state="2">中评</a></li>
                <li><a href="javascript:void(0);" data-state="3">差评</a></li>
                <li><a href="javascript:void(0);" data-state="4">带图评价</a></li>
                <!--<li><a href="javascript:void(0);" data-state="5">追加评价</a></li>-->
            </ul>
        </div>
        <div id="product_evaluation_html" class="product-eval-list"></div>
    </div>
    <footer id="footer" class="bottom"></footer>
</body>
<script type="text/html" id="product_ecaluation_script">
    <% var goods_eval_list = items;  %>
    <% if (goods_eval_list.length > 0) { %>
        <ul>
            <% for (var i=0; i<goods_eval_list.length; i++) { var goods_eval = goods_eval_list[i][0]; %>
                <li>
                    <div class="eval-user clearfix">
                        <div class="user-avatar fl"><img src="<%=goods_eval.user_logo%>" /></div>
                        <div class="goods-raty fl">
                        	<p class="user-name"><%=goods_eval.user_name%></p>
                        	<i class="star<%=goods_eval.scores%>"></i>
                        </div>
                        <time>
                            <%=goods_eval.create_time%>
                        </time>
                    </div>
                    
                    <dl class="eval-con">
                        <% if(goods_eval.goods_spec_str) { %>
                            <dt><%= goods_eval.goods_spec_str; %></dt>
                        <% } %>
                        <dt><%=goods_eval.content%></dt>
                        <dd></dd>
                        <%if(goods_eval.image_row.length > 0) {%>
                            <dd class="goods_geval">
                                <%for (var j=0; j<goods_eval.image_row.length; j++) {%>
                                    <a href="javascript:void(0);" data-start="<%=j%>"><img src="<%=goods_eval.image_row[j]%>" /></a>
                                <%}%>
                                <div class="nctouch-bigimg-layout hide">
                                    <div class="close"></div>
                                    <div class="pic-box">
                                        <ul>
                                            <%for (var j=0; j<goods_eval.image_row.length; j++) {%>
                                                <li style="background-image: url(<%=goods_eval.image_row[j]%>)"></li>
                                            <%}%>
                                        </ul>
                                    </div>
                                    <div class="nctouch-bigimg-turn">
                                        <ul>
                                            <%for (var j=0; j<goods_eval.image_row.length; j++) {%>
                                                <li class="<% if(j == 0) { %>cur<%}%>"></li>
                                                <%}%>
                                        </ul>
                                    </div>
                                </div>
                            </dd>
                            <%}%>
                    </dl>
                    <%if(goods_eval.explain_content && goods_eval.explain_content != '') {%>
                        <div class="eval-explain">
                            解释：
                            <%=goods_eval.explain_content%>
                        </div>
                        <%}%>
                            <% if ( goods_eval_list[i].length > 1 ) { var goods_eval_again = goods_eval_list[i][1]; %>
                                <div class="again-eval clearfix">
                                    <span>追评：</span><time class="fr"><%=goods_eval_again.create_time%></time></div>
                                        
                                            
                                <dl class="eval-con">
                                    <dt><%=goods_eval_again.content%></dt>
                                    <%if(goods_eval_again.image_row.length > 0) {%>
                                        <dd class="goods_geval">
                                            <%for (var j=0; j<goods_eval_again.image_row.length; j++) {%>
                                                <a href="javascript:void(0);"><img src="<%=goods_eval_again.image_row[j]%>" /></a>
                                                <%}%>
                                                    <div class="nctouch-bigimg-layout hide">
                                                        <div class="close"></div>
                                                        <div class="pic-box">
                                                            <ul>
                                                                <%for (var j=0; j<goods_eval_again.image_row.length; j++) {%>
                                                                    <li style="background-image: url(<%=goods_eval_again.image_row[j]%>)"></li>
                                                                    <%}%>
                                                            </ul>
                                                        </div>
                                                        <div class="nctouch-bigimg-turn">
                                                            <ul>
                                                                <%for (var j=0; j<goods_eval_again.image_row.length; j++) {%>
                                                                    <li class="<% if(j == 0) { %>cur<%}%>"></li>
                                                                    <%}%>
                                                            </ul>
                                                        </div>
                                                    </div>
                                        </dd>
                                        <%}%>
                                </dl>
                                <%if(goods_eval_again.explain_content && goods_eval_again.explain_content != '') {%>
                                    <div class="eval-explain">
                                        <span>解释：</span>
                                        <p><%=goods_eval_again.explain_content%></p>
                                    </div>
                                    <%}%>
                                        <% } %>
                </li>
                <% } %>
                    <li class="loading">
                        <div class="spinner"><i></i></div>数据读取中</li>
        </ul>
        <%}else {%>
            <div class="nctouch-norecord eval">
                <div class="norecord-ico"><i></i></div>
                <dl>
                    <dt>该商品未收到任何评价</dt>
                    <dd>期待您的购买与评论！</dd>
                </dl>
            </div>
            <%}%>
                </div>
                </div>
</script>

<script type="text/javascript" src="../js/zepto.min.js"></script>
<script type="text/javascript" src="../js/swipe.js"></script>
<script type="text/javascript" src="../js/template.js"></script>
<script type="text/javascript" src="../js/common.js"></script>
<script type="text/javascript" src="../js/ncscroll-load.js"></script>
<script type="text/javascript" src="../js/swipe.js"></script>
<script type="text/javascript" src="../js/tmpl/product_eval_list.js"></script>

</html>
<?php 
include __DIR__.'/../includes/footer.php';
?>