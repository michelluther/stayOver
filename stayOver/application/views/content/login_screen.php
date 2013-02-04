<?php
$baseURL = base_url();

?>
<div id="login_wrapper">
	<div id="login_banner">&nbsp;</div>
	<div class="form_wrapper">
		<form action="<?= $baseURL ?>index.php/stayOver/submit_login/" method="post">
			<input type="text" name="uname" id="uname" class="input" placeholder="Benutzer"/><br/>
			<div class="input-append">
			<input type="password" id="pw" name="pw" class="input" placeholder="Passwort"/>
			<button type="submit" class="btn btn-small">Login</button>
			</div>
		</form>
	</div>
	<br style="clear: both" />
</div>
