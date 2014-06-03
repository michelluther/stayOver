<?php
$baseURL = base_url();
?>
<div id="login_wrapper">
	<div id="login_banner">&nbsp;</div>
	<div class="form_wrapper">
		<form action="<?= $baseURL ?>index.php/stayOver/submit_registration/"
			method="post" id="registrationForm">
			<label for="email">Deine Emailadresse</label>
			<input type="text" name="registration.email" id="email"
				placeholder="max.mustermann@email.de" class="submitOnEnter"/>
			<label for="registrationKey">Dein Registrierungscode</label>	
			<div class="input-append">
				<input type="text" id="registrationKey" name="registration.key"
					placeholder="Registrierungscode" class="submitOnEnter" /> 
				<button class="btn" type="button" onClick="submitRegistrationKey()">Registrieren</button>
			</div>
		</form>
	</div>
	<br style="clear: both" />
</div>
