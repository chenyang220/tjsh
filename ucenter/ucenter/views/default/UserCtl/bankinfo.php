<?php if (!defined('ROOT_PATH')) {
    exit('No Permission');
}

include $this->view->getTplPath() . '/' . 'header.php';

?>
</div>
<style type="text/css">
    .ncm-default-form dl dt {
        width: 31%;
    }

    .ncm-default-form dl dd {
        width: 65%;
    }

    .BankCardBox {
        margin-left: -103px !important;
    }

    .ncm-default-form dl {
        border: none;
    }

    .bottom .submit {
        padding: 0 110px;
        margin-left: -32%;
        background-color: #017572;
    }

    .formcs {
        display: inline-block;
        margin: auto;
    }

    .ncm-default-form {
        text-align: center;
    }

    .siteSelect {
        width: 39%;
    }
</style>
<dl class="AppMemberHd">
<!--    001-->
    <dt class="arrowsR"  onclick="javascript:history.back(-1);"><i style="margin-top: 0.6rem;"></i></dt>
    <dd style="width: 100%!important;margin-top: 0.6rem!important;"><p>银行卡信息修改</p></dd>

</dl>
<div class="ncm-default-form appBankForm">
    <div style="text-align: left;background-color: #fff;">只限定修改为个人账户银行卡信息</div>
    <form method="post" id="form" name="form" action="" class="formcs">
        <input type="hidden" name="<?php echo CSRF::name(); ?>" value="<?php echo CSRF::create(); ?>">
        <input type="hidden" name="user_name" value="<?= $data['user_name'] ?>"/>
        <dl>
            <dt class="appDt"></dt>
            <dd class="BankCardBox">
                <p><?= _('拍照上传银行卡照片：') ?></p>
                <div class="BankCardIcon1 appBkCdIn" id="userbankimg" style="width: 240px;height: 151px;">
                    <img id='bankimages' src="ucenter/static/default/images/login_01/bankCard_07.jpg" class="pcShow"
                         width="240" height="151">
                    <img id='bankimages' class="addimg" src="ucenter/static/default/images/login_01/bank_icon.png" class="appShow"
                         width="200" height="115">
                    <!-- <img id='bankimages' src="<?= $data['ImageBank'] ?>" width="240" height="151"> -->
                    <input type="hidden" value="" id="bankimg" class="" name="images">
                </div>

            </dd>
        </dl>
        <dl class="partTwo">
            <dt><?= _('银行卡号：') ?></dt>
            <dd><span class="w400">
                <input type="text" class="text" id="bankaccount" name="bankaccount"
                       value="<?= $data['bankaccount'] ?>" disabled="disabled" style="background: #fff">
            </span>
            </dd>
        </dl>
        <dl>
            <dt><?= _('银行类别：') ?></dt>
            <dd><span class="w400">
                        <!-- <input type="number" class="text" id="bankno" name="bankno"
                         value="<?= $data['bankno'] ?>"> -->
                         <select id="bankno" class="siteSelect" style="width: 150px!important;">
                            <option value="0">请选择</option>
                            <option value="102">中国工商银行</option>
                            <option value="103">中国农业银行</option>
                            <option value="301">交通银行</option>
                        </select>
                    </span>
            </dd>
        </dl>
        <dl>
            <dt><?= _('银行支行名称：') ?></dt>
            <dd><span class="w400">
                    <input type="text" style="width: 173px!important;" class="text" id="banksubranch" name="banksubranch"
                           value="<?= $data['banksubranch'] ?>">
                </span>
            </dd>
        </dl>
        <dl>
            <dt><?= _('银行分行名称：') ?></dt>
            <dd><span class="w400">
                <input type="text" style="width: 173px!important;" class="text " id="bankbranch" name="bankbranch"
                       value="<?= $data['bankbranch'] ?>">
            </span>
            </dd>
        </dl>
        <dl>
            <dt><?= _('开户所在省：') ?></dt>
            <dd>
            <span class="w400">
                        <!-- <input type="text" class="text" id="bankprovince" name="bankprovince"
                         value="<?= $data['bankprovince'] ?>"> -->

                         <select id="province" class="text siteSelect" class="field re_user_password">
                            <option value="载入中">载入中</option>
                        </select>
                    </span>


            </dd>
        </dl>
        <dl>
            <dt><?= _('开户所在市：') ?></dt>
            <dd>
                    <span class="w400">
                  <!--       <input type="text" class="text" id="bankcity" name="bankcity"
                     value="<?= $data['bankcity'] ?>"> -->

                     <select id="city" class="text siteSelect">
                        <option value="载入中">载入中</option>
                    </select>
                </span>

            </dd>
        </dl>

        <dl class="bottom">
            <dt></dt>
            <dd class="AppBnBox">
                <label class="submit-border">
                    <input type="submit" id="submit" class="submit bbc_btns" value="<?= _('确认修改') ?>">
                </label>
            </dd>
        </dl>
    </form>
</div>

