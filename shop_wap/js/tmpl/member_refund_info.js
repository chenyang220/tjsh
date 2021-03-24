$(function () {
    var e = getCookie("key");
    var u = getCookie("id");

    var r = getQueryString("refund_id");
    
    template.helper("isEmpty", function (e) {
        for (var r in e) {
            return false
        }
        return true
    });
    $.getJSON(ApiUrl + "/index.php?ctl=Buyer_Service_Return&met=index&act=detail&typ=json", {k: e,u:u, id: r}, function (e) {
        $("#refund-info-div").html(template.render("refund-info-script", e.data))
        $("#revocationBn").click(function(){
            $(".timeSelectBox").css("display","inline-block");
            $(document.body).css({
                "overflow-x":"hidden",
                "overflow-y":"hidden"
            });
            preventBubble();
        });
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
        $(".RnCancelBn").click(function(){
            closeCover();
        })
        $(".revocationAlert").click(function(){
            preventBubble();
        })
        $(".RnConfirmBn").click(function(){
            console.log('1');
            var e = $(this).attr('order_return_id');
            a(e);
        });

        function a(e){
            $.post( ApiUrl  + '?ctl=Buyer_Service_Report&met=CancelAppaly&typ=json',{order_return_id:e},function(data)
            {
                if (data.status == 200) {
                    window.location.reload();
                } else {
                    $.sDialog({skin: "red", content: "操作失败！", okBtn: false, cancelBtn: false})
                }
            });
        }

    })

});