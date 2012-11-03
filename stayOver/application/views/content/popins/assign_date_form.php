<form id="assignKidDateForm" action="">
	<table class="alignment">
		<tr>
			<td colspan="2"><p>Termine zur Zuordnung</p>
				<ul>
					<?php foreach ($dates as $date) { ?>
					<li><?= $date->getTitle(); ?></li>
					<?php }?>
				</ul>
			</td>
		</tr>
		<tr>
			<td><p>Helfer:</p>
			<select>
			<?php foreach ($helpers as $helper) { ?>
				<option value="<?= $helper->getID() ?>"><?= $helper->getName() ?></option>
			<?php }?>
			
			</select>
			</td>
		</tr>
		<tr>
			<td colspan="2"><input type="button" value="Speichern"
				onclick="submitForm('assignKidDateForm', '<?= $basePath ?>index.php/manageKidDates/assignDates?>', 'formSubmitted')"
				class="btn" /></td>
		</tr>
	</table>
</form>
