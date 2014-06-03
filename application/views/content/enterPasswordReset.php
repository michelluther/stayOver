<?php
$baseURL = base_url();
?>
<div id="login_wrapper">
	<div id="login_banner">&nbsp;</div>
	<div class="form_wrapper">
		<form id="resetPwForm">
			<label for="email">Deine Emailadresse</label> <input type="text"
				name="pw_reset.email" id="email"
				placeholder="max.mustermann@email.de" class="submitOnEnter" /> <label
				for="token">Token</label> <input type="text" name="pw_reset.token"
				id="token" placeholder="..." class="submitOnEnter" />
			<div class="input-append">
				<input type="password" name="pw_reset.pw" id="password"
					placeholder="password" class="submitOnEnter" />
				<button class="btn" type="button" onClick="submitForm('resetPwForm', base_url + 'index.php/forgot/resetPassword')">Passwort
					Reset</button>
			</div>
		</form>
	</div>
	<br style="clear: both" />
</div>
