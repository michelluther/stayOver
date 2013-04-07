<div class="row">
	<?php $basePath = base_url(); ?>
	<div class="span infoArea">
		<p>Du kannst Dir den Kalendereintrag für den Termin entweder
			downloaden oder per E-Mail zusenden lassen.</p>
	</div>
</div>
<div class="buttonRow">
	<span class="btn-group"><a class="btn btn-small"
		href="<?php echo $basePath ?>index.php/stayOver/downloadIcalEntry/<?php echo $date->getID() ?>"><i
		class="icon-download-alt"></i> Download</a> <a class="btn btn-small"
		href="#" onClick="sendCalendarEntry(<?php echo $date->getID() ?>)"><i
		class="icon-envelope"></i> Per E-Mail zusenden</a></span>
		
		<a
		class="btn btn-small" onclick="$.unblockUI()"><i class="icon-remove"></i>
		Abbrechen</a>
</div>
