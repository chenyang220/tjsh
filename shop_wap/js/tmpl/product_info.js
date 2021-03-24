$(function () {
    var goods_id = getQueryString("goods_id");
    $.ajax({
        url: ApiUrl + "/index.php?ctl=Goods_Goods&met=getGoodsDetailFormat&typ=json",
        data: {gid: goods_id},
        type: "get",
        success: function (data) {
            var st = '<a href="javascript:void(0);" id="goodsEvaluation">评价</a>';
            if(data.data.is_eval == 0){
                $("#eval").css('display','none');
            }else{
                $("#eval").html(st);
            }
            var html = '';
            if(data.data.goods_format_top)
            {
                html += data.data.goods_format_top;
            }
            if(data.data.brand_name)
            {
                html += '<p style="text-align: left;">品牌：'+ data.data.brand_name +'</p>';
            }
            if(data.data.common_property_row)
            {
                for(var i in data.data.common_property_row)
                {
                    html += '<p style="text-align: left;">'+ i +'：'+ data.data.common_property_row[i] +'</p>';
                }
            }
            html += data.data.common_description;
            html += data.data.common_detail;
            if(data.data.goods_format_bottom)
            {
                html += data.data.goods_format_bottom;
            }
            $(".fixed-tab-pannel").html(html);
             // input禁止输入
                $(function(){
                    $("input:text").attr("disabled",true);
                    $("#DynamicTable tr td:first-child").find("input").css("text-align","right");
                })
        }
    });
    $("#goodsDetail").click(function () {
        window.location.href = WapSiteUrl + "/tmpl/product_detail.html?goods_id=" + goods_id
    });
    $("#goodsBody").click(function () {
        window.location.href = WapSiteUrl + "/tmpl/product_info.html?goods_id=" + goods_id
    });
    // $("#goodsEvaluation").click(function () {
    //     window.location.href = WapSiteUrl + "/tmpl/product_eval_list.html?goods_id=" + goods_id
    // })

    $('body').on('click', '#goodsEvaluation,#goodsEvaluation1,#reviewLink', function () {
        window.location.href = WapSiteUrl + '/tmpl/product_eval_list.html?goods_id=' + goods_id;
    });

    $('body').on('click', '#goodsRecommendation', function () {
        window.location.href = WapSiteUrl + '/tmpl/product_recommendation.html?goods_id=' + goods_id;
    });
});