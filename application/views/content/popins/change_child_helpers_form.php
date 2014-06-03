<!-- 
<div class="row">
	<div class="span infoArea">
		<p>
			Du kannst einen neuen Helfer f&uuml;r
			<?php echo $kid->getFirstName(); ?>
			ausw&auml;hlen.
		</p>
		<p>
			Die Helfer erhalten stets Nachricht &uuml;ber
			<?php echo $kid->getFirstName(); ?>s neue Termine und k&ouml;nnen diese &uuml;bernehmen, solange sie
			noch frei sind.
		</p>
		<p>Unten erh&auml;lst Du einen &Uuml;berblick &uuml;ber die aktuell zugewiesenen Helfer.</p> 
	</div>
</div>  -->
<div class="row">
	<div class="span5">
		<p>Aktuell sind folgende Helfer zugeordnet:</p>
		<table class="table table-bordered table-condensed"
			id="assignedHelpers">
			<?php include_once("assigned_helpers.php"); ?>
		</table>
	</div>
</div>
<div class="buttonRow">
	Weitere Helfer finden
	<div class="input-append" id="searchInput">
		<input type="text" class="span3" id="helperSearchString" />
		<button class="btn" type="button" onClick="searchHelper()">
			<i class="icon-search"></i>
		</button>
	</div>
</div>
<div class="row helperResults">
	<div class="span5">
		<table class="table table-bordered table-condensed"
			id="helperSearchHits">
		</table>
	</div>
</div>
<div class="buttonRow">
	<p>
		Weitere Helfer einladen:<br />
	<div class="input-append" id="searchInput">
		<form id="inviteHelperForm">
			<label>E-Mailadresse des Helfers</label><input type="text"
				class="span3" name="inviteeEmail" />
			<button class="btn" type="button" onClick="inviteHelper()">Absenden</button>
		</form>
	</div>
</div>
