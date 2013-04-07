<div class="row">
	<div class="span2">Bezeichnung</div><div class="span4"><p><?php echo $date->getName(); ?></p></div>
</div>
<div class="row">
	<div class="span2">Beginn</div><div class="span4"><p><?php echo Mpm_calendar::format_date_for_User($date->getBeginDate()) ?>, <?php 
	echo Mpm_calendar::format_time_for_User($date->getBeginDate())
	 ?></p></div>
</div>
<div class="row">
	<div class="span2">Ende</div><div class="span4"><p><?php echo Mpm_calendar::format_date_for_User($date->getEndDate()) ?>, <?php 
	echo Mpm_calendar::format_time_for_User($date->getEndDate())
	 ?></p></div>
</div>
<div class="row">
	<div class="span2"><p>Anmerkungen</p></div><div class="span4"><p><?php echo $date->getNote() ?></p></div>
</div>