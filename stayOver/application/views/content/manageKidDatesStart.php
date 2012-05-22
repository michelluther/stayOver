<h1>Kindertermine</h1>
<div id="datesOverview">
	<h2>N&auml;chste Termine</h2>
</div>
<div id="addDate">
	<h2>Neuen Termin anlegen</h2>
	<form id="addKidForm" action="">
		<label>Termin:</label><input type="text" name="date.title"></input>
		<br />
		<label>Datum:</label><input type="text" name="date.beginDate" class="datepicker"></input>
		<input type="checkbox" name="date.singleDay"></input>
		<br />
		<label>Datum:</label><input type="text" name="date.title"></input>
		<br />
		<label>Kind:</label>
		<select name="date.kid">
			<option value="123123">Leo</option>
			<option value="123124">Janosch</option>
		</select>
		<br />
		<input type="button" value="Termin anlegen" 
					 onclick="submitForm('addKidForm', 
						 									 '/~michel/git_repository/stayOver/stayOver/index.php/manageKidDates/addDate',
						 									 'formSubmitted')" />
	</form>
</div>
