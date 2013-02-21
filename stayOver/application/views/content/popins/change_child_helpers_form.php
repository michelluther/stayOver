
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
</div>
<div class="row">
	<div class="span4 input-append" id="searchInput">
		<input type="text" class="span3" id="helperSearchString" />
		<button class="btn" type="button" onClick="searchHelper()">Helfer finden!</button>
	</div>
</div>
<div class="row helperResults">
	<div class="span6">
		<h4>Trefferliste</h4>
	</div>
	<div class="span6">
		<table class="table table-bordered table-condensed"
			id="helperSearchHits">
			<tr>
			<td>keine Treffer ... </td>
			</tr>
		</table>
	</div>
</div>
<div class="row">
	<hr />
</div>
<div class="row">
	<div class="span6">
		<p>Aktuell sind folgende Helfer zugeordnet:</p>
		<table class="table table-bordered table-condensed"
			id="assignedHelpers">
			<?php include_once("assigned_helpers.php"); ?>
		</table>
	</div>
</div>