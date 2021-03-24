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
<script type="text/javascript" src="<?=$this->view->js_com?>/plugins/validator/jquery.validator.js" charset="utf-8"></script>
<script type="text/javascript" src="<?=$this->view->js_com?>/plugins/validator/local/zh_CN.js" charset="utf-8"></script>
<style type="text/css">
    .ncap-form-default .SJList{
    width: 670px;
    margin-left: 100px;
    }
    .ncap-form-default dt.SJfDt{
    width: 70px;
    text-align: right;
    padding-right: 20px;
    box-sizing: border-box;
    margin-top: 15px;

    }
.ncap-form-default dd.SJfDd{
    text-align: left;
    width: 240px;    
    margin-top: 15px;


}
.ui-input{
    width:170px;
}

</style>
</head>
<body>
<div class="wrapper page" style="padding: 23px 1% 0 1%;">
    <!-- 操作说明 -->
    <p class="warn_xiaoma"><span></span><em></em></p><div class="explanation" id="explanation">
        <div class="title" id="checkZoom"><i class="iconfont icon-lamp"></i>
            <h4 title="提示相关设置操作时应注意的要点">操作提示</h4>
            <span id="explanationZoom" title="收起提示"></span><em class="close_warn iconfont icon-guanbifuzhi"></em>
        </div>
        <ul>
            <?=$menus['this_menu']['menu_url_note']?>
        </ul>
    </div>
      <div class="wrapper">
            <div class="mod-search cf">
                <div class="fr">
                    <a class="ui-btn" id="btn_return">返回</a>
                </div>
            </div>

        </div>
    <form method="post" enctype="multipart/form-data" id="game-setting-form" name="form1">
        <input type="hidden" name="game_id" id="game_id" value="<?=$data['id']?>">
        <div class="ncap-form-default">
            <dl class="row">
                <dt class="tit">
                    <label><em>*</em>抽奖功能设置</label>
                </dt>
                <dd class="opt">
                    <input type="radio" name="drawFunction" value="1" <?php if($data['drawFunction'] == 1) echo "checked"?>>开启 <input type="radio" name="drawFunction" value="0" <?php if($data['drawFunction'] == 0) echo "checked"?>>关闭
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label><em>*</em>抽奖活动ID</label>
                </dt>
                <dd class="opt">
                    <input id="drawActivityID" name="drawActivityID" value="<?=($data['drawActivityID'])?>" class="input-txt ui-input" type="text">
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label><em>*</em>满额抽奖设置</label>
                </dt>
                <dd class="opt">
                    满 <input id="draw_man_pv" name="draw_man_pv" value="<?=($data['draw_man_pv'])?>"
                           class="input-txt ui-input" type="text"> PV值可以获得一次抽奖码
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label><em>*</em>奖品ID</label>
                </dt>
                <dl class="row SJList" style="padding-left: 8%;">
                    <dt class="tit SJfDt"><label>ID</label></dt>
                    <dd class="opt SJfDd"><input id="draw_id_1" name="draw_id_1" value="<?=($data['draw_id_1'])?>"
                           class="input-txt ui-input" type="text"></dd>

                    <dt class="tit SJfDt"><label>奖品</label></dt>
                    <dd class="opt SJfDd"><input id="draw_goods_1" name="draw_goods_1" value="<?=($data['draw_goods_1'])?>"
                           class="input-txt ui-input" type="text"></dd>
                           
                    <dt class="tit SJfDt"><label>ID</label></dt>
                    <dd class="opt SJfDd"><input id="draw_id_2" name="draw_id_2" value="<?=($data['draw_id_2'])?>"
                           class="input-txt ui-input" type="text"></dd>
                    <dt class="tit SJfDt"><label>奖品</label></dt>
                    <dd class="opt SJfDd"><input id="draw_goods_2" name="draw_goods_2" value="<?=($data['draw_goods_2'])?>"
                           class="input-txt ui-input" type="text"></dd>  

                    <dt class="tit SJfDt"><label>ID</label></dt>
                    <dd class="opt SJfDd"><input id="draw_id_3" name="draw_id_3" value="<?=($data['draw_id_3'])?>"
                           class="input-txt ui-input" type="text"></dd>
                    <dt class="tit SJfDt"><label>奖品</label></dt>
                    <dd class="opt SJfDd"><input id="draw_goods_3" name="draw_goods_3" value="<?=($data['draw_goods_3'])?>"
                           class="input-txt ui-input" type="text"></dd> 

                     <dt class="tit SJfDt"><label>ID</label></dt>
                    <dd class="opt SJfDd"><input id="draw_id_4" name="draw_id_4" value="<?=($data['draw_id_4'])?>"
                           class="input-txt ui-input" type="text"></dd>
                    <dt class="tit SJfDt"><label>奖品</label></dt>
                    <dd class="opt SJfDd"><input id="draw_goods_4" name="draw_goods_4" value="<?=($data['draw_goods_4'])?>"
                           class="input-txt ui-input" type="text"></dd>

                     <dt class="tit SJfDt"><label>ID</label></dt>
                    <dd class="opt SJfDd"><input id="draw_id_5" name="draw_id_5" value="<?=($data['draw_id_5'])?>"
                           class="input-txt ui-input" type="text"></dd>
                    <dt class="tit SJfDt"><label>奖品</label></dt>
                    <dd class="opt SJfDd"><input id="draw_goods_5" name="draw_goods_5" value="<?=($data['draw_goods_5'])?>"
                           class="input-txt ui-input" type="text"></dd>

                     <dt class="tit SJfDt"><label>ID</label></dt>
                    <dd class="opt SJfDd"><input id="draw_id_6" name="draw_id_6" value="<?=($data['draw_id_6'])?>"
                           class="input-txt ui-input" type="text"></dd>
                    <dt class="tit SJfDt"><label>奖品</label></dt>
                    <dd class="opt SJfDd"><input id="draw_goods_6" name="draw_goods_6" value="<?=($data['draw_goods_6'])?>"
                           class="input-txt ui-input" type="text"></dd>

                     <dt class="tit SJfDt"><label>ID</label></dt>
                    <dd class="opt SJfDd"><input id="draw_id_7" name="draw_id_7" value="<?=($data['draw_id_7'])?>"
                           class="input-txt ui-input" type="text"></dd>
                    <dt class="tit SJfDt"><label>奖品</label></dt>
                    <dd class="opt SJfDd"><input id="draw_goods_7" name="draw_goods_7" value="<?=($data['draw_goods_7'])?>"
                           class="input-txt ui-input" type="text"></dd>

                     <dt class="tit SJfDt"><label>ID</label></dt>
                    <dd class="opt SJfDd"><input id="draw_id_8" name="draw_id_8" value="<?=($data['draw_id_8'])?>"
                           class="input-txt ui-input" type="text"></dd>
                    <dt class="tit SJfDt"><label>奖品</label></dt>
                    <dd class="opt SJfDd"><input id="draw_goods_8" name="draw_goods_8" value="<?=($data['draw_goods_8'])?>"
                           class="input-txt ui-input" type="text"></dd>                  

                    
                </dl>
            </dl>
            <div class="bot" style="padding: 12px 0px 10px 44%;"><a href="javascript:void(0);" class="ui-btn ui-btn-sp submit-btn">保存</a></div>
        </div>
    </form>

    <script type="text/javascript">
        
