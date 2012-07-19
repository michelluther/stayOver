<?php $basePath = base_url(); ?>
<!-- <div class="btn-group" >  -->
<div id="toolBox">
	<button class="btn" onclick="openAddDate()">Neuer Termin</button>
	<button class="btn" onclick="giveFeedbackTest()">Hallo Sagen</button>
	<button class="btn">Markierte Zuordnen</button>
</div>
<!-- </div>  -->
<div id="datesOverview">
	<h2>N&auml;chste Termine</h2>
</div>

<div class="modal hide" id="addDateForm">
	<div class="modal-header">
		<button class="close" data-dismiss="modal" type="button"
			onclick="$.unblockUI();">&times;</button>
		<h2>Neuen Termin anlegen</h2>
	</div>
	<div class="modal-body">
		<?php include_once 'popins/add_date_form.php';?>
	</div>
</div>
