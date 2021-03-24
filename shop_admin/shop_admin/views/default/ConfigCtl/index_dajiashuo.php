<?php if (!defined('ROOT_PATH')) {
    exit('No Permission');
} ?>
<?php
    include $this->view->getTplPath() . '/' . 'header.php';
?>
    <link href="<?= $this->view->css ?>/index.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?= $this->view->css_com ?>/jquery/plugins/validator/jquery.validator.css">
    <script type="text/javascript" src="<?= $this->view->js_com ?>/plugins/validator/jquery.validator.js" charset="utf-8"></script>
    <script type="text/javascript" src="<?= $this->view->js_com ?>/plugins/validator/local/zh_CN.js" charset="utf-8"></script>
    <link href="<?= $this->view->css_com ?>/webuploader.css" rel="stylesheet" type="text/css">
    <style>
        .webuploader-pick {
            padding: 1px;
        }
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
                    <li><a class="current" href="<?= Yf_Registry::get('url') ?>?ctl=Config&met=index_dajiashuo&config_type%5B%5D=index_dajiashuo"><span>精彩直播</span></a></li>
                    <li><a class="" href="<?= Yf_Registry::get('url') ?>?ctl=Config&met=index_ad&config_type%5B%5D=index_ad"><span>首页广告位</span></a></li>


                </ul>
            </div>
        </div>
        <p class="warn_xiaoma"><span></span><em></em></p>
        <div class="explanation" id="explanation">
            <div class="title" id="checkZoom"><i class="iconfont icon-lamp"></i>
                <h4 title="提示相关设置操作时应注意的要点">操作提示</h4>
                <span id="explanationZoom" title="收起提示"></span><em class="close_warn iconfont icon-guanbifuzhi"></em>
            </div>
            <ul>
                <li>该组图片应用于首页使用，最多可上传2张图片。</li>
                <li>图片要求使用宽度为584像素，高度为126像素jpg/gif/png格式的图片。</li>
                <li>上传图片后请添加格式为“http://网址...”链接地址。</li>
            </ul>
        </div>

        <form method="post" enctype="multipart/form-data" id="index_dajiashuo-setting-form" name="form1">
            <input type="hidden" name="config_type[]" value="index_dajiashuo" />
            <div class="ncap-form-default">
                <dl class="row">
                    <dt class="tit">
                        <label>视频PC</label>
                    </dt>
                    <dd class="opt">
                        <div>
                            <div class="div-image">
                                <img id="index_dajiashuo_pc1" src="
                                    <?php if (isset(Perm::$row['sub_site_id']) && Perm::$row['sub_site_id']) {
                                        echo @$data[Perm::$row['sub_site_id'] . 'index_dajiashuo_pc1']['config_value'];
                                    } else {
                                        echo @$data['index_dajiashuo_pc1']['config_value'];
                                    } ?>
                                " width="584" height="126" />
                                <a href="javascript:void(0)" style="display: <?php if (isset(Perm::$row['sub_site_id']) && Perm::$row['sub_site_id']) {echo 'none';}else{echo 'block';}?>" class="del" id="del_btn1" onclick="delImage('index_dajiashuo_pc1')" title="移除"><i class="iconfont icon-cancel"></i></a>
                            </div>
                        </div>
                        <input type="hidden" id="index_dajiashuo_pc1_image" name="index_dajiashuo[<?php if (isset(Perm::$row['sub_site_id']) && Perm::$row['sub_site_id']) {
                            echo Perm::$row['sub_site_id'] . "index_dajiashuo_pc1";
                        } else {
                            echo "index_dajiashuo_pc1";
                        } ?>]" value="<?php if (isset(Perm::$row['sub_site_id']) && Perm::$row['sub_site_id']) {
                            echo @$data[Perm::$row['sub_site_id'] . 'index_dajiashuo_pc1']['config_value'];
                        } else {
                            echo @$data['index_dajiashuo_pc1']['config_value'];
                        } ?>" />
                        <div id='index_dajiashuo_pc1_upload' class="image-line upload-image" style="margin-top: 5px;">图片上传</div>

                    <div style="margin-left: 700px;margin-top: -200px;">
                        <div>
                            <label style="display:block;float:left;margin-left:-80px;">视频移动端</label>
                            <div class="div-image" style="height: 158px;">
                                <img id="index_dajiashuo_wap1" src="
                                    <?php if (isset(Perm::$row['sub_site_id']) && Perm::$row['sub_site_id']) {
                                    echo @$data[Perm::$row['sub_site_id'] . 'index_dajiashuo_wap1']['config_value'];
                                } else {
                                    echo @$data['index_dajiashuo_wap1']['config_value'];
                                } ?>
                                " width="236" height="118" />
                                <a href="javascript:void(0)" style="display: <?php if (isset(Perm::$row['sub_site_id']) && Perm::$row['sub_site_id']) {echo 'none';}else{echo 'block';}?>" class="del" id="del_btn1" onclick="delImage('index_dajiashuo_wap1')" title="移除"><i class="iconfont icon-cancel"></i></a>
                            </div>
                        </div>
                        <input type="hidden" id="index_dajiashuo_wap1_image" name="index_dajiashuo[<?php if (isset(Perm::$row['sub_site_id']) && Perm::$row['sub_site_id']) {
                            echo Perm::$row['sub_site_id'] . "index_dajiashuo_wap1";
                        } else {
                            echo "index_dajiashuo_wap1";
                        } ?>]" value="<?php if (isset(Perm::$row['sub_site_id']) && Perm::$row['sub_site_id']) {
                            echo @$data[Perm::$row['sub_site_id'] . 'index_dajiashuo_wap1']['config_value'];
                        } else {
                            echo @$data['index_dajiashuo_wap1']['config_value'];
                        } ?>" />
                        <div style="margin-top: -6px;" id='index_dajiashuo_wap1_upload' class="image-line upload-image" style="margin-top: 5px;">图片上传</div>
                    </div>
                        <label title="请输入图片要跳转的链接地址"><i class="fa fa-link"></i>
                            <input class="ui-input w400" style="margin:5px 0" type="text" name="index_dajiashuo[<?php if (isset(Perm::$row['sub_site_id']) && Perm::$row['sub_site_id']) {
                                echo Perm::$row['sub_site_id'] . "index_dajiashuo_url1";
                            } else {
                                echo "index_dajiashuo_url1";
                            } ?>]" value="<?php if (isset(Perm::$row['sub_site_id']) && Perm::$row['sub_site_id']) {
                                echo @$data[Perm::$row['sub_site_id'] . 'index_dajiashuo_url1']['config_value'];
                            } else {
                                echo @$data['index_dajiashuo_url1']['config_value'];
                            } ?>" placeholder="请输入图片要跳转的链接地址">
                        </label>
                        <span class="err"><label for="index_dajiashuo_url1" class="error valid"></label></span>
                        <p class="notic">电脑端请使用宽度588像素，高度126像素，手机端请使用宽度766像素，高度88像素的jpg/gif/png格式图片作为联动图片上传<br>
                            如需跳转请在后方添加以http://开头的链接地址。</p>
                    </dd>
                </dl>

                <dl class="row">
                    <dt class="tit">
                        <label>视频PC</label>
                    </dt>
                    <dd class="opt">
                        <div>
                            <div class="div-image">
                                <img id="index_dajiashuo_pc2" src="
                                    <?php if (isset(Perm::$row['sub_site_id']) && Perm::$row['sub_site_id']) {
                                    echo @$data[Perm::$row['sub_site_id'] . 'index_dajiashuo_pc2']['config_value'];
                                } else {
                                    echo @$data['index_dajiashuo_pc2']['config_value'];
                                } ?>
                                " width="584" height="126" />
                                <a href="javascript:void(0)" style="display: <?php if (isset(Perm::$row['sub_site_id']) && Perm::$row['sub_site_id']) {echo 'none';}else{echo 'block';}?>" class="del" id="del_btn1" onclick="delImage('index_dajiashuo_pc2')" title="移除"><i class="iconfont icon-cancel"></i></a>
                            </div>
                        </div>
                        <input type="hidden" id="index_dajiashuo_pc2_image" name="index_dajiashuo[<?php if (isset(Perm::$row['sub_site_id']) && Perm::$row['sub_site_id']) {
                            echo Perm::$row['sub_site_id'] . "index_dajiashuo_pc2";
                        } else {
                            echo "index_dajiashuo_pc2";
                        } ?>]" value="<?php if (isset(Perm::$row['sub_site_id']) && Perm::$row['sub_site_id']) {
                            echo @$data[Perm::$row['sub_site_id'] . 'index_dajiashuo_pc2']['config_value'];
                        } else {
                            echo @$data['index_dajiashuo_pc2']['config_value'];
                        } ?>" />
                        <div id='index_dajiashuo_pc2_upload' class="image-line upload-image" style="margin-top: 5px;">图片上传</div>

                        <div style="margin-left: 700px;margin-top: -200px;">
                            <div>
                                <label style="display:block;float:left;margin-left:-80px;">视频移动端</label>
                                <div class="div-image" style="height: 158px;">
                                    <img id="index_dajiashuo_wap2" src="
                                    <?php if (isset(Perm::$row['sub_site_id']) && Perm::$row['sub_site_id']) {
                                        echo @$data[Perm::$row['sub_site_id'] . 'index_dajiashuo_wap2']['config_value'];
                                    } else {
                                        echo @$data['index_dajiashuo_wap2']['config_value'];
                                    } ?>
                                " width="236" height="118" />
                                    <a href="javascript:void(0)" style="display: <?php if (isset(Perm::$row['sub_site_id']) && Perm::$row['sub_site_id']) {echo 'none';}else{echo 'block';}?>" class="del" id="del_btn1" onclick="delImage('index_dajiashuo_wap2')" title="移除"><i class="iconfont icon-cancel"></i></a>
                                </div>
                            </div>
                            <input type="hidden" id="index_dajiashuo_wap2_image" name="index_dajiashuo[<?php if (isset(Perm::$row['sub_site_id']) && Perm::$row['sub_site_id']) {
                                echo Perm::$row['sub_site_id'] . "index_dajiashuo_wap2";
                            } else {
                                echo "index_dajiashuo_wap2";
                            } ?>]" value="<?php if (isset(Perm::$row['sub_site_id']) && Perm::$row['sub_site_id']) {
                                echo @$data[Perm::$row['sub_site_id'] . 'index_dajiashuo_wap2']['config_value'];
                            } else {
                                echo @$data['index_dajiashuo_wap2']['config_value'];
                            } ?>" />
                            <div style="margin-top: -6px;" id='index_dajiashuo_wap2_upload' class="image-line upload-image" style="margin-top: 5px;">图片上传</div>
                        </div>
                        <label title="请输入图片要跳转的链接地址"><i class="fa fa-link"></i>
                            <input class="ui-input w400" style="margin:5px 0" type="text" name="index_dajiashuo[<?php if (isset(Perm::$row['sub_site_id']) && Perm::$row['sub_site_id']) {
                                echo Perm::$row['sub_site_id'] . "index_dajiashuo_url2";
                            } else {
                                echo "index_dajiashuo_url2";
                            } ?>]" value="<?php if (isset(Perm::$row['sub_site_id']) && Perm::$row['sub_site_id']) {
                                echo @$data[Perm::$row['sub_site_id'] . 'index_dajiashuo_url2']['config_value'];
                            } else {
                                echo @$data['index_dajiashuo_url2']['config_value'];
                            } ?>" placeholder="请输入图片要跳转的链接地址">
                        </label>
                        <span class="err"><label for="index_dajiashuo_url2" class="error valid"></label></span>
                        <p class="notic">请使用宽度588像素，高度126像素，手机端请使用宽度766像素，高度88像素的jpg/gif/png格式图片作为联动图片上传<br>
                            如需跳转请在后方添加以http://开头的链接地址。</p>
                    </dd>
                </dl>





                <dl class="row">
                    <dt class="tit">
                        <label>视频PC</label>
                    </dt>
                    <dd class="opt">
                        <div>
                            <div class="div-image">
                                <img id="index_dajiashuo_pc3" src="
                                    <?php if (isset(Perm::$row['sub_site_id']) && Perm::$row['sub_site_id']) {
                                    echo @$data[Perm::$row['sub_site_id'] . 'index_dajiashuo_pc3']['config_value'];
                                } else {
                                    echo @$data['index_dajiashuo_pc3']['config_value'];
                                } ?>
                                " width="584" height="126" />
                                <a href="javascript:void(0)" style="display: <?php if (isset(Perm::$row['sub_site_id']) && Perm::$row['sub_site_id']) {echo 'none';}else{echo 'block';}?>" class="del" id="del_btn1" onclick="delImage('index_dajiashuo_pc3')" title="移除"><i class="iconfont icon-cancel"></i></a>
                            </div>
                        </div>
                        <input type="hidden" id="index_dajiashuo_pc3_image" name="index_dajiashuo[<?php if (isset(Perm::$row['sub_site_id']) && Perm::$row['sub_site_id']) {
                            echo Perm::$row['sub_site_id'] . "index_dajiashuo_pc3";
                        } else {
                            echo "index_dajiashuo_pc3";
                        } ?>]" value="<?php if (isset(Perm::$row['sub_site_id']) && Perm::$row['sub_site_id']) {
                            echo @$data[Perm::$row['sub_site_id'] . 'index_dajiashuo_pc3']['config_value'];
                        } else {
                            echo @$data['index_dajiashuo_pc3']['config_value'];
                        } ?>" />
                        <div id='index_dajiashuo_pc3_upload' class="image-line upload-image" style="margin-top: 5px;">图片上传</div>

                        <div style="margin-left: 700px;margin-top: -200px;">
                            <div>
                                <label style="display:block;float:left;margin-left:-80px;">视频移动端</label>
                                <div class="div-image" style="height: 158px;">
                                    <img id="index_dajiashuo_wap3" src="
                                    <?php if (isset(Perm::$row['sub_site_id']) && Perm::$row['sub_site_id']) {
                                        echo @$data[Perm::$row['sub_site_id'] . 'index_dajiashuo_wap3']['config_value'];
                                    } else {
                                        echo @$data['index_dajiashuo_wap3']['config_value'];
                                    } ?>
                                " width="236" height="118" />
                                    <a href="javascript:void(0)" style="display: <?php if (isset(Perm::$row['sub_site_id']) && Perm::$row['sub_site_id']) {echo 'none';}else{echo 'block';}?>" class="del" id="del_btn1" onclick="delImage('index_dajiashuo_wap3')" title="移除"><i class="iconfont icon-cancel"></i></a>
                                </div>
                            </div>
                            <input type="hidden" id="index_dajiashuo_wap3_image" name="index_dajiashuo[<?php if (isset(Perm::$row['sub_site_id']) && Perm::$row['sub_site_id']) {
                                echo Perm::$row['sub_site_id'] . "index_dajiashuo_wap3";
                            } else {
                                echo "index_dajiashuo_wap3";
                            } ?>]" value="<?php if (isset(Perm::$row['sub_site_id']) && Perm::$row['sub_site_id']) {
                                echo @$data[Perm::$row['sub_site_id'] . 'index_dajiashuo_wap3']['config_value'];
                            } else {
                                echo @$data['index_dajiashuo_wap3']['config_value'];
                            } ?>" />
                            <div style="margin-top: -6px;" id='index_dajiashuo_wap3_upload' class="image-line upload-image" style="margin-top: 5px;">图片上传</div>
                        </div>
                        <label title="请输入图片要跳转的链接地址"><i class="fa fa-link"></i>
                            <input class="ui-input w400" style="margin:5px 0" type="text" name="index_dajiashuo[<?php if (isset(Perm::$row['sub_site_id']) && Perm::$row['sub_site_id']) {
                                echo Perm::$row['sub_site_id'] . "index_dajiashuo_url3";
                            } else {
                                echo "index_dajiashuo_url3";
                            } ?>]" value="<?php if (isset(Perm::$row['sub_site_id']) && Perm::$row['sub_site_id']) {
                                echo @$data[Perm::$row['sub_site_id'] . 'index_dajiashuo_url3']['config_value'];
                            } else {
                                echo @$data['index_dajiashuo_url3']['config_value'];
                            } ?>" placeholder="请输入图片要跳转的链接地址">
                        </label>
                        <span class="err"><label for="index_dajiashuo_url3" class="error valid"></label></span>
                        
                    </dd>
                </dl>
