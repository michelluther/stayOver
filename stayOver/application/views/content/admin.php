<div class="row">
	<div class="functionalArea span12 userData">
		<h2>
			<i class="icon-user icon-white"></i> User Anlegen
		</h2>
		<div class="functionalAreaContent">
			<form id="addUserForm">
				<div class="row">
					<label class="span2 offset1" for="user.uname">Benutzername</label>
					<div class="span3">
						<input name="user.uname" type="text"
							placeholder="Benutzername" />
					</div>
				</div>
				<div class="row">
					<label class="span2 offset1" for="user.password">Passwort</label>
					<div class="span3">
						<input name="user.password" type="text"
							placeholder="Passwort" />
					</div>
				</div>
				<div class="row">
					<label class="span2 offset1" for="user.email">E-Mail</label>
					<div class="span3">
						<input name="user.email" type="text"
							placeholder="E-Mail" />
					</div>
				</div>
				<div class="row">
					<label class="span2 offset1" for="user.firstName">Vorname</label>
					<div class="span3">
						<input name="user.firstName" type="text"
							placeholder="Vorname" />
					</div>
				</div>
				<div class="row">
					<label class="span2 offset1" for="user.lastName">Nachname</label>
					<div class="span3">
						<input name="user.lastName" type="text"
							placeholder="Nachname" />
					</div>
				</div>
				<div class="row">
					<div class="span2 offset1">
						<a class="btn btn-small" onClick="addUser();"><i
							class="icon-save"></i>User anlegen</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<ul>
	<li>User anlegen</li>
	<li>User l&ouml;schen</li>
	<li>Mail an User</li>
	<li>Passwort zur&uuml;cksetzen</li>
	<li>Rollen zuweisen</li>
</ul>
