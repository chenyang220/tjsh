<?php if (!defined('ROOT_PATH')) {
    exit('No Permission');
}
    include $this->view->getTplPath() . '/' . 'header.php';
?>
<link rel="stylesheet" href="<?= $this->view->css ?>/security.css">
</div>
<div class="form-style-layout">
    <div class="form-style fmSeMail">
        <div class="step clearfix appMlSp">
            <dl class="step-first current">
                <dt><?= _('1.验证身份') ?></dt>
            </dl>
            <dl class="current">
                <dt><?= _('2')?><?=$action?><?= _('手机')?></dt>
                <dd></dd>
            </dl>
            <dl class="">
                <dt><?= _('3')?><?=$action?><?= _('完成')?></dt>
                <dd></dd>
            </dl>
        </div>
        <dl class="AppMemberHd">
            <dt class="arrowsR" onclick="javascript:history.back(-1);"><i style="margin-top: 0.6rem;"></i></dt>
            <dd style="width: 100%!important;margin-top: 0.4rem!important;"><p>手机号修改</p></dd>

        </dl>
        <form id="form" class="EailverifyFm" name="form" method="post">
            <input type="hidden" value="mobile_verify" name="act">
            <div class="bind-area Appbind-area EailverifyBox EailverifyFm">
                <dl class="clearfix">
                    <dt class="appddL"><em class="icon-must">*</em><?= _('手机') ?><span class="appAddtext">号</span>:</dt>
                    <dd class="appddR">
                        <?php if ($op = "mobile" && $data['user_mobile_verify'] != 1 && $data['user_mobile']) { ?>
                            <input type="hidden" name="user_mobile" id="user_mobile" value="<?= $data['user_mobile'] ?>" />
                            <?= $data['user_mobile'] ?>
                        <?php } else { ?>
                            <input type="text" name="user_mobile" id="user_mobile" class="text" value="" />
                        <?php } ?>
                    </dd>
                </dl>
                <dl>
                    <dt class="appddL"><em>*</em><?= _('图形验证码') ?>：</dt>
                    <dd class="appddR">
                        <input type="text" name="img_yzm" id="img_yzm" maxlength="6" class='text wp41 appText' placeholder="<?= _('请输入验证码') ?>" default="<i class=&quot;i-def&quot;></i><?= _('看不清？点击图片更换验证码') ?>" />
                        <img onClick="get_randfunc(this);" title="<?= _('换一换') ?>" class="img-code fl wp43 appImg-code mailImgCode" style="cursor:pointer;" src='./libraries/rand_func.php' />
                    </dd>
                </dl>
                <dl class="clearfix appClearfix">
                    <dt class="appddL"><em class="icon-must">*</em><?= _('手机验证码：') ?></dt>
                    <dd class="appddR">
                        <input type="text" name="yzm" id="yzm" class="text wp41 fl appText" placeholder="<?= _('请输入手机验证码') ?>" value="" />
                        <input type="button" class="btn-send wid-reset fl" data-type="mobile" value="<?= _('获取手机验证码') ?>" />
                    </dd>
                </dl>
                <input type="button" value="<?= _('提交') ?>" class="big-submit pcSubmit">
                <input type="button" value="确认修改" class="big-submit appSubmit appMail appMobile">
            </div>
        </form>
    </div>
</div>
<!-- 修改成功弹窗 -->
<div class="timeSelectBox">
    <div class="revocationAlert">
        <div class="SsInBox"><img src="ucenter\static\default\images\successIcon.png" alt=""></div>
        <p class="RnAtH">恭喜您，修改手机号成功！</p>
        <p class="RnAtP">您绑定的手机号是 : <span id="callphone">12345678901</span></p>
        <div class="RnBnBox">
            <button class="RnConfirmBn">知道啦</button>

        </div>
    </div>
