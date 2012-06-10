<?php $basePath = base_url(); ?>
<h1>Kindertermine</h1>
<div id="datesOverview">
	<h2>N&auml;chste Termine</h2>
</div>
<ul>
	<li><a href="javascript:openAddDate()">Neuen Termin anlegen</a></li>
</ul>
<div id="addDateDiv" style="display:none">
	<h2>Neuen Termin anlegen</h2>
	<form id="addKidForm" action="">
		<label>Termin:</label><input type="text" name="date.title"></input>
		<br />
		<label>Datum:</label><input type="text" name="date.beginDate" class="datepicker"></input>
		<input type="checkbox" name="date.singleDay"></input>
		<br />
		<label>Datum:</label><input type="text" name="date.endDate" class="datepicker"></input>
		<br />
		<label>Kind:</label>
		<select name="date.kid">
			<option value="123123">Leo</option>
			<option value="123124">Janosch</option>
		</select>
		<br />
		<label>Anmerkungen:</label>
		<textarea name="date.note" cols="40" rows="4">...</textarea>
		<input type="button" value="Termin anlegen" 
					 onclick="submitForm('addKidForm', 
						 				 '<?= $basePath ?>index.php/manageKidDates/addDate',
						 				 'formSubmitted')" />
	</form>
</div>
