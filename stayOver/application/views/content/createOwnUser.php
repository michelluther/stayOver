<?php
$baseURL = base_url();

?>
<div id="login_wrapper">
	<div id="login_banner">&nbsp;</div>
	<div class="form_wrapper">
		<form action="<?= $baseURL ?>index.php/stayOver/submit_login/"
			method="post" id="createUserForm">
			<input type="text" name="user.uname" id="uname"
				placeholder="Benutzer" class="submitOnEnter" /><br /> <input
				type="password" id="pw" name="user.pw" placeholder="Passwort"
				class="submitOnEnter" /> 
			<input type="password" id="pw_repeat"
				name="user.pw_repeat" placeholder="Passwort" class="submitOnEnter" /><br />
			<input type="text" id="firstname" name="user.firstName" placeholder="Max"
				class="submitOnEnter" /><br /> 
			<input type="text" id="lastname"
				name="user.lastName" placeholder="Mustermann" class="submitOnEnter" /><br />
			<input type="text" id="email" name="user.email" placeholder="E-Mail"
				class="submitOnEnter" /><br />
			<button class="btn" type="button"
				onClick="submitUserRegistration()">Registrieren</button>
		</form>
	</div>
	<div></div>
	<br style="clear: both" />
</div>
