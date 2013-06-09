<?php
$iterator = 1;
$oddKids = array();
$evenKids = array();
$kidCount = 1;
foreach ($kids as $kid) {
	// Aufteilen in gerade/ungerade
	if ($kidCount % 2 == 0){
		array_push($evenKids, $kid);
	} else {
		array_push($oddKids, $kid);
	}
	$kidCount ++;
}
$kidToAdd = 'neues Kind';
if ($kidCount % 2 == 0){
	array_push($evenKids, $kidToAdd);
} else {
	array_push($oddKids, $kidToAdd);
}
?>
<div class="row">
	<div class="span6 kidColumn" id="oddKidColumn">
		<?php 
		foreach ($oddKids as $kid) {
	include 'child.php';
	 } ?>
	</div>
	<div class="span6 kidColumn" id="evenKidColumn">
		<?php 
		foreach ($evenKids as $kid) {
	include 'child.php';
	 } ?>
	</div>
</div>
