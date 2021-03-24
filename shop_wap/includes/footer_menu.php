 <?php 

$footer_menu = [
	'首页'=>$WapSiteUrl.'/index.html',
	'分类'=>$WapSiteUrl.'/tmpl/product_first_categroy.html',
	'购物车'=>$WapSiteUrl.'/tmpl/cart_list.html',
	'我的'=>$WapSiteUrl.'/tmpl/member/member.html',
];

?> 

 <div class="footer bort1">
	<ul class="clearfix">
		<?php foreach($footer_menu as $k=>$v){?>
			<li <?php if(menu_active($v)){?> class="active"<?php }?> >
				<a href="<?php echo $v;?>"> 
						<i class="icon"></i>
						<h3><?php echo $k; ?></h3>
				</a> 
			</li>
		 <?php } ?>
	</ul>
</div>  
<iframe style="display: none;" src="<?php echo $PayCenterWapUrl.'?ctl=Index&met=iframe'; ?>"></iframe>