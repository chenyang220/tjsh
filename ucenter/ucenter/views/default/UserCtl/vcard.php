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
            <!--            ??????-->
            <dl class="AppMemberHd" onclick="javascript:history.back(-1);">
                <dt class="arrowsR"><i></i></dt>
                <dd style="width: 100%!important;"><p>????????????</p></dd>

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
                             <dt class="businessName">???????????????</dt>
                            <dd>
                               <?= $data['user_truename'] ?>
                            </dd>
                        </dl>
                        <dl class="businessBB">
                            <dt class="businessNumber">???????????????</dt>
                            <dd>
                              190834892
                            </dd>
                        </dl>
                    
                    </div>
                </div>
            </dl>
           
            <dl class="QRCodeBox visitingCardBox apQRCodBox">
               <!--  <dt>????????????</dt> -->
                <dd class="QRCode">
                    <span class="w400 apQRCodSn" style="display: contents;">
                        <!-- <img id="qrimg" src="<?= $data['qrurl'] ?>" data-src="ucenter\static\default\images\login_01\twoDimensionCode.png"> -->

                        <div style="display: none;" id="qrcodeCanvas" src="" data-src="ucenter\static\default\images\login_01\twoDimensionCode.png"></div>
                        <img id="img"/>
                    </span>
                </dd>
                <dd class="QRCodeHint" style="text-align:center;width:100%!important;height: 1rem;margin-top:-1rem">
                    <p>??????????????????????????????????????????</p>
                </dd>
            </dl>
          
    </div>
    </div>
    </div>
    </div>
    </div>
    <link href="<?= $this->view->css ?>/jquery/plugins/dialog/green.css" rel="stylesheet">
    <script type="text/javascript" src="<?= $this->view->js ?>/plugins/jquery.dialog.js"></script>
    <!--  END ???????????? -->
    <script type="text/javascript" src="<?= $this->view->js ?>/district.js"></script>
    <!--  js??????????????? ???????????????????????????LOGO -->
    <script type="text/javascript" src="<?= $this->view->js ?>/jquery.qrcode.js"></script>
    <script type="text/javascript" src="<?= $this->view->js ?>/utf.js"></script>

    <script>
         $(document).ready(function() {
             var qrcode = $("#qrcodeCanvas").qrcode({
                render : 'canvas',    //????????????????????????table???canvas?????????canvas???????????????????????????????????????
                text : "<?php echo urldecode($data['qrurl'])  ?>",    //?????????????????????????????????,????????????????????????????????????????????????????????????????????? 
                width : "150",               //??????????????????
                height : "150",              //??????????????????
                background : "#ffffff",       //?????????????????????
                src: 'ucenter/static/default/images/20180730135300.jpg'             //????????????????????????
             })
            var canvas=qrcode.find('canvas').get(0);
            // ???????????????,?????????????????? qrcode.find('canvas').remove();
            var data = canvas.toDataURL('image/png');
            $('#img').attr('src',data) ;

            // var imgSrc = document.getElementById("qrcodeCanvas").toDataURL("image/png");
            // document.getElementById("img").src = imgSrc;
            // function convertCanvasToImage(canvas) {  
            //     //???Image????????????????????????DOM  
            //     var image = new Image();  
            //     // canvas.toDataURL ??????????????????Base64?????????URL
            //     // ???????????? PNG  
            //     image.src = canvas.toDataURL("image/png");  
            //     return image;  
            // }  

            //??????????????????canvas??????  
            // var mycans=$('canvas')[0];   
            //??????convertCanvasToImage?????????canvas?????????img??????   
            // var img=convertCanvasToImage(mycans);  
            //???img???????????? 
            // $('#img').append(img); 
            // saveFile(data,"??????");
            //?????????????????????,???????????????data
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
