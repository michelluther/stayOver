<?php $basePath = base_url(); ?>

<div class="row">
<!--  Userdaten -->
	<div class="row">
	
	<h3 class="span12 offset1">
		<i class="icon-user"></i> Benutzerdaten
	</h3>
	</div>
	<form id="UserDataForm" action="">
	<div class="row">
		<label class="span2 offset1" for="user.name">Benutzername</label><input
			name="user.username" type="text" value="<?php echo $user->getName(); ?>"/>
	</div>
	<div class="row">
		<label class="span2 offset1" for="">Passwort</label><input
			name="user.password"  type="password" />
	</div>
	<div class="row">
		<label class="span2 offset1" for="user.firstname">Vorname</label><input
			name="user.firstname" type="text" value="<?php echo $user->getFirstName() ?>"/>
	</div>
	<div class="row">
		<label class="span2 offset1" for="user.lastname">Nachname</label><input
			name="user.lastname" type="text" value="<?php echo $user->getLastName() ?>"/>
	</div>
	<div class="row">
		<label class="span2 offset1" for="">E-Mail</label><input
			name="user.email" type="text" value="<?php echo $user->getEmail() ?>"/>
	</div>
	<div class="row">
		<div class="span2 offset1">
			<a class="btn btn-small" onClick="saveUserData();"><i class="icon-save"></i>Speichern</a>
		</div>
	</div>
	</form>
<!--  Kinderdaten -->	
	<div class="row">
	<h3 class="span3 offset1">
		<i class="icon-heart"></i> Kinder
	</h3><span class="span4 offset1"><a class="btn btn-small" onClick="openAddChild()"><i
				class="icon-plus"></i> Neues Kind</a> </span>
	</div>
	<?php 
	$iterater = 1;
	foreach ($kids as $kid) { ?>
		<div class="row">
		<h4 class="span2 offset1"><?php echo $kid->getFirstName(); ?></h4>
		<div class="span2 kidButtons offset2">
			<a class="btn btn-small"><i class="icon-trash"></i> L&ouml;schen</a>
		</div>
	</div>
	<div class="row">
		<label class="span2 offset1" for="kid.firstName">Vorname</label><input
			name="kid.firstName" type="text" value="<?php echo $kid->getFirstName(); ?>"/>
	</div>
	<div class="row">
		<label class="span2 offset1" for="kid.lastName">Nachname</label><input
			name="kid.lastName" type="text" value="<?php echo $kid->getLastName(); ?>"/>
	</div>
	<!-- 
	<div class="row">
		<label class="span2 offset1" for="kid.name">Geburtsdatum</label><input
			name="kid.dateOfBirth" type="text" value="19.6.2011"/>
	</div> -->
	<div class="row">
	<?php $helpers = $kid->getHelpers();?>
		<label class="span2 offset1" for="kid.helpers">Helfer</label>
	</div>
		<?php foreach ($helpers as $helper) {?>
		<div class="row">
			<div class="span2 offset3"><?php echo $helper->getName(); ?></div><div class="span2"><a class="btn btn-small" onClick="removeHelper(<?php echo $kid->getID() ?>, <?php echo $helper->getID()?>)"><i class="icon-minus-sign"></i>&nbsp;Entfernen</a></div><br />
		</div>
		<?php }?>
	
	<?php } ?>
	<div class="row settingsButtons">
		
	</div>
</div>
<div class="modal hide" id="dynamicPopup">
	<div class="modal-header">
		<button class="close" data-dismiss="modal" type="button"
			onclick="$.unblockUI();">&times;</button>
		<h2>Neuen Termin anlegen</h2>
	</div>
	<div class="modal-body" id="dynamicPopupContent">
	<?php include_once 'popins/add_helper_form.php';?>
	<?php include_once 'popins/add_child_form.php';?>
	</div>
</div>
