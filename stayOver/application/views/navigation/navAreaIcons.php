<?php
$baseURL = base_url();
if ($navigation['data'] != null) {
	$navigationContent = $navigation['data']->get_navigationEntries();
	?>
<div class="row">
	<div class="span12">
		<div id="logo" class="hidden-phone" onClick="returnHome();">&nbsp;</div>
		<div class="pull-right" id="NavArea">
			<ul id="mainNavigation">
				<!-- <li class="activeNavEntry"><a href="#" onClick="returnHome();"><i
						class="icon-th-list"></i><br />Termine</a></li>
				<li><a href="<?php echo $baseURL . 'index.php/';?>settings/start"
					class="navEntry"><i class="icon-user"></i><br />Profil</a></li>
				<li><a href="logout" class="navEntry"><i class="icon-off"></i><br />Log
						out</a></li>
						 -->
				<?php 
				foreach ($navigationContent as $navigationEntry) {
				 	$name = $navigationEntry->get_name();
				 	$activity = $navigationEntry->get_activity();
				 	$activity_link = $baseURL . 'index.php/' . $activity;
				 	$cssClass = ($navigationEntry->get_is_active()) == true ? 'activeNavEntry' : 'inactiveNavEntry' ;
				 	$icon = $navigationEntry->get_icon();
				 	?>
				<li class="<?= $cssClass ?>"><a href="<?= $activity_link ?>"><i
						class="<?= $icon ?>"></i><br /> <?= $name ?> </a></li>
				<?php }?>
			</ul>
		</div>
	</div>
</div>
<div class="row">
	<div class="span12 dropshadow">
		<div class="dropshadow_left pull-left">&nbsp;</div>
		<div class="dropshadow_right pull-right">&nbsp;</div>
	</div>
</div>
<?php } ?>