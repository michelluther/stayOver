<h1>Sch&ouml;n, dass Du da bist</h1>
<h2>Ein kleiner &Uuml;berblick &uuml;ber die n&auml;chsten Termine:</h2>
<?php if(count($nextDates) != 0){ ?>
<ul class="list_dates next_dates">
	<?php foreach ($nextDates as $date) {
		include "include/date_list_entry.php";?>
	<?php } ?>
</ul>
<?php } else { ?>
<p>keine n&auml;chsten Daten</p>
<?php } ?>