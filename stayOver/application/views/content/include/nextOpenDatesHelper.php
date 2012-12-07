<?php if(count($helperOpenDates) != 0){  ?>
<table class="table table-bordered table-condensed" id="kidDatesTable">
	<thead>
		<tr>
			<th>Termin</th>
			<th>Kinder</th>
			<th>Beginndatum</th>
			<th>Endedatum</th>
		</tr>
	</thead>
	<tbody>
	<?php
	
	foreach ($helperOpenDates as $date) { ?>
		<tr class="selectableTr" so_data.id="<?php echo $date->getID() ?>">
			<td><p>
			<?= $date->getTitle() ?>
				</p>
			</td>
			<td><?php $children = $date->getChildren(); 
			foreach ($children as $child) {
				echo $child->getFirstName();
			}?></td>
			<td><?= Mpm_Calendar::format_date_for_User($date->getBeginDate()) ?>
			</td>
			<td><?= Mpm_Calendar::format_date_for_User($date->getEndDate()) ?>
			</td>
		</tr>
		<?php } ?>
	</tbody>
	
</table>
<?php } else { ?>
	<p>Es liegen keine unvergebenen Termine in der n&auml;chsten Zeit vor.</p>
<?php } ?>

