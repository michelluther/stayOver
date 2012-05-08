<h1>Sch&ouml;n, dass Du da bist</h1>
<h2>Ein kleiner &Uuml;berblick &uuml;ber die n&auml;chsten Termine:</h2>
<?php if(count($nextDates) != 0){ ?>
<ul class="list_dates next_dates">
	<?php foreach ($nextDates as $date) {?>
	<li><span class="day_of_week"><?=Mpm_calendar::get_week_day($date->getBeginDate())?>
	</span> </span><span class="date"><?=Mpm_calendar::format_date_for_User($date->getBeginDate())?>
	</span> <?=$date->getTitle()?><img src="" onClick="$.blockUI();" /></li>
	<?php } ?>
</ul>
<?php } else { ?>
<p>keine n&auml;chsten Daten</p>
<?php } ?>