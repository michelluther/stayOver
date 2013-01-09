	<div class="row">
		<div class="span6">
			<p>Du kannst einen neuen Helfer f&uuml;r
			<?php echo $kid->getFirstName(); ?>
			ausw&auml;hlen:</p>
		</div>
	</div>
	<div class="row">
		<div class="span4 input-append" id="searchInput">
			<input type="text" class="span3" id="helperSearchString"/><button class="btn btn-small" type="button" onClick="searchHelper()">Go!</button>
		</div>
	</div>
	<div class="row helperResults">
		<div class="span6"><h4>Trefferliste</h4></div>
		<div class="span6">
			<table class="table table-bordered table-condensed" id="helperSearchHits">
			</table>
		</div>
	</div>
	<div class="row">
	<hr />
	</div>
	<div class="row">
		<div class="span6">
		<p>Aktuell sind folgende Helfer zugeordnet:</p>
		<table class="table table-bordered table-condensed" id="assignedHelpers">
		<?php include_once("assigned_helpers.php"); ?>
		</table>
		</div>
	</div>
