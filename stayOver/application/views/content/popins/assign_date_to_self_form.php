<form id="assignKidDateForm" action="">
<?php $basePath = base_url(); ?>
	<table class="alignment">
		<tr>
			<td colspan="2"><p>Du kannst Dir den folgenden Termin zuweisen:</p>
				<ul>
					<?php foreach ($dates as $date) { ?>
					<li><?= $date->getTitle(); ?></li>
					<?php }?>
				</ul>
			</td>
		</tr>
		<tr>
			<td><p>Helfer:</p>
			<select name="date.helper">
			<?php foreach ($helpers as $helper) { ?>
				<option value="<?= $helper->getID() ?>"><?= $helper->getName() ?></option>
			<?php }?>
			
			</select>
			</td>
		</tr>
		<tr>
			<td colspan="2"><input type="button" value="Speichern"
				onclick="assignDateToSelf(<?php echo $date->getID(); ?>);"
				class="btn" /></td>
		</tr>
	</table>
</form>