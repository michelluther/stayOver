<form id="assignKidDateForm" action="">

<?php $basePath = base_url(); ?>
<div class="row">
<div class="span6">
<p>Du kannst diesen Termin allen Helfern aller Deiner Kinder zuweisen:
</div>
</div>
<?php 
	include 'view_date.php';
?>
	<div class="row">
		<div class="span2">Verf&uuml;gbare Helfer</div>
		<div class="span4">
			<select name="date.helper" id="helperIDSelect">
			<?php foreach ($helpers as $helper) { ?>
				<option value="<?= $helper->getID() ?>">
				<?= $helper->getName() ?>
				</option>
			<?php }?>
			</select>
		</div>
	</div>
	<div class="buttonRow">
		<a onclick="assignDate(<?php echo $date->getID(); ?>);" class="btn btn-small" ><i class="icon-resize-small"></i> Termin zuweisen</a>
		<a class="btn btn-small" onclick="closePopup()"><i class="icon-remove"></i> Abbrechen</a>	
	</div>
</form>
