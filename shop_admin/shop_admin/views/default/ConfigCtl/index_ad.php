<?php if (!defined('ROOT_PATH')) {exit('No Permission');}?>
<?php
include $this->view->getTplPath() . '/'  . 'header.php';
// 当前管理员权限
$admin_rights = $this->getAdminRights();
// 当前页父级菜单 同级菜单 当前菜单
$menus = $this->getThisMenus();
?>
<link href="<?=$this->view->css?>/index.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?=$this->view->css_com?>/jquery/plugins/validator/jquery.validator.css">
<link href="<?= $this->view->css_com ?>/webuploader.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?=$this->view->js_com?>/plugins/validator/jquery.validator.js" charset="utf-8"></script>
<script type="text/javascript" src="<?=$this->view->js_com?>/plugins/validator/local/zh_CN.js" charset="utf-8"></script>

<style>
    .webuploader-pick{ padding:1px; }
   /* */
</style>
</head>
<body>
  <div class="wrapper page">
        <div class="fixed-bar">
            <div class="item-title">
                <div class="subject">
                    <h3>模板风格</h3>
                    <h5>首页幻灯将在首页展示</h5>
                </div>
                <ul class="tab-base nc-row">
                    <?php
                        $data_theme = $this->getUrl('Config', 'siteTheme', 'json', null, array('config_type' => array('site')));

                        $theme_id = $data_theme['theme_id']['config_value'];

                        foreach ($data_theme['theme_row'] as $k => $theme_row) {
                            if ($theme_id == $theme_row['name']) {
                                $config = $theme_row['config'];
                                break;
                            }
                        }
                    ?>
                    <?php if (isset($config['index_tpl']) && $config['index_tpl']): ?>
                        <li><a href="<?= Yf_Registry::get('url') ?>?ctl=Floor_Adpage&met=adpage"><span>首页模板</span></a></li>
                    <?php endif; ?>
                    <?php if (isset($config['index_slider']) && $config['index_slider']): ?>
                        <li><a href="<?= Yf_Registry::get('url') ?>?ctl=Config&met=index_slider&config_type%5B%5D=index_slider"><span>首页幻灯片</span></a></li>
                    <?php endif; ?>
                    <?php if (isset($config['index_slider_img']) && $config['index_slider_img']): ?>
                        <li><a class="" href="<?= Yf_Registry::get('url') ?>?ctl=Config&met=index_liandong&config_type%5B%5D=index_liandong"><span>首页联动小图</span></a></li>
                    <?php endif; ?>
                    <li><a class="" href="<?= Yf_Registry::get('url') ?>?ctl=Config&met=index_dajiashuo&config_type%5B%5D=index_dajiashuo"><span>精彩直播</span></a></li>
                    <li><a class="current" href="<?= Yf_Registry::get('url') ?>?ctl=Config&met=index_ad&config_type%5B%5D=index_ad"><span>首页广告位</span></a></li>


                </ul>
            </div>
        </div>
    <!-- 操作说明 -->
    <p class="warn_xiaoma"><span></span><em></em></p><div class="explanation" id="explanation">
        <div class="title" id="checkZoom"><i class="iconfont icon-lamp"></i>
            <h4 title="提示相关设置操作时应注意的要点">操作提示</h4>
            <span id="explanationZoom" title="收起提示"></span><em class="close_warn iconfont icon-guanbifuzhi"></em></div>
        <ul>
            <?=$menus['this_menu']['menu_url_note']?>
        </ul>
    </div>
    <form style="display: none;" method="post" enctype="multipart/form-data" id="acquiesce-setting-form" name="form_acquiesce">
        <input type="hidden" name="config_type[]" value="index_ad"/>
        <div class="ncap-form-default">
            <dl class="row">
                <dt class="tit">
                    <label>首页广告位1</label>
                </dt>
                <dd class="opt">
                    <img id="index_ad_logo1" name="index_ag[index_ad_img1]" alt="选择图片" src="<?=($data['index_ad_img1']['config_value'])?>" width="472px" height="277px"/>

                    <div class="image-line upload-image" id="photo_one_upload">上传图片<i class="iconfont icon-tupianshangchuan"></i></div>
                    <br/>
                      <label title="请输入图片要跳转的链接地址"><i class="fa fa-link"></i> <input class="ui-input w400" style="margin:5px 0" type="text" name="index_ad[<?php if (isset(Perm ::$row['sub_site_id']) && Perm ::$row['sub_site_id']) {
                                echo Perm ::$row['sub_site_id'] . "index_ad_url1";
                            } else {
                                echo "index_ad_url1";
                            } ?>]" value="<?php if (isset(Perm ::$row['sub_site_id']) && Perm ::$row['sub_site_id']) {
                                echo @$data[Perm ::$row['sub_site_id'] . 'index_ad_url1']['config_value'];
                            } else {
                                echo @$data['index_ad_url1']['config_value'];
                            } ?>" placeholder="请输入图片要跳转的链接地址"> </label> <span class="err"><label for="index_ad_url1" class="error valid"></label></span>
                    <input id="index_ad_img1"  name="index_ad[index_ad_img1]" value="<?=($data['index_ad_img1']['config_value'])?>" class="ui-input w400" type="hidden"/>
                    <div class="notic">默认商品图片,最佳显示尺寸为472*277像素</div>
                </dd>
               
            </dl>

            <dl class="row">
                <dt class="tit">
                    <label>首页广告位2</label>
                </dt>
                <dd class="opt">
                    <img id="index_ad_logo2" name="index_ag[index_ad_img2]" alt="选择图片" src="<?=($data['index_ad_img2']['config_value'])?>" width="472px" height="277px"/>

                    <div class="image-line upload-image" id="photo_two_upload">上传图片<i class="iconfont icon-tupianshangchuan"></i></div>
                    <br/>
                      <label title="请输入图片要跳转的链接地址"><i class="fa fa-link"></i> <input class="ui-input w400" style="margin:5px 0" type="text" name="index_ad[<?php if (isset(Perm ::$row['sub_site_id']) && Perm ::$row['sub_site_id']) {
                                echo Perm ::$row['sub_site_id'] . "index_ad_url2";
                            } else {
                                echo "index_ad_url2";
                            } ?>]" value="<?php if (isset(Perm ::$row['sub_site_id']) && Perm ::$row['sub_site_id']) {
                                echo @$data[Perm ::$row['sub_site_id'] . 'index_ad_url2']['config_value'];
                            } else {
                                echo @$data['index_ad_url2']['config_value'];
                            } ?>" placeholder="请输入图片要跳转的链接地址"> </label> <span class="err"><label for="index_ad_url2" class="error valid"></label></span>
                    <input id="index_ad_img2"  name="index_ad[index_ad_img2]" value="<?=($data['index_ad_img2']['config_value'])?>" class="ui-input w400" type="hidden"/>
                    <div class="notic">默认商品图片,最佳显示尺寸为472*277像素</div>
                </dd>
               
            </dl>


            <dl class="row">
                <dt class="tit">
                    <label>首页广告位3</label>
                </dt>
                <dd class="opt">
                    <img id="index_ad_logo3" name="index_ad[index_ad_img3]" alt="选择图片" src="<?=($data['index_ad_img3']['config_value'])?>" width="472px" height="277px"/>

                    <div class="image-line upload-image" id="photo_three_upload">上传图片<i class="iconfont icon-tupianshangchuan"></i></div>
                    <br/>
                      <label title="请输入图片要跳转的链接地址"><i class="fa fa-link"></i> <input class="ui-input w400" style="margin:5px 0" type="text" name="index_ad[<?php if (isset(Perm ::$row['sub_site_id']) && Perm ::$row['sub_site_id']) {
                                echo Perm ::$row['sub_site_id'] . "index_ad_url3";
                            } else {
                                echo "index_ad_url3";
                            } ?>]" value="<?php if (isset(Perm ::$row['sub_site_id']) && Perm ::$row['sub_site_id']) {
                                echo @$data[Perm ::$row['sub_site_id'] . 'index_ad_url3']['config_value'];
                            } else {
                                echo @$data['index_ad_url3']['config_value'];
                            } ?>" placeholder="请输入图片要跳转的链接地址"> </label> <span class="err"><label for="index_ad_url3" class="error valid"></label></span>
                    <input id="index_ad_img3"  name="index_ad[index_ad_img3]" value="<?=($data['index_ad_img3']['config_value'])?>" class="ui-input w400" type="hidden"/>
                    <div class="notic">默认商品图片,最佳显示尺寸为472*277像素</div>
                </dd>
              
            </dl>

            <dl class="row">
                <dt class="tit">
                    <label>首页广告位4</label>
                </dt>
                <dd class="opt">
                    <img id="index_ad_logo4" name="index_ag[index_ad_img4]" alt="选择图片" src="<?=($data['index_ad_img4']['config_value'])?>" width="472px" height="277px"/>

                    <div class="image-line upload-image" id="photo_four_upload">上传图片<i class="iconfont icon-tupianshangchuan"></i></div>
                    <br/>
                    <label title="请输入图片要跳转的链接地址"><i class="fa fa-link"></i> <input class="ui-input w400" style="margin:5px 0" type="text" name="index_ad[<?php if (isset(Perm ::$row['sub_site_id']) && Perm ::$row['sub_site_id']) {
                                echo Perm ::$row['sub_site_id'] . "index_ad_url4";
                            } else {
                                echo "index_ad_url4";
                            } ?>]" value="<?php if (isset(Perm ::$row['sub_site_id']) && Perm ::$row['sub_site_id']) {
                                echo @$data[Perm ::$row['sub_site_id'] . 'index_ad_url4']['config_value'];
                            } else {
                                echo @$data['index_ad_url4']['config_value'];
                            } ?>" placeholder="请输入图片要跳转的链接地址"> </label> <span class="err"><label for="index_ad_url4" class="error valid"></label></span>
                    <input id="index_ad_img4"  name="index_ad[index_ad_img4]" value="<?=($data['index_ad_img4']['config_value'])?>" class="ui-input w400" type="hidden"/>
                    <div class="notic">默认商品图片,最佳显示尺寸为472*277像素</div>
                </dd>
              
                     
            </dl>

          
          <div class="bot"> <a href="javascript:void(0);" class="ui-btn ui-btn-sp submit-btn">确认提交</a></div>
          </div>
    </form>
