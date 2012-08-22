<?php $basePath = base_url(); ?>
<div id="datesOverview" class="row">
	<h3 class="span12">Suche</h3>
	<div id="searchBar" class="span12">
		<input type="text"> <a class="btn btn-small"><i class="icon-filter"></i>
			Filtern</a>
	</div>
	<h3 class="span12">Aktionen</h3>
	<div class="datesContainer">
		<div class="btn-group span7">
			<a class="btn btn-small" onclick="openAddDate()" href="#"><i class="icon-plus"></i> Neu</a> 
			<a class="btn disabled">|</a>
			<a class="btn btn-small"><i class="icon-pencil"></i> ändern</a> 
			<a class="btn btn-small"><i class="icon-resize-small"></i> zuordnen</a> 
			<a class="btn btn-small"><i class="icon-resize-full"></i> freigeben</a>
			<a class="btn btn-small"><i class="icon-trash"></i> löschen</a>
		</div>
		<div id="dateEditList" class="span12">
			<table class="table table-bordered table-condensed">
				<thead>
					<tr>
						<th width="30px"><i class="icon-check"></i></th>
						<th>Termin</th>
						<th>Kinder</th>
						<th>Beginndatum</th>
						<th>Endedatum</th>
						<th>Helfer</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><input type="checkBox" /></td>
						<td><p>Ein Tag am Meer</p></td>
						<td>Leo</td>
						<td>12.12.2012</td>
						<td>12.12.2012</td>
						<td>Dagmar &amp; Michael</td>
					</tr>
					<tr>
						<td><input type="checkBox" /></td>
						<td><p>Ein Tag am Wasser</p></td>
						<td>Leo</td>
						<td>12.2.2013</td>
						<td>12.2.2013</td>
						<td>Gudrun &amp; Peter</td>
					</tr>
					<tr>
						<td><input type="checkBox" /></td>
						<td><p>Ein Tag am Strand</p></td>
						<td>Leo</td>
						<td>12.4.2013</td>
						<td>12.4.2013</td>
						<td>Gudrun &amp; Peter</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
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
