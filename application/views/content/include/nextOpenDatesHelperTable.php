<?php if(count($openDatesHelper) != 0){  ?>
<table class="table table-bordered table-condensed table-striped" id="kidDatesTable">
	<thead>
		<tr>
			<th>Termin</th>
			<th>Kinder</th>
			<th>Beginn</th>
			<th>Ende</th>
			<th width="60px">Aktionen</th>
		</tr>
	</thead>
	<tbody>
	<?php
	
	foreach ($openDatesHelper as $date) { ?>
		<tr so_data.id="<?php echo $date->getID() ?>">
			<td>
				<?= $date->getTitle() ?>
			</td>
			<td><?php 
			$children = $date->getChildren(); 
			foreach ($children as $child) {
				echo $child->getFirstName();
			}?></td>
			<td><?= Mpm_Calendar::format_date_for_User($date->getBeginDate()) ?> , <?php 
	echo Mpm_calendar::format_time_for_User($date->getBeginDate())
	 ?>
			</td>
			<td><?= Mpm_Calendar::format_date_for_User($date->getEndDate()) ?>, <?php 
	echo Mpm_calendar::format_time_for_User($date->getEndDate())
	 ?></div>
			</td>
			<td>
				<div class="btn-group">
					<a class="btn btn-small" onclick="openViewDate(<?php echo $date->getID() ?>)"><i class="icon-eye-open"></i></a>
					<a class="btn btn-small" onclick="openAssignDateToSelf(<?php echo $date->getID() ?>)"><i class="icon-resize-small"></i></a> 
					<a class="btn btn-small" onclick="downLoadCalendarEntry(<?php echo $date->getID() ?>)"><i class="icon-calendar"></i></a>
	<!-- <a class="btn btn-small" onclick="openSendEmail()"><i class="icon-calendar"></i></a>  -->	
				</div>
			</td>
		</tr>
		<?php } ?>
	</tbody>
	
</table>
<?php } else { ?>
	<p>Es liegen keine unvergebenen Termine in der n&auml;chsten Zeit vor.</p>
<?php } ?>

