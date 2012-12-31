<?php $basePath = base_url(); ?>
<div id="datesOverview" class="row">
	<h3 class="span12">Die n&auml;chsten Termine Deiner Kinder</h3>
	<div class="datesContainer">
		<div class="btn-group span7">
			<a class="btn btn-small" onclick="openAddDate()" href="#"><i class="icon-plus"></i> Neu</a> 
			<a class="btn btn-small disabled">|</a>
			<a class="btn btn-small" onclick="openChangeDate()"><i class="icon-pencil"></i> ändern</a> 
			<a class="btn btn-small" onclick="openAssignDate()"><i class="icon-resize-small"></i> zuordnen</a> 
			<a class="btn btn-small" onclick="openUnassignDate()"><i class="icon-resize-full"></i> freigeben</a>
			<a class="btn btn-small" onclick="openDeleteDate()"><i class="icon-trash"></i> l&ouml;schen</a>
		</div>
		<div id="dateEditList" class="span12">
			<?php include_once 'include/dateTable.php';?>
		</div>
	</div>
</div>
<div class="modal hide" id="dynamicPopup">
	<div class="modal-header">
		<button class="close" data-dismiss="modal" type="button"
			onclick="$.unblockUI();">&times;</button>
		<h2>Neuen Termin anlegen</h2>
	</div>
	<div class="modal-body" id="dynamicPopupContent">
	<?php include_once 'popins/add_date_form.php';?>
	</div>
</div>
