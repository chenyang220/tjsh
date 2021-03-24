<?php 
include __DIR__.'/../../includes/header.php';
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
    <link rel="stylesheet" type="text/css" href="../../css/base.css">
    <link rel="stylesheet" type="text/css" href="../../css/nctouch_products_list.css">
    <link rel="stylesheet" type="text/css" href="../../css/nctouch_common.css">
</head>

<body>
    <header id="header" class="nctouch-product-header fixed">
        <div class="header-wrap">
            <div class="header-l">
                <a href="javascript:history.go(-1)"> <i class="back"></i> </a>
            </div>
            <div class="header-inp clearfix"> <i class="icon"></i> <span class="search-input" id="keyword">请输入关键词</span> </div>
            <div class="header-r"> <a href="../tmpl/product_first_categroy.html" class="categroy"><i></i>
      </a> <a id="header-nav" href="javascript:void(0);"><i class="more"></i><sup></sup></a> </div>
        </div>
        <div class="nctouch-nav-layout">
            <div class="nctouch-nav-menu"> <span class="arrow"></span>
                <ul>
                    <li><a href="../index.html"><i class="home"></i>首页</a></li>
                    <li><a href="../tmpl/cart_list.html"><i class="cart"></i>购物车<sup></sup></a></li>
                    <li><a href="../tmpl/member/member.html"><i class="member"></i>我的商城</a></li>
                    <li><a href="javascript:void(0);"><i class="message"></i>消息<sup></sup></a></li>
                </ul>
            </div>
        </div>
    </header>
    <div class="goods-search-list-nav">
        <ul id="nav_ul">
            <li><a href="javascript:void(0);" class="current" id="sort_default">综合排序<i></i></a></li>
            <li><a href="javascript:void(0);" class="" onclick="init_get_list('2', '1')">销量优先</a></li>
            <li><a href="javascript:void(0);" id="search_adv">筛选<i></i></a></li>
        </ul>
        <div class="browse-mode"><a href="javascript:void(0);" id="show_style"><span class="browse-list"></span></a></div>
    </div>
    <div id="sort_inner" class="goods-sort-inner hide"> <span><a href="javascript:void(0);" class="cur"  onclick="init_get_list('', '')">综合排序<i></i></a></span> <span><a href="javascript:void(0);" onclick="init_get_list('2', '3')">价格从高到低<i></i></a></span> <span><a href="javascript:void(0);" onclick="init_get_list('1', '3')">价格从低到高<i></i></a></span> <span><a href="javascript:void(0);" onclick="init_get_list('2', '2')">人气排序<i></i></a></span> </div>
    <div class="nctouch-main-layout mt40 mb20">
        <div id="product_list" class="list">
            <ul class="goods-secrch-list">
            </ul>
        </div>
    </div>
    <!--筛选部分-->
    <div class="nctouch-full-mask hide">
        <div class="nctouch-full-mask-bg"></div>
        <div class="nctouch-full-mask-block">
            <div class="header">
                <div class="header-wrap">
                    <div class="header-l"> <a href="javascript:void(0);"><i class="back"></i></a></div>
                    <div class="header-title">
                        <h1>商品筛选</h1>
                    </div>
                    <div class="header-r"><a href="javascript:void(0);" id="reset" class="text">重置</a> </div>
                </div>
            </div>
            <div class="nctouch-main-layout-a secreen-layout" id="list-items-scroll" style="top: 2rem;">
                <div></div>
            </div>
        </div>
    </div>
    <div class="fix-block-r">
        <a href="member/views_list.html" class="browse-btn"><i></i></a>
        <a href="javascript:void(0);" class="gotop-btn gotop hide" id="goTopBtn"><i></i></a>
    </div>
    <footer id="footer" class="bottom"></footer>
    <script type="text/html" id="search_items">
        <div>
            <dl>
                <dt>价格区间</dt>
                <dd>
                    <span class="inp-balck"><input type="text" id="price_from" nctype="price" pattern="[0-9]*" class="inp" placeholder="最低价"/></span>
                    <span class="line"></span>
                    <span class="inp-balck"><input nctype="price" type="text" id="price_to" pattern="[0-9]*" class="inp" placeholder="最高价"/></span>
                </dd>
            </dl>
            <dl>
                <dt>商品所在地</dt>
                <dd><span class="inp-balck add"><select id="area_id">
					<option value="">不限</option>
    				<% for (i = 0; i < area_list.length; i++) { %>
    				<option value="<%=area_list[i]['area_id']%>"><%=area_list[i]['area_name']%></option>
    				<% } %>
    				</select>
					<i></i>
			</span>
                </dd>
            </dl>
            <dl>
                <dt>商品类型</dt>
                <dd>
                    <a href="javascript:void(0);" nctype="items" id="gift" class="">赠品</a>
                    <a href="javascript:void(0);" nctype="items" id="groupbuy">团购</a>
                    <a href="javascript:void(0);" nctype="items" id="xianshi">限时折扣</a>
                </dd>
            </dl>
            <dl>
                <dt>店铺类型</dt>
                <dd>
                    <a href="javascript:void(0);" nctype="items" id="own_shop" class="">平台自营</a>
                </dd>
            </dl>
            <dl>
                <dt>店铺服务</dt>
                <dd>
                    <% for (i = 0; i < contract_list.length; i++) { %>
                        <a href="javascript:void(0);" nctype="items" name="ci" value="<%=contract_list[i]['id']%>">
                            <%=contract_list[i]['name']%>
                        </a>
                        <% } %>
                            </dt>
            </dl>
            <div class="bottom">
                <a href="javascript:void(0);" class="btn-l" id="search_submit">筛选商品</a>
            </div>
        </div>
    </script>
    <!--筛选部分-->
