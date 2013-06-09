<?php $basePath = base_url(); ?>
<!--  Userdaten -->
<div class="row">
	<div class="span6 functionalArea userData">
		<h2>Benutzerdaten</h2>
		<div class="functionalAreaContent">
			<form id="UserDataForm" action="">
				<div class="row">
					<label class="span2 " for="user.name">Benutzername</label>
					<div class="span3">
						<input name="user.username" type="text"
							value="<?php echo $user->getID(); ?>" disabled />
					</div>
					<label class="span2" for="user.firstname">Vorname</label>
					<div class="span3">
						<input name="user.firstname" type="text"
							value="<?php echo $user->getFirstName() ?>" />
					</div>
					<label class="span2" for="user.lastname">Nachname</label>
					<div class="span3">
						<input name="user.lastname" type="text"
							value="<?php echo $user->getLastName() ?>" />
					</div>
					<label class="span2" for="">E-Mail</label>
					<div class="span3">
						<input name="user.email" type="text"
							value="<?php echo $user->getEmail() ?>" />
					</div>
					<div class="span2 offset2">
						<a class="btn btn-small" onClick="saveUserData();"><i
							class="icon-ok"></i> Speichern</a>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="span6 functionalArea userData">
		<h2>Passwort</h2>
		<div class="functionalAreaContent">
			<form id="ChangePasswordForm" action="">
				<div class="row">
					<label class="span2" for="">altes Passwort</label>
					<div class="span3">
						<input name="password.password" type="password" />
					</div>
					<label class="span2" for="">neues Passwort</label>
					<div class="span3">
						<input name="password.newPassword" type="password" />
					</div>
					<label class="span2" for="">neues Passwort bestätigen</label>
					<div class="span3">
						<input name="password.newPasswordConfirm" type="password" />
					</div>
					<div class="span2 offset2">
						<a class="btn btn-small" onClick="changePassword();"><i
							class="icon-ok"></i> Passwort &auml;ndern</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<!--  Kinderdaten -->
<?php if(isset($display['parentKids'])){ ?>
<div class="row">
	<div class="span12 functionalArea kidsData">
		<h2>Kinder</h2>
		<?php include_once 'include/assigned_children.php'?>
	</div>
</div>
<?php } ?>