<div class="dateList">
	<?php if(count($openDatesHelper) != 0){  ?>

	<?php

	foreach ($openDatesHelper as $date) { ?>
	<div class="dateListEntry">
		<div class="dateData">
			<h4>
				<?= $date->getTitle() ?>
			</h4>
			<span class="dateEntryAttribute">Kind:</span> <span
				class="dateEntryAttributeValue"> <?php $children = $date->getChildren(); 
				foreach ($children as $child) {
				echo $child->getFirstName();
			}?>
			</span> <br /> <span class="dateEntryAttribute">Datum:</span> <span
				class="dateEntryAttributeValue">von <?= Mpm_Calendar::format_date_for_User($date->getBeginDate()) ?>
				, <?php 
				echo Mpm_calendar::format_time_for_User($date->getBeginDate())
				?> bis <?= Mpm_Calendar::format_date_for_User($date->getEndDate()) ?>
				, <?php
				echo Mpm_calendar::format_time_for_User($date->getEndDate())
				?>
			</span>
		</div>
		<div class="dateButtons">
			<div class="btn-group btn-group-vertical">
				<a class="btn btn-small"
					onclick="openViewDate(<?php echo $date->getID() ?>)"><i
					class="icon-eye-open"></i> </a> <a class="btn btn-small"
					onclick="openAssignDateToSelf(<?php echo $date->getID() ?>)"><i
					class="icon-resize-small"></i> </a> <a class="btn btn-small"
					onclick="openCalendarEntry(<?php echo $date->getID() ?>)"><i
					class="icon-calendar"></i> </a>
			</div>
		</div>
	</div>

	<?php } ?>
	<?php } else { ?>
	<p>Es liegen keine unvergebenen Termine in der n&auml;chsten Zeit vor.</p>
	<?php } ?>
</div>
