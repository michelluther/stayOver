<?php
$baseURL = base_url();
?>
<div class="centeredTop">
	<div class="row">
		<div class="span1" id="login_banner">&nbsp;</div>
		<div class="span3 form_wrapper">
			<p>Willkommen bei Little's Helper! Du kannst Dir nun einen User
				anlegen.
				<form action="<?= $baseURL ?>index.php/stayOver/submit_login/"
					method="post" id="createUserForm">
					<label for="uname">Benutzername</label>
					<input type="text" name="user.uname" id="uname" placeholder="Benutzer" class="submitOnEnter" /> 
					<label for="pw">Passwort</label>
					<input type="password" id="pw" name="user.pw" placeholder="Passwort" class="submitOnEnter" />
					<label for="pw_repeat">Wiederholung Passwort</label>
					<input type="password" id="pw_repeat" name="user.pw_repeat" placeholder="Passwort" class="submitOnEnter" />
					<label for="firstname">Vorname</label>
					<input type="text" id="firstname" name="user.firstName" placeholder="Max" class="submitOnEnter" />
					<label for="lastname">Nachname</label>
					<input type="text" id="lastname" name="user.lastName" placeholder="Mustermann" class="submitOnEnter" />
					<label for="email">Emailadresse</label> <input type="text" id="email" name="user.email" placeholder="E-Mail" class="submitOnEnter" />
					<button class="btn" type="button" onClick="submitUserRegistration()">Registrieren</button>
				</form>
			</div>
			<div></div>
			<br style="clear: both" />
		</div>
	</div>
