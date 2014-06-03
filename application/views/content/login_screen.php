<?php
$baseURL = base_url();
?>
<div class="container">
	<div id="login_wrapper" class="row">
		<div id="login_banner" class="span1">&nbsp;</div>
		<div class="form_wrapper span3">
			<form action="<?= $baseURL ?>index.php/stayOver/submit_login/"
				method="post" id="loginForm">
				<input type="text" name="login.uname" id="uname"
					placeholder="Benutzer" class="submitOnEnter" /><br />
				<div class="input-append">
					<input type="password" id="pw" name="login.pw"
						placeholder="Passwort" class="submitOnEnter" />
					<button class="btn" type="button" onClick="submitLogin()">Log in</button>
				</div>
			</form>
		</div>
	</div>
	<div class="row">
		<div class="span4 offset1">
			<a href="<?= $baseURL ?>index.php/forgot">Passwort vergessen?</a>
		</div>
	</div>
</div>