<dl class="row">
                    <dt class="tit">
                        <label>在线直播</label>
                    </dt>
                    <dd class="opt">
                        <label title="请输入在线直播视频的链接地址"><i class="fa fa-link"></i>
                            <input class="ui-input w400" style="margin:5px 0" type="text" name="index_dajiashuo[mp4]" value='<?=$data['mp4']['config_value']?>' placeholder="请输入在线直播视频的链接地址">
                        </label>
                        <span class="err"><label for="index_dajiashuo_url3" class="error valid"></label></span>
                        
                    </dd>
                </dl>
                <div class="bot"><a href="javascript:void(0);" class="ui-btn ui-btn-sp submit-btn">确认提交</a></div>
        </form>

        <script type="text/javascript" src="<?= $this->view->js ?>/controllers/config.js" charset="utf-8"></script>

        <script type="text/javascript" src="<?= $this->view->js_com ?>/webuploader.js" charset="utf-8"></script>
        <script type="text/javascript" src="<?= $this->view->js ?>/models/upload_image.js" charset="utf-8"></script>
        <script>
//            jQuery(function ($) {
//                var sub_site_id =  <?//=Perm::$row['sub_site_id']?>//;
//                if (sub_site_id) {
//                    $.post(SITE_URL + '?ctl=Config&met=addSubIndex&typ=json', {sub_site_id: sub_site_id}, function (e) {
//                        if (200 == e.status) {
//                            location.reload()
//                        }
//                    });
//                }
//                if (!$('#index_liandong2_image').val()){
//                    $('#index_liandong2_review').attr('src', '/shop_admin/static/common/images/image.png')
//                    $('#del_btn2').hide();
//                }
//                if (!$('#index_liandong1_image').val()){
//                    $('#index_liandong1_review').attr('src', '/shop_admin/static/common/images/image.png')
//                    $('#del_btn1').hide();
//                }
//            });
            $(function () {
                //图片裁剪

                var agent = navigator.userAgent.toLowerCase();

                if (agent.indexOf("msie") > -1 && (version = agent.match(/msie [\d]/), (version == "msie 8" || version == "msie 9"))) {
                    index_dajiashuo_pc1_upload = new UploadImage({
                        thumbnailWidth: 584,
                        thumbnailHeight: 126,
                        imageContainer: '#index_dajiashuo_pc1',
                        uploadButton: '#index_dajiashuo_pc1_upload',
                        inputHidden: '#index_dajiashuo_pc1_image'
                    });
                    index_dajiashuo_wap1_upload = new UploadImage({
                        thumbnailWidth: 766,
                        thumbnailHeight: 151,
                        imageContainer: '#index_dajiashuo_wap1',
                        uploadButton: '#index_dajiashuo_wap1_upload',
                        inputHidden: '#index_dajiashuo_wap1_image'
                    });

                    index_dajiashuo_pc2_upload = new UploadImage({
                        thumbnailWidth: 584,
                        thumbnailHeight: 126,
                        imageContainer: '#index_dajiashuo_pc2',
                        uploadButton: '#index_dajiashuo_pc2_upload',
                        inputHidden: '#index_dajiashuo_pc2_image'
                    });
                    index_dajiashuo_wap2_upload = new UploadImage({
                        thumbnailWidth: 766,
                        thumbnailHeight: 151,
                        imageContainer: '#index_dajiashuo_wap2',
                        uploadButton: '#index_dajiashuo_wap2_upload',
                        inputHidden: '#index_dajiashuo_wap2_image'
                    });

                    index_dajiashuo_pc3_upload = new UploadImage({
                        thumbnailWidth: 584,
                        thumbnailHeight: 126,
                        imageContainer: '#index_dajiashuo_pc3',
                        uploadButton: '#index_dajiashuo_pc3_upload',
                        inputHidden: '#index_dajiashuo_pc3_image'
                    });
                    index_dajiashuo_wap3_upload = new UploadImage({
                        thumbnailWidth: 766,
                        thumbnailHeight: 151,
                        imageContainer: '#index_dajiashuo_wap3',
                        uploadButton: '#index_dajiashuo_wap3_upload',
                        inputHidden: '#index_dajiashuo_wap3_image'
                    });
                   
                } else {
                    var $imagePreview, $imageInput, imageWidth, imageHeight;

                    $('#index_dajiashuo_pc1_upload, #index_dajiashuo_wap1_upload,#index_dajiashuo_pc2_upload, #index_dajiashuo_wap2_upload,#index_dajiashuo_pc3_upload, #index_dajiashuo_wap3_upload,#photo_one_upload,#photo_two_upload,#photo_three_upload').on('click', function () {

                        if (this.id == 'index_dajiashuo_pc1_upload') {
                            $imagePreview = $('#index_dajiashuo_pc1');
                            $imageInput = $('#index_dajiashuo_pc1_image');
                            imageWidth = 584, imageHeight = 126;
//                            $('#del_btn1').show();
                        } else if (this.id == 'index_dajiashuo_wap1_upload'){
                            $imagePreview = $('#index_dajiashuo_wap1');
                            $imageInput = $('#index_dajiashuo_wap1_image');
                            imageWidth = 710, imageHeight = 150;
//                            $('#del_btn2').show();
                        } else if (this.id == 'index_dajiashuo_pc2_upload'){
                            $imagePreview = $('#index_dajiashuo_pc2');
                            $imageInput = $('#index_dajiashuo_pc2_image');
                            imageWidth = 584, imageHeight = 126;
//                            $('#del_btn2').show();
                        } else if (this.id == 'index_dajiashuo_wap2_upload'){
                            $imagePreview = $('#index_dajiashuo_wap2');
                            $imageInput = $('#index_dajiashuo_wap2_image');
                            imageWidth = 710, imageHeight = 151;
//                            $('#del_btn2').show();
                        } else if (this.id == 'index_dajiashuo_pc3_upload'){
                            $imagePreview = $('#index_dajiashuo_pc3');
                            $imageInput = $('#index_dajiashuo_pc3_image');
                            imageWidth = 710, imageHeight = 150;
//                            $('#del_btn2').show();
                        } else if(this.id =='index_dajiashuo_wap3_upload'){
                            $imagePreview = $('#index_dajiashuo_wap3');
                            $imageInput = $('#index_dajiashuo_wap3_image');
                            imageWidth = 710, imageHeight = 150;
//                            $('#del_btn2').show();
                        }else if(this.id == 'photo_one_upload'){
                            $imagePreview = $('#index_video_logo1');
                            $imageInput = $('#index_video_img1');
                            imageWidth = 600, imageHeight = 130;
                        }else if(this.id == 'photo_two_upload'){
                            $imagePreview = $('#index_video_logo2');
                            $imageInput = $('#index_video_img2');
                            imageWidth = 600, imageHeight = 130;
                        }else{
                            $imagePreview = $('#index_video_logo3');
                            $imageInput = $('#index_video_img3');
                            imageWidth = 600, imageHeight = 130;
                        }
                        console.info($imagePreview);
                        $.dialog({
                            title: '图片裁剪',
                            content: "url: <?= Yf_Registry::get('url') ?>?ctl=Index&met=cropperImage1&typ=e",
                            data: {SHOP_URL: SHOP_URL, width: imageWidth, height: imageHeight, callback: callback},    // 需要截取图片的宽高比例
                            width: '800px',
                            height: $(window).height() * 0.9,
                            lock: true
                        })
                    });

                    function callback(respone, api) {
                        console.info($imagePreview);
                        $imagePreview.attr('src', respone.url);
                        $imageInput.attr('value', respone.url);
                        api.close();
                    }
                }
            });

            function delImage(imageId) {
                var $img = $("#" + imageId), $input;
                if (!$img.attr("src")) {
                    return false;
                }
                $.dialog.confirm("是否删除该图片", function () {
                    if (imageId == "index_dajiashuo_pc1") {
                        $input = $("#index_dajiashuo_pc1_image");
//                        $('#del_btn1').hide();
                    } else if (imageId == "index_dajiashuo_wap1"){
                        $input = $("#index_dajiashuo_wap1_image");
//                        $('#del_btn2').hide();
                    } else if (imageId == "index_dajiashuo_pc2"){
                        $input = $("#index_dajiashuo_pc2_image");
//                        $('#del_btn2').hide();
                    } else if (imageId == "index_dajiashuo_wap2"){
                        $input = $("#index_dajiashuo_wap2_image");
//                        $('#del_btn2').hide();
                    } else if (imageId == "index_dajiashuo_pc3"){
                        $input = $("#index_dajiashuo_pc3_image");
//                        $('#del_btn2').hide();
                    } else{
                        $input = $("#index_dajiashuo_wap3_image");
//                        $('#del_btn2').hide();
                    }
                    $img.attr("src", "/shop_admin/static/common/images/image.png"), $input.attr("value", "");
                })
            }
        </script>
<?php
    include $this->view->getTplPath() . '/' . 'footer.php';
?>