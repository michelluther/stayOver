<div class="row">
<?php $basePath = base_url(); ?>
	<div class="span infoArea">
		<p>Du kannst Dir den Kalendereintrag für den Termin entweder
			downloaden oder per E-Mail zusenden lassen.</p>
	</div>
	<div class="row">
		<div class="span2">
			<div class="btn-group span1">
				<a class="btn btn-small" href="<?php echo $basePath ?>index.php/stayOver/downloadIcalEntry/<?php echo $date->getID() ?>"><i class="icon-download-alt"></i> Download</a>
				<a class="btn btn-small" href="#" onClick="sendCalendarEntry(<?php echo $date->getID() ?>)"><i class="icon-envelope"></i> Per E-Mail zusenden</a>
			</div>
		</div>
	</div>