<?php if (!defined('ROOT_PATH')) {exit('No Permission');}?>
<?php
include $this->view->getTplPath() . '/'  . 'header.php';
?>
<link href="<?=$this->view->css?>/index.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?=$this->view->css_com?>/jquery/plugins/validator/jquery.validator.css">
<script type="text/javascript" src="<?=$this->view->js_com?>/plugins/validator/jquery.validator.js" charset="utf-8"></script>
<script type="text/javascript" src="<?=$this->view->js_com?>/plugins/validator/local/zh_CN.js" charset="utf-8"></script>
</head>
<body>

<div class="">
  <div class="homepage-focus" nctype="sellerTplContent" style="margin-top:0px;">
    <!-- 模板信息 S -->
    <form class="tab-content" method="post" name="mail_form" id="mail_form">
      <input name="id" value="<?=($data['id'])?>" type="hidden">
      <div class="ncap-form-default">
        <dl class="row">
          <dt class="tit">
            <label>消息模板ID</label>
          </dt>
          <dd class="opt">
            <textarea name="tpl_id" rows="6" class="tarea"><?=($data['tpl_id'])?></textarea>
            <span class="err"></span>
            <p class="notic"> </p>
          </dd>
        </dl>
        <dl class="row">
          <dt class="tit">
            <label>模板头部信息</label>
          </dt>
          <dd class="opt">
            <textarea name="first_data" rows="6" class="tarea"><?=($data['first_data'])?></textarea>
            <span class="err"></span>
            <p class="notic"> </p>
          </dd>
        </dl>
          <dl class="row">
              <dt class="tit">
                  <label>模板内容信息</label>
              </dt>
              <dd class="opt">
                  <span><?=htmlspecialchars_decode( $data['message_detail'] )?></span>
              </dd>
          </dl>
        <dl class="row">
          <dt class="tit">
            <label>模板尾部信息</label>
          </dt>
          <dd class="opt">
            <textarea name="remark" rows="6" class="tarea"><?=($data['remark'])?></textarea>
            <span class="err"></span>
            <p class="notic"> </p>
          </dd>
        </dl>
        <dl class="row">
          <dt class="tit">
            <label>是否开启</label>
          </dt>
          <dd class="opt">
            <div class="onoff">
              <label for="message_switch1" class="cb-enable <?=($data['status']==1 ? 'selected' : '')?>">开启</label>
              <label for="message_switch0" class="cb-disable <?=($data['status']==0 ? 'selected' : '')?>">关闭</label>
              <input id="message_switch1" name="status" <?=($data['status']==1 ? 'checked' : '')?> value="1" type="radio">
              <input id="message_switch0" name="status" <?=($data['status']==0 ? 'checked' : '')?> value="0" type="radio">
            </div>
            <p class="notic"> </p>
          </dd>
        </dl>
        <div class="bot"> <a href="javascript:void(0);" class="ui-btn ui-btn-sp submit-btn">确认提交</a></div>
      </div>
    </form>
    <!-- 消息模板 E --> 
  </div>
</div>
<script type="text/javascript" src="<?=$this->view->js?>/controllers/news/message/wxTemplate_set.js" charset="utf-8"></script>
<?php
include $this->view->getTplPath() . '/' . 'footer.php';
?>