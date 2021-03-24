var reset = true;
var page = pagesize;
var hasMore = true;
var footer = false;
var curpage = 0;
var status = true;
$(function () {
    var e = getCookie("key");
    var u = getCookie("id");
    t();
});

$(document).on('click','.cancel-appaly',function(){
    var e = $(this).attr('order_return_id');
    r(e);
});

function r(e) {
    $.sDialog({
        content: "您将撤销本次申请，如果问题未解决，您还可以再次发起。确定继续吗？", okFn: function () {
            a(e);
        }
    })
}



function a(e){
    $.post( ApiUrl  + '?ctl=Buyer_Service_Return&met=CancelAppaly&typ=json',{order_return_id:e},function(data)
    {
        if (data.status == 200) {
            window.location.reload();
        } else {
            $.sDialog({skin: "red", content: "操作失败！", okBtn: false, cancelBtn: false})
        }
    });
}
$(window).scroll(function () {
    if ($(window).scrollTop() + $(window).height() > $(document).height() - 1) {
        t()
    }
})
function t() {
        var e = getCookie("key");
        if (reset) {
            curpage = 0;
            hasMore = true
        }
        $(".loading").remove();
        if (!hasMore) {
            return false
        }
        hasMore = false;
        if (status==false) {
            return false;
        }
        $.ajax({
            type: "post",
            url: ApiUrl + "/index.php?ctl=Buyer_Service_Return&met=index&typ=json&firstRow=" + curpage,
            data: {k: e, u: getCookie('id')},
            dataType: "json",
            success: function (e) {
                checkLogin(e.login);
                console.log(e);
                curpage = e.data.page * pagesize;
                if(page < e.data.totalsize)
                {
                    hasMore = true;
                }
                if (e.data.page>e.data.total) {
                    status = false;
                    return false;
                }
                if (!hasMore) {
                    get_footer()
                }
                if (e.data.items.length <= 0) {
                    $("#footer").addClass("posa")
                } else {
                    $("#footer").removeClass("posa")
                }
                var t = e;
                t.data.WapSiteUrl = WapSiteUrl;
                t.ApiUrl = ApiUrl;
                t.key = getCookie("key");
                var r = template.render("refund-list-tmpl",t.data);
                if (reset) {
                    reset = false;
                    $("#refund-list").html(r)
                } else {
                    $("#refund-list").append(r)
                }
            }
        })
    }
function get_footer() {
    if (!footer) {
        footer = true;
        $.ajax({url: "../../js/tmpl/footer.js", dataType: "script"})
    }
}