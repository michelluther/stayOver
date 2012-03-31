<?php
$baseURL = base_url();

?>
<div id="login_wrapper">
	<div id="login_banner">&nbsp;</div>
	<div class="form_wrapper">
		<h1>Willkommen</h1>
		<form action="<?= $baseURL ?>index.php/stayOver/submit_login/" method="post">
			<label>Benutzername</label>
			<input type="text" name="uname" id="uname" /><br/>
			<label>Passwort</label>
			<input type="password" id="pw" name="pw" />
			<input type="submit" value="Einloggen" />
		</form>
	</div>
	<br style="clear: both" />
</div>
