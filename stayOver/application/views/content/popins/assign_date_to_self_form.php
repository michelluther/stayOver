
<?php $basePath = base_url(); ?>
<?php foreach ($dates as $date) { ?>
<p>
	M&ouml;chtest Du Dir den Termin "<?= $date->getTitle(); ?>" zuweisen?
</p>

<?php }?>
<div class="buttonRow">
	<a onclick="assignDateToSelf(<?php echo $date->getID(); ?>);"
		class="btn btn-small"><i class="icon-resize-small"></i> Ja, Termin &uuml;bernehmen</a> <a
		class="btn btn-small" onclick="closePopup()"><i class="icon-remove"></i> Abbrechen</a>
</div>
