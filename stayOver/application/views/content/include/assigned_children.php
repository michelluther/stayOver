<?php
$iterator = 1;
foreach ($kids as $kid) { ?>
<form id="kidDataForm_<?php echo $kid->getID(); ?>">
	<?php if ($kid->getGender() == IF_SO_Person::genderMale){
		$genderClass = 'kidEntryBoy';
	} else {
	$genderClass = 'kidEntryGirl';
}  ?>
	<div class="kidListEntry offset1 <?php echo $genderClass; ?>">
		<div class="kidData">
			<h4>
				<?php echo $kid->getFirstName(); ?>
			</h4>
			<label class="dateEntryAttribute" for="kid.firstName">Vorname</label>
			<input name="kid.firstName" type="text"
				value="<?php echo $kid->getFirstName(); ?>" /><br /> <label
				class="dateEntryAttribute" for="kid.lastName">Nachname</label> <input
				name="kid.lastName" type="text"
				value="<?php echo $kid->getLastName(); ?>" /><br /> <label
				class="dateEntryAttribute" for="kid.helpers">Helfer</label> <span
				class="span3"> <?php
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
			</span> <a class="btn btn-small"
				onClick="openChangeKidHelpers(<?php echo $kid->getID(); ?>);"> <i
				class="icon-pencil"></i> Bearbeiten
			</a> <a class="btn btn-small"
				onClick="saveChildData(<?php echo $kid->getID(); ?>)"><i
				class="icon-save"></i> Speichern</a> <a class="btn btn-small"
				onClick="confirmChildDeletion(<?php echo $kid->getID(); ?>)"><i
				class="icon-trash"></i> L&ouml;schen</a>
		</div>
	</div>
</form>
<?php } ?>