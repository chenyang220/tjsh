<?php if (!defined('ROOT_PATH'))
{
	exit('No Permission');
}
include_once INI_PATH . '/menu.ini.php';

$Base_AppModel = new Base_AppModel();
$app_rows = $Base_AppModel->getByWhere(array('app_status'=>1));


?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		       <link rel="icon" href="./favicon.ico" type="image/x-icon">
        <link rel="Shortcut Icon" href="./favicon.ico" type="image/x-icon" />
		<meta charset="UTF-8">
		<title><?=Web_ConfigModel::value('site_name')?> -<?=Web_ConfigModel::value('title')?></title>
		<meta name="viewport" content="width=device-width,maximum-scale=1,minimum-scale=1"/>
		<meta name="viewport" content="initial-scale=1.0,user-scalable=no"/>
		<meta name="description" content="<?=Web_ConfigModel::value('description')?>" />
		<meta name="Keywords" content="<?=Web_ConfigModel::value('keyword')?>" />
		<link rel="stylesheet" type="text/css" href="<?= $this->view->css ?>/headfoot.css" />
		<link rel="stylesheet" type="text/css" href="<?= $this->view->css ?>/sidebar.css" />
		<link rel="stylesheet" type="text/css" href="<?= $this->view->css ?>/nav.css" />  
		<link rel="stylesheet" type="text/css" href="<?= $this->view->css ?>/base.css" />
		<link href="<?= $this->view->css ?>/iconfont/iconfont.css?ver=<?= VER ?>" rel="stylesheet" type="text/css">
		<link type="text/css" rel="stylesheet" href="<?= $this->view->css ?>/buyer.css">
		<link href="<?= $this->view->css ?>/tips.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="<?= $this->view->css ?>/ModifyThePicture.css"/>
        <link rel="stylesheet" type="text/css" href="<?= $this->view->css ?>/AppMemberCenter.css"/>
		<script type="text/javascript" src="<?= $this->view->js ?>/jquery.js"></script>
        
        <script type="text/javascript" src="<?= $this->view->js ?>/upload_imageone.js"></script>
		<!--[if lt IE 9]>
		<script src="<?=$this->view->js?>/html5shiv.js"></script>
		<script src="<?=$this->view->js?>/respond.js"></script>
		<![endif]-->
		<script type="text/javascript">
			var BASE_URL = "<?=Yf_Registry::get('base_url')?>";
			var SITE_URL = "<?=Yf_Registry::get('url')?>";
			var INDEX_PAGE = "<?=Yf_Registry::get('index_page')?>";
			var STATIC_URL = "<?=Yf_Registry::get('static_url')?>";
			var PAYCENTER_URL = "<?=Yf_Registry::get('paycenter_api_url')?>"

			var DOMAIN = document.domain;
			var WDURL = "";
			var SCHEME = "default";
			try {
				//document.domain = 'ttt.com';
			} catch (e) {}
		</script>
	</head>

	<body>
		<div class="bbuyer_head bbc_bg">
			<div class="wrap clearfix bbc_bg">
				<div class="bbuyer_head_fl">
					<div class="bbuyer_logo">
						<a href="<?= Yf_Registry::get('url') ?>?ctl=Index&met=index"><img src="<?php if($this->web['site_logo']){echo $this->web['site_logo'];}else{echo $this->view->img .'/setting_logo.jpg';} ?>"/></a>
					</div>
					<div class="bbuyer_others">
						<p class="mine_shopmall"><?=_('??????UCenter')?></p>
						<p class="back_mall_index"><a href="<?= Yf_Registry::get('url') ?>"><?=_('??????UCenter??????')?></a></p>
					</div>
					<div class="bbuyer_head_nav">
						<ul>
							<?php foreach ($app_rows as $app_row): ?>
								<?php if (104 != $app_row['app_id']):?>
									<li>
										<?php if (103 == $app_row['app_id']){ ?>
											<a href="<?=$app_row['app_admin_url']?>" target="_blank">
												<?=$app_row['app_name']?>
											</a>
										<?php }else{ ?>
											<a href="<?=$app_row['app_url']?>" target="_blank">
												<?=$app_row['app_name']?>
											</a>
										<?php } ?>
									</li>
								<?php endif; ?>
							<?php endforeach; ?>
							<li>
								<a href="<?= Yf_Registry::get('url') ?>?ctl=Login&met=logout">
									<?= _('??????') ?>
								</a>
							</li>
						</ul>
					</div>
					<div class="nav_more">??????<span class="nav_menu_icon"><i class="nav_more_menu"></i></span></div>
				</div>
				<script type="text/javascript">
					$(".set").hover(function () {
						$(this).find(".sub-menu").css("display", "block");
						$(this).find("i").css("transform", "rotate(-180deg)");

					}, function () {
						$(this).find(".sub-menu").css("display", "none");
						$(this).find("i").css("transform", "rotate(1deg)");
					})

					$(document).ready(function () {
						var onoff = true;
						$(".nav_more").click(function () {
							if (onoff) {
								$(".bbuyer_head_nav").css("display", "block");
								$(".nav_more_menu").css("top", "2px")
								onoff = false;
							} else {
								$(".bbuyer_head_nav").css("display", "none");
								$(".nav_more_menu").css("top", "-5px");
								onoff = true;
							}

						})
					})
					$(function(){
						var hei=$(window).height()-$(".bbuyer_head").height()-100-25;
						if($("body").height() < $(window).height()){
							$(".Colr").css("height",hei);
						}
					})
				</script>
			</div>
		</div>

		<div class="Colr">
			<div class="wrapper ">
				<?php if ($this->ctl == 'Index'): ?>
					<div class="Div_2 clearfix">
						<div class="left  ">
							<div class="_img">
								<img src="<?php if (!empty($this->user['info']['user_avatar']))
						{ ?><?= image_thumb($this->user['info']['user_avatar'], 108, 108) ?><?php }
						else
						{ ?><?= image_thumb($this->web['user_avatar'], 108, 108) ?><?php } ?>" width="108" height="108" />
							</div>
							<div class="font">
								<table>
									<tbody>
										<tr>
											<td colspan="2" class="name">
												<?= $this->user['info']['user_name']; ?>
											</td>
										</tr>
										<tr>
											<td class="fontColor">
												<?= _('????????????:') ?>
											</td>
											<td><span class="nc-grade-mini bbc_bg  pad"><?= $this->user['grade']['user_grade_name'] ?></span></td>
										</tr>
										<tr>
											<td class="fontColor">
												<?= _('????????????:') ?>
											</td>
											<td class="tiao"><span title="<?php if ($this->user['info']['user_level_id'] == 1)
									{ ?>5<?php }
									elseif ($this->user['info']['user_level_id'] == 2)
									{ ?>50<?php }
									else
									{ ?>100<?php } ?>%"><i class="bbc_bg" style="width:<?php if ($this->user['info']['user_level_id'] == 1)
										{ ?>1<?php }
										elseif ($this->user['info']['user_level_id'] == 2)
										{ ?>50<?php }
										else
										{ ?>100<?php } ?>%;"></i></span><a><?php if ($this->user['info']['user_level_id'] == 1)
										{ ?><?= _('???') ?><?php }
										elseif ($this->user['info']['user_level_id'] == 2)
										{ ?><?= _('???') ?><?php }
										else
										{ ?><?= _('???') ?><?php } ?></a></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="right  ">
							<div class="_left">
								<ul>
									<li>
										<div class="Divradius">
											<a href="<?= Yf_Registry::get('url') ?>?ctl=Order&met=physical&status=wait_pay"><img src="<?= $this->view->img ?>/ico_dai1.png"></a></div>
										<p class="_p">
											<?= _('?????????') ?> <strong><?= $this->count['count1'] ?></strong>
										</p>
									</li>
									<li>
										<div class="Divradius">
											<a href="<?= Yf_Registry::get('url') ?>?ctl=Order&met=physical&status=wait_confirm_goods"><img src="<?= $this->view->img ?>/ico_dai2.png"></a></div>
										<p class="_p">
											<?= _('?????????') ?> <strong><?= $this->count['count2'] ?></strong>
										</p>
									</li>
									<li>
										<div class="Divradius">
											<a href="<?= Yf_Registry::get('url') ?>?ctl=Order&met=physical&status=finish"><img src="<?= $this->view->img ?>/ico_dai3.png"></a></div>
										<p class="_p">
											<?= _('?????????') ?>
												<strong><?= $this->count['count3'] ?></strong>
										</p>
									</li>
									<li>
										<div class="Divradius">
											<a href="<?= Yf_Registry::get('url') ?>?ctl=Order&met=physical&status=cancel"><img src="<?= $this->view->img ?>/ico_dai4.png"></a></div>
										<p class="_p">
											<?= _('?????????') ?>
												<strong><?= $this->count['count4'] ?></strong>
										</p>
									</li>
								</ul>
							</div>
							<div class="b_rol">
								<div class=" same">
									<div class="same_1">
										<i class="iconfont icon-iconyue ts_1"></i>
										<a href="<?= Yf_Registry::get('url') ?>?ctl=Property&met=cash">
											<?= _('??????') ?>
										</a>
									</div>
									<div class="same_2" id="mons"></div>
								</div>
								<div class="same">
									<div class="same_1">
										<i class="iconfont  icon-iconjifen ts_2"></i>
										<a href="<?= Yf_Registry::get('url') ?>?ctl=Points&met=points">
											<?= _('??????') ?>
										</a>
									</div>
									<div class="same_2">
										<?= $this->user['points']['user_points']; ?>
									</div>
								</div>
								<div class="same">
									<div class="same_1">
										<i class="iconfont icon-iconquan  ts"></i>
										<a href="<?= Yf_Registry::get('url') ?>?ctl=Voucher&met=voucher">
											<?= _('?????????') ?>
										</a>
									</div>
									<div class="same_2">
										<?= $this->user['voucher']; ?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php endif; ?>
						<!--
     <div  class="shangcheng  " >
       <div class="ncm-header-nav">
      <ul class="nav-menu clearfix">
        <li class="hov">
          <a href="#" class="current" style="color:#333;"><?= _('????????????') ?></a>

        </li>
        <li class="set"><a href="<?= Yf_Registry::get('url') ?>?ctl=User&met=getUserInfo" class="current"><?= _('????????????') ?><i class="iconfont">&#xe632;</i></a>
          <div class="sub-menu">
            <dl>
              <dt><a href="<?= Yf_Registry::get('url') ?>?ctl=User&met=security" style="color: #3AAC8A;"><?= _('????????????') ?></a></dt>
              <dd><a href="<?= Yf_Registry::get('url') ?>?ctl=User&met=security&op=mobile"><?= _('????????????') ?></a></dd>
              <dd><a href="<?= Yf_Registry::get('url') ?>?ctl=User&met=security&op=email"><?= _('????????????') ?></a></dd>
            </dl>
            <dl>
              <dt><a href="<?= Yf_Registry::get('url') ?>?ctl=User&met=getUserInfo" style="color: #EA746B"><?= _('????????????') ?></a></dt>
              <dd><a href="<?= Yf_Registry::get('url') ?>?ctl=User&met=tag"><?= _('????????????') ?></a></dd>
              <dd><a href="<?= Yf_Registry::get('url') ?>?ctl=User&met=getUserImg"><?= _('????????????') ?></a></dd>
              <dd><a href="<?= Yf_Registry::get('url') ?>?ctl=Message&met=message&op=manage"><?= _('??????????????????') ?></a></dd>

            </dl>
            <dl>
              <dt><a href="<?= Yf_Registry::get('url') ?>?ctl=Property&met=cash" style="color: #FF7F00"><?= _('????????????') ?></a></dt>
              <dd><a href="<?= Yf_Registry::get('url') ?>?ctl=Voucher&met=voucher"><?= _('???????????????') ?></a></dd>
			  <dd><a href="<?= Yf_Registry::get('url') ?>?ctl=Points&met=Points"><?= _('????????????') ?></a></dd>

            </dl>
            <dl>
              <dt><a href="<?= Yf_Registry::get('url') ?>?ctl=Favorites&met=favoritesGoods"  style="color: #398EE8"><?= _('????????????') ?></a></dt>
              <dd><a href="<?= Yf_Registry::get('url') ?>?ctl=Favorites&met=favoritesShop"><?= _('????????????') ?></a></dd>
            </dl>
          </div>
        </li>
      </ul>
     </div>
    </div>
 	-->
						<div class="clearfix">
							<?php
			if ('Index' == $ctl && 'index' == $met)
			{
				?>
								<div class="left_1   visible-lg">
									<?php
					foreach ($buyer_menu[$level_row[1]]['sub'] as $menu_row)
					{
						?>
										<ul class="jiaoyizhognxin clearfix">
											<li class="midisplay">
												<a href="#" class="_font">
													<?= $menu_row['menu_name'] ?>
												</a>
											</li>
											<?php
						if (!empty($menu_row['sub']))
						{
							foreach ($menu_row['sub'] as $menus_row)
							{
								?>
												<li>
													<a href="<?= sprintf('%s?ctl=%s&met=%s', Yf_Registry::get('url'), $menus_row['menu_url_ctl'], $menus_row['menu_url_met'], $menus_row['menu_url_parem']); ?>" class="_Color" style="<?= ($menus_row['menu_id'] == $level_row[1]) ? 'color:#017572;' : '' ?>">
														<?= $menus_row['menu_name'] ?>
													</a>
												</li>
												<?php
							}
							?>

										</ul>
										<?php
						}
					}
					?>

								</div>
								<?php
			}
			else
			{
			?>
									<div class="left_1 visible-lg">
										<?php

				foreach ($buyer_menu[$level_row[1]]['sub'] as $menu_row)
				{
					?>
											<ul class="jiaoyizhognxin clearfix">
												<li class="midisplay">
													<a href="#" class="_font">
														<?= $menu_row['menu_name'] ?>
													</a>
												</li>
												<?php
					if (!empty($menu_row['sub']))
					{
						foreach ($menu_row['sub'] as $menus_row)
						{

							?>
													<li>
														<a href="<?= sprintf('%s?ctl=%s&met=%s', Yf_Registry::get('url'), $menus_row['menu_url_ctl'], $menus_row['menu_url_met'], $menus_row['menu_url_parem']); ?>" class="_Color" <?php if($_GET['op'] == 'mobile'){$level_row[3] = 1000048;}?>style="<?= ($menus_row['menu_id'] == $level_row[3]) ? 'color:#017572;' : '' ?>">
															<?= $menus_row['menu_name'] ?>
														</a>
													</li>
													<?php
						}
						?>

											</ul>
											<?php
					}
				}
				?>

									</div>
									<?php
			if (isset($buyer_menu[$level_row[1]]['sub'][$level_row[2]]['sub'][$level_row[3]]['sub']))
			{
			?>
										<div class="aright">
											<div class="member_infor_content">
												<div class="tabmenu">
													<ul class="tab pngFix">
														<?php
							foreach ($buyer_menu[$level_row[1]]['sub'][$level_row[2]]['sub'][$level_row[3]]['sub'] as $menu_row)
							{
								?>
															<li class="<?= ($menu_row['menu_id'] == $level_row[4]) ? 'active' : 'normal' ?>">
																<a href="<?= sprintf('%s?ctl=%s&met=%s', Yf_Registry::get('url'), $menu_row['menu_url_ctl'], $menu_row['menu_url_met'], $menu_row['menu_url_parem']); ?>">
																	<?= $menu_row['menu_name'] ?>
																</a>
															</li>
															<?php
							}
							?>
													</ul>
													<?php
						}
						?>
														<?php
						}
						?>