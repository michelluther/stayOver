<div class="dateList">
	<?php $basePath = base_url(); 
if(count($nextDatesParent) != 0){ 
	$parentDate = true;
	foreach ($nextDatesParent as $date) { ?>
	<div class="dateListEntry">
		<?php include 'dateDataCard.php';?>
		<div class="dateButtons hidden-phone">
			<div class="btn-group btn-group-vertical">
				<?php include 'buttons/buttonRowNextDatesParent.php'; ?>
			</div>
		</div>
		<div class="dateButtonsHorizontal visible-phone">
			<div class="btn-group">
				<?php include 'buttons/buttonRowNextDatesParent.php'; ?>
			</div>
		</div>
	</div>
	<?php } ?>
	<?php } else { ?>
	<p>Es liegen keine unvergebenen Termine in der n&auml;chsten Zeit vor.</p>
	<?php } ?>
</div>