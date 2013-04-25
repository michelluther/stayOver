<?php 
	if ($kid->getGender() == IF_SO_Person::genderMale){
		$genderClass = 'kidEntryBoy';
	} else {
		$genderClass = 'kidEntryGirl';
	}  ?>
	<div class="kidListEntry <?php echo $genderClass; ?>">
		<form id="kidDataForm_<?php echo $kid->getID(); ?>">
			<h4>
				<?php echo $kid->getFirstName(); ?>
			</h4>
			<div class="dateData">
				<label class="dateEntryAttribute" for="kid.firstName">Vorname</label>
				<input name="kid.firstName" type="text"
					value="<?php echo $kid->getFirstName(); ?>" /><br /> <label
					class="dateEntryAttribute" for="kid.lastName">Nachname</label> <input
					name="kid.lastName" type="text"
					value="<?php echo $kid->getLastName(); ?>" />
			</div>
			<div class="kidButtons">
				<div class="btn-group btn-group-vertical">
					<a class="btn btn-small"
						onClick="openChangeKidHelpers(<?php echo $kid->getID(); ?>);"> <i
						class="icon-ok"></i>
					</a> <a class="btn btn-small"
						onClick="confirmChildDeletion(<?php echo $kid->getID(); ?>)"><i
						class="icon-trash"></i> </a>
				</div>
			</div>
			<hr>
			<div class="dateData">
				<label class="dateEntryAttribute" for="kid.helpers">Helfer</label> <span
					class=""> <?php
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
				</span>
			</div>
			<div class="kidButtons">
				<a class="btn btn-small"
					onClick="openChangeKidHelpers(<?php echo $kid->getID(); ?>);"> <i
					class="icon-pencil"></i>
				</a>
			</div>
		</form>
	</div>