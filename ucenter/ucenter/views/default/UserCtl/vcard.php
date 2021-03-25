<?php if (!defined('ROOT_PATH'))
{
    exit('No Permission');
}

include $this->view->getTplPath() . '/' . 'header.php';

?>
    </div>
    <style type="text/css">
        .ml30 {
             margin-left: 16%;
            text-align: center;
        }
        .QRCode{
            text-align: center!important;
        }
        .QRCodeBox{
            margin-top:-10px;
            text-align: center!important;
        }
        .user-avatar {
            width: 80px;
            height: 80px;
            vertical-align: top;
            display: inline-block;
            margin-top: 5px;
        }
        .user-avatar span {
            text-align: center;
            vertical-align: middle;
            display: table-cell;
            width: 80px;
            height: 80px;
            overflow: hidden;
        }
        .user-avatar span img {
            max-width: 80px;
            max-height: 80px;
            border-radius: 50%;
            margin-top: expression(80-this.height/2);
        }
        .user-intro {
            vertical-align: top;
            display: inline-block;
            margin-right: 20px;
            width: 200px;
        }
        .user-intro dl {
            font-size: 0;
            min-height: 20px;
            margin-bottom: 3px;
        }
        .ncm-default-form dl{
            padding: 25px 0 10px 0;
            border-bottom: dotted 1px #ffffff;
        }
        .user-intro dt,.user-intro dd {
            font-size: 14px;
            line-height: 20px;
            vertical-align: top;
            letter-spacing: normal;
            word-spacing: normal;
            display: inline-block;
            
        }
        .user-intro dt,.user-intro dd {
            font-size: 14px;
            line-height: 20px;
            vertical-align: top;
            letter-spacing: normal;
            word-spacing: normal;
            display: inline-block;
        }
    </style>
    <div class="ncm-default-form businessCard-form">
        <form method="post" id="form" name="form" action="" class="formcs busCdFm">
            <input type="hidden" name="<?php echo CSRF::name();?>" value="<?php echo  CSRF::create(); ?>">
            <input type="hidden" name="user_name" value="<?= $data['user_name'] ?>"/>
            <!--            头部-->
            <dl class="AppMemberHd" onclick="javascript:history.back(-1);">
                <dt class="arrowsR"><i></i></dt>
                <dd style="width: 100%!important;"><p>个人中心</p></dd>

            </dl>
            <dl class="visitingCardBox vgCardBx_a">

                <div class="ml30">
                    <div class="user-avatar arL">
                        <span>
                            <img src="<?php if(!empty($data['user_avatar'])){ echo $data['user_avatar'];}else{echo $this->web['user_avatar']; } ?>">
                        </span>
                    </div>
                    <div class="user-intro businessBox">
                        <dl class="businessBT">
                             <dt class="businessName">会员姓名：</dt>
                            <dd>
                               <?= $data['user_truename'] ?>
                            </dd>
                        </dl>
                        <dl class="businessBB">
                            <dt class="businessNumber">会员编号：</dt>
                            <dd>
                              190834892
                            </dd>
                        </dl>
                    
                    </div>
                </div>
            </dl>
           
            <dl class="QRCodeBox visitingCardBox apQRCodBox">
               <!--  <dt>二维码：</dt> -->
                <dd class="QRCode">
                    <span class="w400 apQRCodSn" style="display: contents;">
                        <!-- <img id="qrimg" src="<?= $data['qrurl'] ?>" data-src="ucenter\static\default\images\login_01\twoDimensionCode.png"> -->

                        <div style="display: none;" id="qrcodeCanvas" src="" data-src="ucenter\static\default\images\login_01\twoDimensionCode.png"></div>
                        <img id="img"/>
                    </span>
                </dd>
                <dd class="QRCodeHint" style="text-align:center;width:100%!important;height: 1rem;margin-top:-1rem">
                    <p>扫一扫上面的二维码，加我好友</p>
                </dd>
            </dl>
          
    </div>
    </div>
    </div>
    </div>
    </div>
    <link href="<?= $this->view->css ?>/jquery/plugins/dialog/green.css" rel="stylesheet">
    <script type="text/javascript" src="<?= $this->view->js ?>/plugins/jquery.dialog.js"></script>
    <!--  END 新增地址 -->
    <script type="text/javascript" src="<?= $this->view->js ?>/district.js"></script>
    <!--  js生成二维码 该二维码支持中文和LOGO -->
    <script type="text/javascript" src="<?= $this->view->js ?>/jquery.qrcode.js"></script>
    <script type="text/javascript" src="<?= $this->view->js ?>/utf.js"></script>

    <script>
         $(document).ready(function() {
             var qrcode = $("#qrcodeCanvas").qrcode({
                render : 'canvas',    //设置渲染方式，有table和canvas，使用canvas方式渲染性能相对来说比较好
                text : "<?php echo urldecode($data['qrurl'])  ?>",    //扫描二维码后显示的内容,可以直接填一个网址，扫描二维码后自动跳向该链接 
                width : "150",               //二维码的宽度
                height : "150",              //二维码的高度
                background : "#ffffff",       //二维码的后景色
                src: 'ucenter/static/default/images/20180730135300.jpg'             //二维码中间的图片
             })
            var canvas=qrcode.find('canvas').get(0);
            // 如果有循环,此句必不可少 qrcode.find('canvas').remove();
            var data = canvas.toDataURL('image/png');
            $('#img').attr('src',data) ;

            // var imgSrc = document.getElementById("qrcodeCanvas").toDataURL("image/png");
            // document.getElementById("img").src = imgSrc;
            // function convertCanvasToImage(canvas) {  
            //     //新Image对象，可以理解为DOM  
            //     var image = new Image();  
            //     // canvas.toDataURL 返回的是一串Base64编码的URL
            //     // 指定格式 PNG  
            //     image.src = canvas.toDataURL("image/png");  
            //     return image;  
            // }  

            //获取网页中的canvas对象  
            // var mycans=$('canvas')[0];   
            //调用convertCanvasToImage函数将canvas转化为img形式   
            // var img=convertCanvasToImage(mycans);  
            //将img插入容器 
            // $('#img').append(img); 
            // saveFile(data,"测试");
            //转为图片的方法,需要上门的data
            // function saveFile(data,filename){
                // var save_link=document.createElementNS('http://www.w3.org/1999/xhtml', 'a');
                // save_link.href=data;
                // save_link.download=filename;
                // var event=document.createEvent('MouseEvents');
                // event.initMouseEvent('click',true,false,window,0,0,0,0,0,false,false,false,false,  0,null  );
                // save_link.dispatchEvent(event);
            // };
        });

    </script>
<?php
include $this->view->getTplPath() . '/' . 'footer.php';
?>
