<table class="table table-bordered table-condensed table-striped"
	id="kidDatesTable">
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
			<td><?= $date->getTitle() ?>
			</td>
			<td><?php $children = $date->getChildren(); 
			foreach ($children as $child) {
				echo $child->getFirstName();
			}?></td>
			<td><?= Mpm_Calendar::format_date_for_User($date->getBeginDate()) ?>,
				<?php 
				echo Mpm_calendar::format_time_for_User($date->getBeginDate())
				?>
			</td>
			<td><?= Mpm_Calendar::format_date_for_User($date->getEndDate()) ?>, <?php 
			echo Mpm_calendar::format_time_for_User($date->getEndDate())
			?>
			</td>
			<td><?php 
			$helpers = $date->getHelpers();
			$helpersPending = $date->getHelpersPending();
			if (count($helpers) == 0 && count($helpersPending) == 0){
				echo '&nbsp;';
			} elseif(count($helpers) != 0) {
				?><span class="text-success"><?php 
				$iterator = 0;
				foreach ($helpers as $helper) {
					if ($iterator != 0){
						echo ',<br />';
					}
					echo $helper->getName();
					$iterator += 1;
				}
				?></span><?php 
			} else {
				?><span class="muted"><?php
				$iterator = 0;
				foreach ($helpersPending as $helper) {
					if ($iterator != 0){
						echo ',<br />';
					}
					echo $helper->getName();
					$iterator += 1;
				}
				?></span><?php
			}
			?></td>
			<td>
				<div class="btn-group">
					<?php include 'buttons/buttonRowNextDatesParent.php'?>
				</div> <!-- <a class="btn btn-small" onclick="openSendEmail()"><i class="icon-calendar"></i></a>  -->
			</td>
		</tr>
		<?php } ?>
	</tbody>
</table>
