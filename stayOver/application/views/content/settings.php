<?php $basePath = base_url(); ?>
<!--  Userdaten -->
<div class="row">
	<h3 class="span2 offset1">
		<i class="icon-user"></i> Benutzerdaten
	</h3>
	<hr class="span9" />
</div>
<form id="UserDataForm" action="">
	<div class="row">
		<label class="span2 offset2" for="user.name">Benutzername</label>
		<div class="span3"><input
			name="user.username" type="text"
			value="<?php echo $user->getName(); ?>" />
			</div>
	</div>
	<div class="row">
		<label class="span2 offset2" for="">Passwort</label>
		<div class="span3"><input
			name="user.password" type="password" /></div>
	</div>
	<div class="row">
		<label class="span2 offset2" for="user.firstname">Vorname</label>
		<div class="span3">
			<input name="user.firstname" type="text" value="<?php echo $user->getFirstName() ?>" />
		</div>
	</div>
	<div class="row">
		<label class="span2 offset2" for="user.lastname">Nachname</label>
		<div class="span3"><input
			name="user.lastname" type="text"
			value="<?php echo $user->getLastName() ?>" /></div>
	</div>
	<div class="row">
		<label class="span2 offset2" for="">E-Mail</label>
		<div class="span3"><input
			name="user.email" type="text" value="<?php echo $user->getEmail() ?>" /></div>
	</div>
	<div class="row">
		<div class="span2 offset2">
			<a class="btn btn-small" onClick="saveUserData();"><i
				class="icon-save"></i>Speichern</a>
		</div>
	</div>
</form>
<!--  Kinderdaten -->
<div class="row">
	<h3 class="span2 offset1">
		<i class="icon-heart"></i> Kinder
	</h3>
	<hr class="span9" />
</div>
<div id="assignedChildren">
<?php include_once 'include/assigned_children.php'?>
</div>
<div class="row">
	<span class="span4 offset1"><a class="btn btn-small"
		onClick="openAddChildPopup()"><i class="icon-plus"></i> Neues Kind</a> </span>
</div>
