<?php
$baseURL = base_url();

?>
<div id="login_wrapper">
	<div id="login_banner">&nbsp;</div>
	<div class="form_wrapper">
		<form action="<?= $baseURL ?>index.php/stayOver/submit_login/"
			method="post" id="loginForm">
			<input type="text" name="login.uname" id="uname"
				placeholder="Benutzer" class="submitOnEnter"/><br />
			<div class="input-append">
				<input type="password" id="pw" name="login.pw"
					placeholder="Passwort" class="submitOnEnter" /> 
					<button class="btn" type="button" onClick="submitLogin()">Log in</button>
			</div>
		</form>
	</div>
	<br style="clear: both" />
</div>
