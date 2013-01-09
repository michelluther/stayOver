<?php
$iterator = 1;
foreach ($kids as $kid) { ?>
<form id="kidDataForm_<?php echo $kid->getID(); ?>" >
<div class="row">
	<div  class="span7 offset2">
	<h4>
	<?php echo $kid->getFirstName(); ?>
	</h4>
	</div>
</div>
<div class="row">
	<label class="span2 offset2" for="kid.firstName">Vorname</label>
	<div class="span3">
		<input name="kid.firstName" type="text"
		value="<?php echo $kid->getFirstName(); ?>" />
	</div>
</div>
<div class="row">
	<label class="span2 offset2" for="kid.lastName">Nachname</label>
	<div class="span3"><input
		name="kid.lastName" type="text"
		value="<?php echo $kid->getLastName(); ?>" />
	</div>	
</div>
<div class="row" id="helpers_<?php echo $kid->getID(); ?>">
	<label class="span2 offset2" for="kid.helpers">Helfer</label>
	<div class="span3">
	<?php
	$helpers = $kid->getHelpers();
	$iterator = 1;
	if(count($helpers) > 0)
	foreach ($helpers as $helper) {
		if($iterator > 1){
			echo ",&nbsp;";
		}
		echo $helper->getName();
		$iterator ++;
	} else {
		echo "keine Helfer zugewiesen";
	}
	?>
	</div>
	<div class="span2 offset2">
			<a class="btn btn-small" onClick="openChangeKidHelpers(<?php echo $kid->getID(); ?>);">
			<i class="icon-pencil"></i> Bearbeiten</a>
		</div>
</div>
<div class="row">
		<div class="span8 offset2">
		<a class="btn btn-small" onClick="saveChildData(<?php echo $kid->getID(); ?>)"><i class="icon-save"></i> Speichern</a>
		<a class="btn btn-small" onClick="confirmChildDeletion(<?php echo $kid->getID(); ?>)"><i class="icon-trash"></i> L&ouml;schen</a>
	</div>
</div>
</form>
<?php } ?>