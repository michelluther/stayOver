<form id="changeKidDateForm" action="">
<?php $basePath = base_url(); ?>
	<table class="alignment">
		<tr>
			<td><label>Termin:</label>
			</td>
			<td><input type="text" name="date.title" value="<?php echo $date->getTitle() ?>"></input>
			</td>
		</tr>
		<tr>
			<td><label>Beginndatum:</label>
			</td>
			<td><input type="text" name="date.beginDate" class="datepicker" value="<?php echo Mpm_calendar::format_date_for_User($date->getBeginDate()) ?>">
					</input>
			</td>
		</tr>
		<tr>
			<td><label>Endedatum:</label>
			</td>
			<td><input type="text" name="date.endDate" class="datepicker" value="<?php  echo Mpm_calendar::format_date_for_User($date->getEndDate()) ?>"></input>
			</td>
		</tr>
		<tr>
			<td><label>Kind:</label>
			</td>
			<td><select name="date.kid">
					<?php foreach ($parentChildren as $child) { ?>
					<option value="<?= $child->getID() ?>"><?= $child->getName() ?></option>
					<?php }?>
			</select></td>
		</tr>
		<tr>
			<td><label>Anmerkungen:</label>
			</td>
			<td><textarea name="date.note" cols="40" rows="4"><?php 
				echo $date->getNote(); 
				?></textarea>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="button" value="Speichern"
				onclick="submitForm('changeKidDateForm', '<?= $basePath ?>index.php/manageKidDates/changeDate/<?php echo $date->getID() ?>', 'formSubmitted')"
				class="btn" />
				<div class="loaderText" style="display: none">
					<p>
						<img src="" /> ... der Termin wird gesendet.
					</p>
				</div></td>
		</tr>
	</table>
</form>