</div>
<script type="text/javascript" src="<?=$this->view->js_com?>/webuploader.js" charset="utf-8"></script>
<script type="text/javascript" src="<?=$this->view->js?>/models/upload_image.js" charset="utf-8"></script>
<script type="text/javascript" src="<?=$this->view->js?>/controllers/config.js" charset="utf-8"></script>
<script>
$(function(){
    $('.tab-base').find('a').bind('click',function(){
        
        $('.tab-base').find('a').removeClass('current');
        $(this).addClass('current');
        $('form').css('display','none');
        $('form[name="form_'+$(this).attr('nctype')+'"]').css('display','');
    });
    $('form').css('display','none');
    $('form[name="form_acquiesce"]').css('display','');
    
    //图片上传
    function uploadImage() {
        var index_ad_img1 = new UploadImage({
            thumbnailWidth: 472,
            thumbnailHeight: 277,
            imageContainer: '#index_ad_logo1',
            uploadButton: '#photo_one_upload',
            inputHidden: '#index_ad_img1'
        });

        var index_ad_img2 = new UploadImage({
            thumbnailWidth: 472,
            thumbnailHeight: 277,
            imageContainer: '#index_ad_logo2',
            uploadButton: '#photo_two_upload',
            inputHidden: '#index_ad_img2'
        });

        var index_ad_img3 = new UploadImage({
            thumbnailWidth: 472,
            thumbnailHeight: 277,
            imageContainer: '#index_ad_logo3',
            uploadButton: '#photo_three_upload',
            inputHidden: '#index_ad_img3'
        });
        var index_ad_img4 = new UploadImage({
            thumbnailWidth: 472,
            thumbnailHeight: 277,
            imageContainer: '#index_ad_logo4',
            uploadButton: '#photo_four_upload',
            inputHidden: '#index_ad_img4'
        });
    }

    var agent = navigator.userAgent.toLowerCase();

    if ( agent.indexOf("msie") > -1 && (version = agent.match(/msie [\d]/), ( version == "msie 8" || version == "msie 9" )) ) {
        uploadImage();
    } else {
        cropperImage();
    }
        
    //图片裁剪

    function cropperImage() {
        var $imagePreview, $imageInput, imageWidth, imageHeight;

        $('#photo_one_upload, #photo_two_upload, #photo_three_upload,#photo_four_upload').on('click', function () {

            if ( this.id == 'photo_one_upload' ) {
                $imagePreview = $('#index_ad_logo1');
                $imageInput = $('#index_ad_img1');
                imageWidth = 472, imageHeight = 277;
            } else if ( this.id == 'photo_two_upload' ) {
                $imagePreview = $('#index_ad_logo2');
                $imageInput = $('#index_ad_img2');
                imageWidth = 472, imageHeight = 277;
            }  else if ( this.id == 'photo_three_upload' ) {
                $imagePreview = $('#index_ad_logo3');
                $imageInput = $('#index_ad_img3');
                imageWidth = 472, imageHeight = 277;
            }else {
                $imagePreview = $('#index_ad_logo4');
                $imageInput = $('#index_ad_img4');
                imageWidth = 472, imageHeight = 277;
            }
//            console.info($imagePreview);
            $.dialog({
                title: '图片裁剪',
                content: "url: <?= Yf_Registry::get('url') ?>?ctl=Index&met=cropperImage&typ=e",
                data: { SHOP_URL: SHOP_URL, width: imageWidth, height: imageHeight, callback: callback },    // 需要截取图片的宽高比例
                width: '800px',
                height:$(window).height()*0.9,
                lock: true
            })
        });

        function callback ( respone , api ) {
//            console.info($imagePreview);
            $imagePreview.attr('src', respone.url);
            $imageInput.attr('value', respone.url);
            api.close();
        }
    }
 })
</script>
<?php
include $this->view->getTplPath() . '/' . 'footer.php';
?>