<div class="dateList">
	<?php if(count($openDatesHelper) != 0){  ?>

	<?php

	foreach ($openDatesHelper as $date) { ?>
	<div class="dateListEntry">
		<?php include 'dateDataCard.php';?>
		<div class="dateButtons hidden-phone">
			<div class="btn-group btn-group-vertical">
				<?php include 'buttons/buttonRowOpenDatesHelper.php'; ?>
			</div>
		</div>
		<div class="dateButtonsHorizontal visible-phone">
			<div class="btn-group">
				<?php include 'buttons/buttonRowOpenDatesHelper.php'; ?>
			</div>
		</div>		
	</div>
	

	<?php } ?>
	<?php } else { ?>
	<p>Es liegen keine unvergebenen Termine in der n&auml;chsten Zeit vor.</p>
	<?php } ?>
</div>
