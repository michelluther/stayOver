<table class="table table-bordered table-condensed">
	<thead>
		<tr>
			<th width="30px"><i class="icon-check"></i>
			</th>
			<th>Termin</th>
			<th>Kinder</th>
			<th>Beginndatum</th>
			<th>Endedatum</th>
			<th>Helfer</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		foreach ($parentDates as $date) { ?>
		<tr class="selectableTr" so_data.id="<?php echo $date->getID() ?>">
			<td><input type="checkBox" />
			</td>
			<td><p><?= $date->getTitle() ?></p></td>
			<td><?php $children = $date->getChildren(); 
			foreach ($children as $child) {
				echo $child->getFirstName();
			}?>
			</td>
			<td><?= Mpm_Calendar::format_date_for_User($date->getBeginDate()) ?></td>
			<td><?= Mpm_Calendar::format_date_for_User($date->getEndDate()) ?></td>
			<td>Dagmar &amp; Michael</td>
		</tr>
		<?php } ?>
	</tbody>
</table>
