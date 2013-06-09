<div class="kidListEntry functionalAreaContent">
	<?php if(is_a($kid, 'SO_Child')){?>
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
		<div class="kidButtons hidden-phone">
			<div class="btn-group btn-group-vertical">
				<?php include 'buttons/buttonRowEditChildData.php'?>
			</div>
		</div>
		<div class="dateButtonsHorizontal visible-phone">
			<div class="btn-group">
				<?php include 'buttons/buttonRowEditChildData.php'?>
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
		<div class="kidButtons hidden-phone">
			<?php include 'buttons/buttonRowEditChildHelpers.php'?>
		</div>
		<div class="dateButtonsHorizontal visible-phone">
			<?php include 'buttons/buttonRowEditChildHelpers.php'?>
		</div>
	</form>
	<?php 
	} else { 
		$var = 1;	?>
	<div class="newKidButton">
		<a class="btn btn-small" onClick="openAddChildPopup()"><i
			class="icon-plus"></i> Neues Kind</a>
	</div>
	<?php } ?>
</div>
