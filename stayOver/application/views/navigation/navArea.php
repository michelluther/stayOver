<?php
$baseURL = base_url();
?>
<div class="row">
	<div class="span10" id="logo" onClick="returnHome();">&nbsp;</div>
	<div class="span2 pull-right" id="settingsArea">
		<div class="btn-group">
			<a href="<?php echo $baseURL . 'index.php/';?>settings/start" class="btn btn-mini">Einstellungen</a> 
			<a href="#" onclick="openHelp()" class="btn btn-mini">Hilfe</a>
			<a href="logout" class="btn btn-mini">Log out</a>
		</div>
	</div>
</div>
