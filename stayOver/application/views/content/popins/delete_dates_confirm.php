<div class="row">
<div class="span6"><p><p>M&ouml;chtest Du diesen Termin wirklich l&ouml;schen?</p></div>
</div>
<?php $basePath = base_url(); 
	include 'view_date.php';
?>
<div class="row">
	<div class="span6">

<p><input type="button" value="OK"
				onclick="deleteDate(<?php echo $date->getID() ?>)"
				class="btn" /></p>
				