<link href="<?= $this->view->css ?>/jquery/plugins/dialog/green.css" rel="stylesheet">
<script type="text/javascript" src="<?= $this->view->js ?>/plugins/jquery.dialog.js"></script>
<!---  END 新增地址 -->
<script type="text/javascript" src="<?= $this->view->js ?>/district.js"></script>

<script type="text/javascript" src="<?= $this->view->js ?>/webuploader.js" charset="utf-8"></script>
<script type="text/javascript" src="<?= $this->view->js ?>/upload/upload_image.js" charset="utf-8"></script>
<link href="<?= $this->view->css ?>/webuploader.css" rel="stylesheet" type="text/css">
<style type="text/css">

    #userbankimg > div {
        width: 240px !important;
        height: 151px !important;
    }
</style>
<script>

    //银行卡
    $(function () {
        //图片上传
        var uploadImage = new UploadImage({

            thumbnailWidth: 498,
            thumbnailHeight: 282,
            imageContainer: '#bankimages',
            uploadButton: '#userbankimg',
            inputHidden: '#bankimg',
            callback: function () {
                $('#bankimg').isValid();
                bankImg();
            }
        });
    })
    var BankType = "<?= $data['bankno'] ?>";
    $("#bankno option[value=" + BankType + "]").attr("selected", "selected");
    //上传银行卡图片
    function bankImg() {
        var bankimg = $('#bankimg').val();
        if (!bankimg) {
            return Public.tips.alert('请上传银行卡正面图片');
        }

        $.ajax({
            url: SITE_URL + '?ctl=User&met=bankcardapi&typ=json',
            type: 'POST',
            data: {'bankimg': bankimg, 'idcard': '<?= $data['user_idcard'] ?>'},
            success: function (res) {

                var iiimg  = $("#bankimg").val();
                if (res.status == 200) {

                    setCookie("banknumber", res.data['bank_card_number'].replace(/\s+/g, ""), 1);

                    $("#bankaccount").attr("value", res.data['bank_card_number'].replace(/\s+/g, "")); //去空格
                    $("#bankno").attr("value", '');
                    $("#banksubranch").attr("value", '');
                    $("#bankbranch").attr("value", '');
                    $("#bankprovince").attr("value", '');
                    $("#bankcity").attr("value", '');
                    $(".addimg").attr("src",iiimg)
                } else {
                    Public.tips.error(res.msg);
                }
            },
            error: function (res) {
                console.log(res);
            }
        });
    }

    //提交修改的信息
    $('#submit').click(function () {
        var banknumber = getCookie("banknumber");
        var bankimg = $("#bankimg").val();
        if ($("#bankaccount").val() != banknumber) {
            Public.tips.error("<?=_('请输入正确的银行卡号')?>");
            return false;
        }
        var bankaccount = $("#bankaccount").val();
        var bankno = $("#bankno").val();
        var banksubranch = $("#banksubranch").val();
        var bankbranch = $("#bankbranch").val();
        var bankprovince = $("#province option:selected").val();
        var bankcity = $("#city option:selected").val();

        if (!bankimg) {
            Public.tips.error("<?=_('请上传银行卡正面图片')?>");
            return false;
        }
        if (!bankaccount) {
            Public.tips.error("<?=_('请输入银行卡号')?>");
            return false;
        }
        if (!bankno) {
            Public.tips.error("<?=_('请输入银行类别')?>");
            return false;
        }
        if (!banksubranch) {
            Public.tips.error("<?=_('请输入银行支行名称')?>");
            return false;
        }
        if (!bankbranch) {
            Public.tips.error("<?=_('请输入银行分行名称')?>");
            return false;
        }
        if (!bankprovince) {
            Public.tips.error("<?=_('请输入开户所在省')?>");
            return false;
        }
        if (!bankcity) {
            Public.tips.error("<?=_('请输入开户所在市')?>");
            return false;
        }
        var params = {
            "bankimg": bankimg,
            "bankaccount": bankaccount,
            "bankno": bankno,
            "banksubranch": banksubranch,
            "bankbranch": bankbranch,
            "bankprovince": bankprovince,
            "bankcity": bankcity
        };
        var ajax_url = SITE_URL + '?ctl=User&met=editbank&typ=json';
        $.ajax({
            type: "POST",
            url: ajax_url,
            dataType: "json",
            async: false,
            data: params,
            success: function (respone) {
                if (respone.status == 200) {

                    Public.tips.success("<?=_('操作成功')?>");
                    setTimeout('location.href= SITE_URL +"?ctl=User&met=bankinfo"',1000);//成功后跳转

                } else {
                    Public.tips.error(respone.msg);
                }
            }
        });
    });

    const address = {};
    address['province'] = "<?= $data['bankprovince'] ?>";
    address['city'] = "<?= $data['bankcity'] ?>";
    if(address.province==''&&address.city==''){
        address['province']= '请选择';
        address['city'] = '请选择';
    }
    sessionStorage.setItem('site', JSON.stringify(address));
</script>
<script type="text/javascript" src="<?= $this->view->js ?>/citySelectSite.js"></script>
<?php
include $this->view->getTplPath() . '/' . 'footer.php';
?>
