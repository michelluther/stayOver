<form id="addChildForm" action="">
	<div class="row">
		<div class="span infoArea">
			<p>Du kannst ein Kind anlegen, das dann selbstverst&auml;ndlich Deines ist. Du kannst ihm hinterher Helfer zuordnen.</p>
		</div>
	</div>
	<div class="row">
		<div class="span2"><label>Vorname</label></div><div class="span2"><input type="text" name="kid.firstName"></div>
	</div>
	<div class="row">
		<div class="span2"><label>Nachname</label></div><div class="span2"><input type="text" name="kid.lastName"></div>
	</div>
	<div class="buttonRow">
		<a class="btn btn-small" onClick="addChild()" href="#"><i class="icon-plus"></i> Kind hinzuf&uuml;gen</a>
		<a onclick="closePopup()" class="btn btn-small"><i class="icon-remove"></i> Abbrechen</a>
	</div>
</form>
