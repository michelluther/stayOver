<form id="addKidDateForm" action="">
<?php $basePath = base_url(); ?>
	<div class="row">
		<div class="span2">
			<label>Termin:</label>
		</div>
		<div class="span4">
			<input type="text" name="date.title"></input>
		</div>
	</div>
	<div class="row">
		<div class="span2">
			<label>Beginn</label>
		</div>
		<div class="span4">
			<input type="text" name="date.beginDate" class="datepicker dateDateInput" data-date-format="<?php echo Mpm_calendar::get_user_date_format_js(); ?>" style="width:95px"></input>
				<input class="timepicker-default dateTimeInput" type="text" style="width: 75px;" name="date.beginTime">
				<i class="icon-time" style="margin: -2px 0 0 -22.5px; pointer-events: none; position: relative;"></i>
	</div>
	</div>
	<div class="row">
		<div class="span2">
			<label>Ende</label>
		</div>
		<div class="span4">
			   <input type="text" name="date.endDate" class="datepicker" data-date-format="<?php echo Mpm_calendar::get_user_date_format_js(); ?>" style="width:95px"></input>
				<input class="timepicker-default" type="text" style="width: 75px;" name="date.endTime">
				<i class="icon-time" style="margin: -2px 0 0 -22.5px; pointer-events: none; position: relative;"></i>
		</div>
	</div>
	<div class="row">
		<div class="span2">
			<label>Kind</label>
		</div>
		<div class="span4">
			<select name="date.kid">
			<?php foreach ($children as $child) { ?>
				<option value="<?= $child->getID() ?>">
				<?= $child->getName() ?>
				</option>
					<?php }?>
			</select>
		</div>
	</div>
		<div class="row">
		<div class="span2">
			<label>Helfer</label>
		</div>
		<div class="span4">
			<select name="date.helperPending">
			<option value="0">Alle</option>
			<?php foreach ($helpers as $helper) { ?>
				<option value="<?= $helper->getID() ?>">
				<?= $helper->getName() ?>
				</option>
			<?php }?>
			</select>
		</div>
	</div>
	<div class="row">
		<div class="span2">
			<label>Anmerkungen</label>
		</div>
		<div class="span4">
			<textarea name="date.note" cols="40" rows="4"></textarea>
		</div>
	</div>
	<div class="buttonRow">
			<a type="button"
				onclick="submitFormAndRefresh('addKidDateForm', '<?= $basePath ?>index.php/manageKidDates/addDate')"
				class="btn btn-small" ><i class="icon-plus"></i> Termin anlegen</a>
			<a class="btn btn-small" onclick="closePopup()"><i class="icon-remove"></i> Abbrechen</a>	
	</div>
</form>
