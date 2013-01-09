<table class="table table-bordered table-condensed" id="kidDatesTable">
	<thead>
		<tr>
			<th>Termin</th>
			<th>Kinder</th>
			<th>Beginn</th>
			<th>Ende</th>
			<th>Helfer</th>
			<th width="60px">Aktionen</th>
		</tr>
	</thead>
	<tbody>
	<?php
	foreach ($nextDatesParent as $date) { ?>
		<tr so_data.id="<?php echo $date->getID() ?>">
			<td>
			<?= $date->getTitle() ?>
			</td>
			<td><?php $children = $date->getChildren(); 
			foreach ($children as $child) {
				echo $child->getFirstName();
			}?></td>
			<td><?= Mpm_Calendar::format_date_for_User($date->getBeginDate()) ?>, <?php 
	echo Mpm_calendar::format_time_for_User($date->getBeginDate())
	 ?>
			</td>
			<td><?= Mpm_Calendar::format_date_for_User($date->getEndDate()) ?>, <?php 
	echo Mpm_calendar::format_time_for_User($date->getEndDate())
	 ?>
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
			<td>
				<div class="btn-group">
					<a class="btn btn-small" onclick="openChangeDate(<?php echo $date->getID() ?>)"><i class="icon-pencil"></i></a>
					<a class="btn btn-small" onclick="openAssignDate(<?php echo $date->getID() ?>)"><i class="icon-resize-small"></i></a> 
					<a class="btn btn-small" onclick="openUnassignDate(<?php echo $date->getID() ?>)"><i class="icon-resize-full"></i></a> 
					<a class="btn btn-small" onclick="openDeleteDate(<?php echo $date->getID() ?>)"><i class="icon-trash"></i></a>
		</div>
	<!-- <a class="btn btn-small" onclick="openSendEmail()"><i class="icon-calendar"></i></a>  -->	
				</div>
			</td>
		</tr>
		<?php } ?>
	</tbody>
</table>