</div>
<!--<button id="revocationBn" class="appSubmit" style="position:fixed; left:50%;left:50%;width: 100px;height:100px;background-color: #f0f0f0;">弹窗</button>-->
<script type="text/javascript">
    var icon = '<i class="iconfont icon-exclamation-sign"></i>';
    $(".btn-send").click(function () {
        var patrn = /^1\d{10}$/;
        var val = $('#user_mobile').val();
        if (!val) {
            alert("<?=_('请填写手机')?>");
        } else if (!patrn.test(val)) {
            alert("<?=_('请填写正确的手机')?>");
        } else {
            var img_yzm = $('#img_yzm').val();
            $.post(SITE_URL + '?ctl=User&met=getMobileYzm&typ=json', 'mobile=' + val + '&yzm=' + img_yzm, function (resp) {
                if (resp.status == 200) {
                    t = setTimeout(countDown, 1000);
                } else {
                    $('.img-code').click();
                    $(".btn-send").attr("disabled", false);
                    $(".btn-send").attr("readonly", false);
                    $("#user_mobile").attr("readonly", false);
                    alert(resp.msg);
                }
            }, 'json');
        }
    });
    var delayTime = 60;
    var msg = "<?=_('获取验证码')?>";
    
    function countDown() {
        delayTime--;
        $(".btn-send").val(delayTime + "<?=_('秒后重新获取')?>");
        if (delayTime == 0) {
            delayTime = 60;
            $(".btn-send").val(msg);
            $(".btn-send").removeAttr("disabled");
            $(".btn-send").removeAttr("readonly");
            $("#user_mobile").removeAttr("disabled");
            $("#user_mobile").removeAttr("readonly");
            clearTimeout(t);
        } else {
            t = setTimeout(countDown, 1000);
        }
    }
    
    $(".appSubmit").click(function () {
        var ajax_url = SITE_URL + '?ctl=User&met=editMobileInfo&typ=json';
//        $('#form').validator({
//            ignore: ':hidden',
//            theme: 'yellow_right',
//            timely: 1,
//            stopOnError: false,
//            fields: {
//                'user_mobile': 'required;',
//                'yzm': 'required;',
//            },
//            valid: function (form) {
                //表单验证通过，提交表单
            var patrn = /^1\d{10}$/;
            var val = $('#user_mobile').val();
            var yzm = $('#yzm').val();
            var img_yzm = $('#img_yzm').val();
            if (!val) {
                alert("<?=_('请填写手机')?>");
            } else if (!patrn.test(val)) {
                alert("<?=_('请填写正确的手机')?>");
            } else if(!img_yzm){
                alert('请输入图形验证码');
            }else if(!yzm){
                alert('请输入手机验证码');
            }else {
                $.ajax({
                    url: ajax_url,
                    data: $("#form").serialize(),
                    success: function (a) {
                        if (a.status == 200) {
                            $(".timeSelectBox").css('display','block');
                            $('#callphone').html(val);
                            location.href = SITE_URL + "?ctl=User&met=getUserInfo1";
                        } else {
                            if (typeof(a.msg) == 'undefined') {
                                alert("<?=_('操作失败！')?>");
                            } else {
                                alert(a.msg);
                            }
                            return false;
                        }
                    }
                });
            }
//        });
    });




    $(".pcSubmit").click(function () {
        var ajax_url = SITE_URL + '?ctl=User&met=editMobileInfo&typ=json';
        var patrn = /^1\d{10}$/;
        var val = $('#user_mobile').val();
        if (!val) {
            alert("<?=_('请填写手机')?>");
        } else if (!patrn.test(val)) {
            alert("<?=_('请填写正确的手机')?>");
        } else {
        //表单验证通过，提交表单
            $.ajax({
                url: ajax_url,
                data: $("#form").serialize(),
                success: function (a) {
                    if (a.status == 200) {
                        $(".timeSelectBox").css('display','block');
                        $('#callphone').html(val);
                        location.href = SITE_URL + "?ctl=User&met=getUserInfo1";
                    } else {
                        if (typeof(a.msg) == 'undefined') {
                            alert("<?=_('操作失败！')?>");
                        } else {
                            alert(a.msg);
                        }
                        return false;
                    }
                }
            });
        }
//        });
    });
    
    //点击验证码
    function get_randfunc(obj) {
        var sj = new Date();
        url = obj.src;
        obj.src = url + '?' + sj;
    }


// 弹窗
    var width = $(window).width();

    if(width<769) {
        $("#revocationBn").click(function () {
            $(".timeSelectBox").css("display", "inline-block");
            $(document.body).css({
                "overflow-x": "hidden",
                "overflow-y": "hidden"
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

        function closeCover() {
            $(".timeSelectBox").css("display", "none");
            $(document.body).css({
                "overflow-x": "auto",
                "overflow-y": "auto"
            });
            preventBubble();
        }

        $(".timeSelectBox").click(function () {
            closeCover();
        })

        $(".RnConfirmBn").click(function () {
            closeCover();
        })
        $(".revocationAlert").click(function(){
            preventBubble();
        })


    }
</script>
</div>
</div>
</div>
<?php
//    include $this->view->getTplPath() . '/' . 'footer.php';
//?>
