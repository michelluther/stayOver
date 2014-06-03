<?php $basePath = base_url(); ?>
<div id="datesOverview">
	<div class="row"><h3 class="span5">Die n&auml;chsten Termine Deiner Kinder</h3></div>
	<div class="row">
		<div class="btn-group span5">
		<a class="btn btn-small" onclick="openAddDate()" href="#"><i
			class="icon-plus"></i> Neu</a> <a class="btn btn-small disabled">|</a>
		<a class="btn btn-small" onclick="openChangeDate()"><i
			class="icon-pencil"></i> ändern</a> <a class="btn btn-small"
			onclick="openAssignDate()"><i class="icon-resize-small"></i> zuordnen</a>
		<a class="btn btn-small" onclick="openUnassignDate()"><i
			class="icon-resize-full"></i> freigeben</a> <a class="btn btn-small"
			onclick="openDeleteDate()"><i class="icon-trash"></i> l&ouml;schen</a>
		</div>
	</div>
	<div class="row">
		<div id="dateEditList" class="span12">
		<?php include_once 'include/dateTable.php';?>
		</div>
	</div>
</div>
<?php include_once 'popins/add_date_form.php';?>
