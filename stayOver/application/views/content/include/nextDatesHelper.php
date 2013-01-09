<table class="table table-bordered table-condensed" id="kidDatesTable">
	<thead>
		<tr>
			<th>Termin</th>
			<th>Kinder</th>
			<th>Beginndatum</th>
			<th>Endedatum</th>
			<th>Kommentar</th>
		</tr>
	</thead>
	<tbody>
	<?php
	foreach ($nextDates as $date) { ?>
		<tr class="" so_data.id="<?php echo $date->getID() ?>">
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
			<td><?php echo $date->getNote(); ?></td>
		</tr>
		<?php } ?>
	</tbody>
</table>