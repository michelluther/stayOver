<div class="row">
<div class="span6"><p><p>M&ouml;chtest Du diesen Termin wirklich l&ouml;schen?</p></div>
</div>
<?php $basePath = base_url(); 
	include 'view_date.php';
?>
<div class="buttonRow">
<a onclick="deleteDate(<?php echo $date->getID() ?>)"
				class="btn btn-small"><i class="icon-trash"></i> Ja, Termin l&ouml;schen</a>
<a class="btn btn-small" onclick="closePopup()"><i class="icon-remove"></i> Abbrechen</a>					
</div>
				