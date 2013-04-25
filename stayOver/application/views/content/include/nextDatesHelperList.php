<div class="dateList">
	<?php $basePath = base_url(); 
if(count($nextDatesHelper) != 0){  ?>
	<?php
	foreach ($nextDatesHelper as $date) { ?>
	<div class="dateListEntry">
		<?php include 'dateDataCard.php';?>
		<div class="dateButtons hidden-phone">
			<div class="btn-group btn-group-vertical">
				<?php include 'buttons/buttonRowNextDatesHelper.php'; ?>
			</div>
		</div>
		<div class="dateButtonsHorizontal visible-phone">
			<div class="btn-group">
				<?php include 'buttons/buttonRowNextDatesHelper.php'; ?>
			</div>
		</div>
	</div>
	<?php } ?>
	<?php } else { ?>
	<p>Es liegen keine unvergebenen Termine in der n&auml;chsten Zeit vor.</p>
	<?php } ?>
</div>
