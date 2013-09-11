<?php
$baseURL = base_url();

?>
<div id="login_wrapper">
	<div id="login_banner">&nbsp;</div>
	<div class="form_wrapper">
		<form id="resetPwRequestForm">
			<label for="email">Deine Emailadresse</label>
			<div class="input-append"><input type="text" name="pw_reset.email" id="email"
				placeholder="max.mustermann@email.de" class="submitOnEnter"/>
				<button class="btn" type="button" onClick="submitPwResetRequest()">Passwort Reset</button>
			</div>
		</form>
	</div>
	<br style="clear: both" />
</div>