</body>
<script type="text/html" id="home_body">
    <% var goods_list = datas.goods_list; %>
        <% if(goods_list.length >0){%>
            <%for(i=0;i<goods_list.length;i++){%>
                <li class="goods-item" goods_id="<%=goods_list[i].goods_id;%>">
                    <span class="goods-pic">
					<a href="product_detail.html?goods_id=<%=goods_list[i].goods_id;%>">
						<img src="<%=goods_list[i].goods_image_url;%>"/>
					</a>
				</span>
                    <dl class="goods-info">
                        <dt class="goods-name">
						<a href="product_detail.html?goods_id=<%=goods_list[i].goods_id;%>">
							<h4><%=goods_list[i].goods_name;%></h4>
							<h6><%=goods_list[i].goods_jingle;%></h6>
						</a>
					</dt>
                        <dd class="goods-sale">
                            <a href="product_detail.html?goods_id=<%=goods_list[i].goods_id;%>">
                                <span class="goods-price">￥<em><%=goods_list[i].goods_price;%></em>
								<%
									if (goods_list[i].sole_flag) {
								%>
									<span class="phone-sale"><i></i>手机专享</span>
                                <%
									}
								%>
                                    </span>

                                    <% if (goods_list[i].is_virtual == '1') { %>
                                        <span class="sale-type">虚拟</span>
                                        <% } else { %>
                                            <% if (goods_list[i].is_presell == '1') { %>
                                                <span class="sale-type">预</span>
                                                <% } %>
                                                    <% if (goods_list[i].is_fcode == '1') { %>
                                                        <span class="sale-type">F</span>
                                                        <% } %>
                                                            <% } %>

                                                                <% if(goods_list[i].group_flag || goods_list[i].xianshi_flag){ %>
                                                                    <span class="sale-type">降</span>
                                                                    <% } %>
                                                                        <% if(goods_list[i].have_gift == '1'){ %>
                                                                            <span class="sale-type">赠</span>
                                                                            <% } %>
                            </a>
                        </dd>
                        <dd class="goods-assist">
                            <a href="product_detail.html?goods_id=<%=goods_list[i].goods_id;%>">
                                <span class="goods-sold">销量
									<em><%=goods_list[i].goods_salenum;%></em>
								</span>
                            </a>
                            <div class="goods-store">
                                <%
								if (goods_list[i].is_own_shop == '1') {
							%>
                                    <span class="mall">自营</span>
                                    <%
								} else {
							%>
                                        <a href="javascript:void(0);" data-id='<%=goods_list[i].shop_id;%>'>
                                            <%=goods_list[i].store_name;%><i></i></a>
                                        <%
								}
							%>
                                            <div class="sotre-creidt-layout" style="display: none;"></div>
                            </div>
                        </dd>
                    </dl>
                </li>
                <%}%>
                    <% if (hasmore) {%>
                        <li class="loading">
                            <div class="spinner"><i></i></div>商品数据读取中...</li>
                        <% } %>
                            <%
	   }else {
	%>
                                <div class="nctouch-norecord search">
                                    <div class="norecord-ico"><i></i></div>
                                    <dl>
                                        <dt>没有找到任何相关信息</dt>
                                        <dd>选择或搜索其它商品分类/名称...</dd>
                                    </dl>
                                    <a href="javascript:history.go(-1)" class="btn">重新选择</a>
                                </div>
                                <%
	   }
	%>
</script>

<script type="text/javascript" src="../../js/zepto.min.js"></script>
<script type="text/javascript" src="../../js/template.js"></script>
<script type="text/javascript" src="../../js/common.js"></script>
<script type="text/javascript" src="../../js/tmpl/product_list.js"></script>
<script type="text/javascript" src="../../js/tmpl/footer.js"></script>

</html>
<?php 
include __DIR__.'/../../includes/footer.php';
?>