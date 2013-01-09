<div class="row">
<div class="span6"><p>M&ouml;chtest Du diesen Termin freigeben?</p></div>
</div>
<?php $basePath = base_url(); 
	include 'view_date.php';
?>
<div class="row">
<div class="span6"><p>Wenn der Termin frei gegeben ist, muss jemand anderes sich um den Termin k&uuml;mmern.</p></div>
</div>
<div class="row">
	<div class="span6">
		<a onclick="unassignDate(<?php echo $date->getID() ?>)" class="btn btn-warning btn-small">Termin freigeben</a>
		<a onclick="$.unblockUI();" href="#"
				class="btn btn-small" >Termin behalten</a>
</div>
</div>

