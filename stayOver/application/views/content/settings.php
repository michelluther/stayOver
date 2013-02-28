<?php $basePath = base_url(); ?>
<!--  Userdaten -->
<div class="row">
	<div class="span12 functionalArea userData">
		<h2>
			<i class="icon-user icon-white"></i> Benutzerdaten hihi
		</h2>


		<div class="functionalAreaContent">
			<form id="UserDataForm" action="">
				<div class="row">
					<label class="span2 offset1" for="user.name">Benutzername</label>
					<div class="span3">
						<input name="user.username" type="text"
							value="<?php echo $user->getName(); ?>" />
					</div>
				</div>
				<div class="row">
					<label class="span2 offset1" for="">Passwort</label>
					<div class="span3">
						<input name="user.password" type="password" />
					</div>
				</div>
				<div class="row">
					<label class="span2 offset1" for="user.firstname">Vorname</label>
					<div class="span3">
						<input name="user.firstname" type="text"
							value="<?php echo $user->getFirstName() ?>" />
					</div>
				</div>
				<div class="row">
					<label class="span2 offset1" for="user.lastname">Nachname</label>
					<div class="span3">
						<input name="user.lastname" type="text"
							value="<?php echo $user->getLastName() ?>" />
					</div>
				</div>
				<div class="row">
					<label class="span2 offset1" for="">E-Mail</label>
					<div class="span3">
						<input name="user.email" type="text"
							value="<?php echo $user->getEmail() ?>" />
					</div>
				</div>
				<div class="row">
					<div class="span2 offset1">
						<a class="btn btn-small" onClick="saveUserData();"><i
							class="icon-save"></i>Speichern</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<!--  Kinderdaten -->
<div class="row">
	<div class="span12 functionalArea kidsData">
		<h2>
			<i class="icon-heart icon-white"></i> Kinder
		</h2>
		<div class="functionalAreaContent">
			<div id="assignedChildren">
				<?php include_once 'include/assigned_children.php'?>
			</div>
			<div class="row">
				<span class="span4 offset1"><a class="btn btn-small"
					onClick="openAddChildPopup()"><i class="icon-plus"></i> Neues Kind</a>
				</span>
			</div>
		</div>
	</div>
</div>
