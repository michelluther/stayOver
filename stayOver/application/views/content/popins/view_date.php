<div class="row">
	<div class="span2">Bezeichnung</div><div class="span4"><?php echo $date->getName(); ?></div>
</div>
<div class="row">
	<div class="span2">Beginn</div><div class="span4"><?php echo Mpm_calendar::format_date_for_User($date->getBeginDate()) ?>, <?php 
	echo Mpm_calendar::format_time_for_User($date->getBeginDate())
	 ?></div>
</div>
<div class="row">
	<div class="span2">Ende</div><div class="span4"><?php echo Mpm_calendar::format_date_for_User($date->getEndDate()) ?>, <?php 
	echo Mpm_calendar::format_time_for_User($date->getEndDate())
	 ?></div>
</div>
<div class="row">
	<div class="span2">Anmerkungen</div><div class="span4"><?php echo $date->getNote() ?></div>
</div>