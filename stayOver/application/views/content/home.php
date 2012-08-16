<div class="row"><h1 class="span12">Sch&ouml;n, dass Du da bist</h1></div>
<div class="row">
<div class="span6">
<p>Die letzten Ereignisse</p>
</div>
<div class="span5">
<h2>Deine n&auml;chsten Termine:</h2>
<?php if(count($nextDates) != 0){ ?>
<table class="list_dates next_dates table table-bordered">
<?php foreach ($nextDates as $date) {
	include "include/date_table_entry.php";?>
	<?php } ?>
</table>
<?php } else { ?>
<p>keine n&auml;chsten Daten</p>
<?php } ?>
</div>
</div>