//订单设置
$(function ()
{
    if ($('#game-setting-form').length > 0)
    {
        $('#game-setting-form').validator({
            ignore: ':hidden',
            theme: 'yellow_bottom',
            timely: 1,
            stopOnError: true,
            fields: {
                'drawActivityID': 'required;',
                'draw_man_pv': 'integer[+];required;'
            },
            valid: function (form)
            {
                parent.$.dialog.confirm('修改立马生效,是否继续？', function ()
                    {
                        if(!$("#game_id").val()){
                            Public.ajaxPost(SITE_URL + '?ctl=User_Game&met=addGame&typ=json', $('#game-setting-form').serialize(), function (data)
                            {
                                if (data.status == 200)
                                {
                                    parent.Public.tips({content: '添加活动成功！'});
                                }
                                else
                                {
                                    parent.Public.tips({type: 1, content: data.msg || '操作无法成功，请稍后重试！'});
                                }
                            });
                        }else{
                             Public.ajaxPost(SITE_URL + '?ctl=User_Game&met=editGame&typ=json', $('#game-setting-form').serialize(), function (data)
                            {
                                if (data.status == 200)
                                {
                                    parent.Public.tips({content: '修改活动成功！'});
                                }
                                else
                                {
                                    parent.Public.tips({type: 1, content: data.msg || '操作无法成功，请稍后重试！'});
                                }
                            });
                        }
                    },
                    function ()
                    {
                    });
            },
        }).on("click", "a.submit-btn", function (e)
        {
            $(e.delegateTarget).trigger("validate");
        });
    }
    $("#btn_return").click(function(){
        window.location.href = SITE_URL + "?ctl=User_Game&met=GameManage";
    });
});
    </script>

    <?php
        include $this->view->getTplPath() . '/' . 'footer.php';
    ?>
