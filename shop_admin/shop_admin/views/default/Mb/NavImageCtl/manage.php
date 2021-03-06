<?php if (!defined('ROOT_PATH')) {
    exit('No Permission');
} ?>

<?php
include TPL_PATH . '/' . 'header.php';
?>
<link href="<?= $this->view->css_com ?>/webuploader.css" rel="stylesheet" type="text/css">
<form method="post" id="shop_api-setting-form" name="settingForm" class="nice-validator n-yellow" novalidate="novalidate">
    <div class="ncap-form-default">
        <dl class="row">
            <dt class="tit">
                <label for="site_name">导航名称</label>
            </dt>
            <dd class="opt">
                <input type="text" name="nav_name" id="nav_name" value="">
                <p class="notic">请输入导航名称</p>
            </dd>
        </dl>
        <dl class="row">
            <dt class="tit">
                <label for="site_name">展示图片</label>
            </dt>
            <dd class="opt">
                <img id="textfield1" name="textfield1" alt="选择图片" src="http://127.0.0.1/yf_shop_admin/shop_admin/static/default/images/default_user_portrait.gif" width="98px" height="98px">

                <div class="image-line upload-image" id="button1">上传图片</div>

                <input id="nav_image" name="" value="" class="ui-input w400" type="hidden">
                <div class="notic">展示图片，建议大小98x98像素PNG图片。</div>
            </dd>
        </dl>
        <dl class="row">
            <dt class="tit">
                <label for="site_name">导航链接</label>
            </dt>
            <dd class="opt">
               	<input type="text" name="nav_url" id="nav_url" value="">
                <p class="notic">输入需要链接的页面</p>
            </dd>
        </dl>
    </div>
</form>

<?php
include TPL_PATH . '/' . 'footer.php';
?>
<script type="text/javascript" src="<?=$this->view->js_com?>/webuploader.js" charset="utf-8"></script>
<script type="text/javascript" src="<?=$this->view->js?>/models/upload_image.js" charset="utf-8"></script>
<script>
    $(function() {
        api = frameElement.api, data = api.data, oper = data.oper, callback = data.callback; var nav_id;

        if ( oper == 'edit' ) {
            //init
            var rowData = data.rowData;

            nav_id = rowData.nav_id;

            $('#textfield1').prop('src', rowData.nav_image);
            $('#nav_image').val(rowData.nav_image);
            $('#nav_name').val(rowData.nav_name);
            $('#nav_url').val(rowData.nav_url);


        }

        api.button({
            id: "confirm", name: '确定', focus: !0, callback: function () {
                postData();
                return false;
            }
        }, {id: "cancel", name: '取消'});

        function postData() {

            var param = {
                nav_image: $('#nav_image').val(),
                nav_name: $('#nav_name').val(),
                nav_url: $('#nav_url').val()
            };

            if ( oper == 'edit' ) {
                param.nav_id = data.rowData.nav_id;
            }

            Public.ajaxPost(SITE_URL + '?ctl=Mb_NavImage&met=' + oper + 'NavImage&typ=json', {
                param: param
            }, function (data) {
                if (data.status == 200) {
                    typeof callback == 'function' && callback(data.data, oper, window);
                    return true;
                } else {
                    Public.tips({type: 1, content: data.msg});
                }
            })
        }

        // var linkCatCombo = $("#link_category").combo({
        //     data: SITE_URL + "?ctl=Category&met=lists&typ=json&type_number=goods_cat&is_delete=2",
        //     value: "cat_id",
        //     text: "cat_name",
        //     width: 210,
        //     ajaxOptions: {
        //         formatData: function (e)
        //         {
        //             var rowData_1 = new Array(), rowData = e.data.items;
        //             for(var i=0; i<rowData.length; i++) {
        //                 if (rowData[i].cat_level == 1) {
        //                     rowData_1.push(rowData[i]);
        //                 }
        //             }
        //             return rowData_1;
        //         }
        //     },
        //     defaultSelected: cat_id ? ['cat_id', cat_id] : 0
        // }).getCombo();

         new UploadImage({
            thumbnailWidth: 98,
            thumbnailHeight: 98,
            imageContainer: '#textfield1',
            uploadButton: '#button1',
            inputHidden: '#nav_image'
        });

    });
</script>
