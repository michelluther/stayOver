<table class="table table-bordered table-condensed" id="kidDatesTable">
	<thead>
		<tr>
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
			<td>
			<?= $date->getTitle() ?>
			</td>
			<td><?php $children = $date->getChildren(); 
			foreach ($children as $child) {
				echo $child->getFirstName();
			}?></td>
			<td><?= Mpm_Calendar::format_date_for_User($date->getBeginDate()) ?>
			</td>
			<td><?= Mpm_Calendar::format_date_for_User($date->getEndDate()) ?>
			</td>
			<td><?php 
			$helpers = $date->getHelpers();
			if (count($helpers) == 0){
				echo '&nbsp;';
			} else {
				$iterator = 0;
				foreach ($helpers as $helper) {
					if ($iterator != 0){
						echo ',<br />';
					}
					echo $helper->getName();
					$iterator += 1;
				}
			}
			?></td>
		</tr>
		<?php } ?>
	</tbody>
</table>
