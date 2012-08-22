<?php $basePath = base_url(); ?>
<div class="row">
	<h3 class="span12">
		<i class="icon-user"></i> Benutzerdaten
	</h3>
	<div class="row">
		<label class="span2 offset1" for="user.name">Benutzername</label><input
			name="user.username" type="text" />
	</div>
	<div class="row">
		<label class="span2 offset1" for="">Passwort</label><input
			name="user.password"  type="password" />
	</div>
	<div class="row">
		<label class="span2 offset1" for="user.firstname">Vorname</label><input
			name="user.firstname" type="text" />
	</div>
	<div class="row">
		<label class="span2 offset1" for="user.lastname">Nachname</label><input
			name="user.lastname" type="text" />
	</div>
	<div class="row">
		<label class="span2 offset1" for="">E-Mail</label><input
			name="user.email" type="text" />
	</div>
	<h3 class="span12">
		<i class="icon-heart"></i> Kinder
	</h3>
	<div class="row">
		<h4 class="span2 offset1">Leo</h4>
		<div class="span2 kidButtons">
			<a class="btn btn-small"><i class="icon-trash"></i> Löschen</a>
		</div>
	</div>
	<div class="row">
		<label class="span2 offset1" for="kid.name">Vorname</label><input
			name="kid.name" type="text" />
	</div>
	<div class="row">
		<label class="span2 offset1" for="kid.name">Geburtsdatum</label><input
			name="kid.dateOfBirth" type="text" />
	</div>
	<div class="row">
		<label class="span2 offset1" for="kid.helpers">Helfer</label><input
			name="kid.helpers" type="text" />
	</div>
	<div class="row settingsButtons">
		<span class="span4 offset1"><a class="btn btn-small"><i
				class="icon-plus"></i> Neues Kind</a> </span>
	</div>
</div>
