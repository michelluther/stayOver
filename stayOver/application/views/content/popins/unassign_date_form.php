<div class="row">
<div class="span6"><p>M&ouml;chtest Du diesen Termin freigeben?</p></div>
</div>
<?php $basePath = base_url(); 
	include 'view_date.php';
?>
<div class="row">
<div class="span infoArea"><p>Wenn der Termin frei gegeben ist, muss jemand anderes sich um den Termin k&uuml;mmern.</p></div>
</div>
<div class="buttonRow">
		<a onclick="unassignDate(<?php echo $date->getID() ?>)" class="btn btn-small"><i class="icon-resize-full"></i> Termin freigeben</a>
		<a onclick="closePopup();" href="#"
				class="btn btn-small" ><i class="icon-remove"></i> Termin behalten</a>
</div>

