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
          </dt>
          <dd class="opt">
            <span><?=($data['first_data'])?></span>
          </dd>
        </dl>
        <dl class="row">
          <dt class="tit">
          </dt>
          <dd class="opt">
            <span><?=htmlspecialchars_decode( $data['message_detail'] )?></span>
          </dd>
        </dl>
        <dl class="row">
          <dt class="tit">
          </dt>
          <dd class="opt">
            <span><?=($data['remark'])?></span>
          </dd>
        </dl>
      </div>
    </form>
    <!-- 消息模板 E --> 
  </div>
</div>
<script type="text/javascript" src="<?=$this->view->js?>/controllers/news/message/wxTemplate_set.js" charset="utf-8"></script>
<?php
include $this->view->getTplPath() . '/' . 'footer.php';
?>