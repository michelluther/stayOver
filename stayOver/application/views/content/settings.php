<?php $basePath = base_url(); ?>
<!--  Userdaten -->
<div class="row">
	<div class="span12 functionalAreaHeader greenBg">
	<h2>
		<i class="icon-user"></i> Benutzerdaten
	</h2>
	</div>
</div>
<div class="functionalArea">
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
</div>
<!--  Kinderdaten -->
<div class="row">
	<div class="span12 functionalAreaHeader greenBg">
	<h2>
		<i class="icon-heart icon-white"></i> Kinder
	</h2>
	</div>
</div>
<div class="functionalArea">
<div id="assignedChildren">
<?php include_once 'include/assigned_children.php'?>
</div>
<div class="row">
	<span class="span4 offset1"><a class="btn btn-small"
		onClick="openAddChildPopup()"><i class="icon-plus"></i> Neues Kind</a> </span>
</div>
</div>