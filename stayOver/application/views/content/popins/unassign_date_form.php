<form id="assignKidDateForm" action="">
<?php $basePath = base_url(); ?>
	<table class="alignment">
		<tr>
			<td colspan="2"><p>Termine zum Freigeben</p>
				<ul>
					<?php foreach ($dates as $date) { ?>
					<li><?= $date->getTitle(); ?></li>
					<?php }?>
				</ul>
			</td>
		</tr>
		<tr>
			<td colspan="2"><input type="button" value="Speichern"
				onclick="submitFormAndRefresh('assignKidDateForm', '<?= $basePath ?>index.php/manageKidDates/unassignDates')"
				class="btn" /></td>
		</tr>
	</table>
</form>
