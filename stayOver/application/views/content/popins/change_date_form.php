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
			<label>Beginndatum:</label>
		</div>
		<div class="span3">
			<input type="text" name="date.beginDate" class="datepicker"
				data-date-format="<?php echo Mpm_calendar::get_user_date_format_js(); ?>"
				value="<?php echo Mpm_calendar::format_date_for_User($date->getBeginDate()) ?>" />
		</div>
	</div>
	<div class="row">
		<div class="span2">
			<label>Endedatum:</label>
		</div>
		<div class="span3">
			<input type="text" name="date.endDate" class="datepicker"
				data-date-format="<?php echo Mpm_calendar::get_user_date_format_js(); ?>"
				value="<?php  echo Mpm_calendar::format_date_for_User($date->getEndDate()) ?>" />
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
