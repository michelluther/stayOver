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
			<input type="text" name="date.beginDate" class="datepicker" data-date-format="<?php echo Mpm_calendar::get_user_date_format_js(); ?>" style="width:95px"></input>
				<input class="timepicker-default" type="text" style="width: 75px;" name="date.beginTime">
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
			<label>Anmerkungen</label>
		</div>
		<div class="span4">
			<textarea name="date.note" cols="40" rows="4"></textarea>
			</td>
		</div>
	</div>
	<div class="row">
		<div class="span2 offset2">
			<input type="button" value="Termin anlegen"
				onclick="submitFormAndRefresh('addKidDateForm', '<?= $basePath ?>index.php/manageKidDates/addDate')"
				class="btn" />
		</div>
	</div>
</form>
