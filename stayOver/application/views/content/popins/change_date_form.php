<form id="changeKidDateForm" action="">
	<?php $basePath = base_url(); ?>
	<div class="row">
		<div class="span2">
			<label>Termin:</label>
		</div>
		<div class="span3">
			<input type="text" name="date.title"
				value="<?php echo $date->getTitle() ?>" />
		</div>
	</div>
	<div class="row">
		<div class="span2">
			<label>Beginn</label>
		</div>
		<div class="span3">
			<input type="text" name="date.beginDate" class="datepicker dateDateInput"
				data-date-format="<?php echo Mpm_calendar::get_user_date_format_js(); ?>"
				value="<?php echo Mpm_calendar::format_date_for_User($date->getBeginDate()) ?>" />
			<input class="timepicker-default dateTimeInput" 
				data-default-time="<?php echo Mpm_calendar::format_time_for_User($date->getBeginDate()); ?>" type="text" style="width: 75px;" name="date.beginTime" 
				value="<?php echo Mpm_calendar::format_time_for_User($date->getBeginDate()); ?>">
				<i class="icon-time" style="margin: -2px 0 0 -22.5px; pointer-events: none; position: relative;"></i>
		</div>
	</div>
	<div class="row">
		<div class="span2">
			<label>Ende</label>
		</div>
		<div class="span3">
			<input type="text" name="date.endDate" class="datepicker dateDateInput"
				data-date-format="<?php echo Mpm_calendar::get_user_date_format_js(); ?>"
				value="<?php  echo Mpm_calendar::format_date_for_User($date->getEndDate()) ?>" />
				<input class="timepicker-default dateTimeInput" data-default-time="<?php echo Mpm_calendar::format_time_for_User($date->getEndDate()); ?>" type="text" style="width: 75px;" name="date.endTime" 
					value="<?php echo Mpm_calendar::format_time_for_User($date->getEndDate()); ?>">
				<i class="icon-time" style="margin: -2px 0 0 -22.5px; pointer-events: none; position: relative;"></i>
		</div>
	</div>
	<div class="row">
		<div class="span2">
			<label>Kind:</label>
		</div>
		<div class="span3">
			<select name="date.kid">
				<?php foreach ($parentChildren as $child) { ?>
				<option value="<?= $child->getID() ?>">
					<?= $child->getName() ?>
				</option>
				<?php }?>
			</select>
		</div>
	</div>
	<div class="row">
		<div class="span2">
			<label>Anmerkungen:</label>
		</div>
		<div class="span3">
			<textarea name="date.note" cols="40" rows="4">
				<?php 
				echo $date->getNote();
				?>
			</textarea>
		</div>
	</div>


	<div class="row">
		<div class="span2 offset2">
			<input type="button" value="Speichern"
				onclick="submitFormAndRefresh('changeKidDateForm', '<?= $basePath ?>index.php/manageKidDates/changeDate/<?php echo $date->getID() ?>', 'formSubmitted')"
				class="btn" />
		</div>
	</div>

	<div class="loaderText" style="display: none">
		<p>
			<img src="" /> ... der Termin wird gesendet.
		</p>
	</div>
</form>
