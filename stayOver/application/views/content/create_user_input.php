<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Administration TTS Projektcontrolling</title>
</head>
<body>
<h1>Wie soll der Benutzer angelegt werden und was ist sein Name?</h1>
<form action="create_user" method="post">
	<label for="uname">Benutzername:</label><input type="text" name="uname" id="uname" /><br />
	<label for="pw">Passwort:</label><input type="text" name="pw" id="pw" /><br />
	<input type="submit" value="anlegen">
</form>
</body>