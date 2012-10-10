<form id="addKidForm" action="">
	<table class="alignment">
		<tr>
			<td><label>Termin:</label>
			</td>
			<td><input type="text" name="date.title"></input>
			</td>
		</tr>
		<tr>
			<td><label>Beginndatum:</label>
			</td>
			<td><input type="text" name="date.beginDate" class="datepicker"></input><br />
				<div class="formBox">
					<input type="checkbox" id="date.singleDay" name="date.singleDay"></input><label
						for="date.singleDay">nur ein Tag</label>
				</div></td>
		</tr>
		<tr>
			<td><label>Endedatum:</label>
			</td>
			<td><input type="text" name="date.endDate" class="datepicker"></input>
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
			<td><textarea name="date.note" cols="40" rows="4">...</textarea>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="button" value="Termin anlegen"
				onclick="submitForm('addKidForm', '<?= $basePath ?>index.php/manageKidDates/addDate', 'formSubmitted')"
				class="btn" />
				<div class="loaderText" style="display: none">
					<p>
						<img src="" /> ... der Termin wird gesendet.
					</p>
				</div></td>
		</tr>
	</table>
</form>
