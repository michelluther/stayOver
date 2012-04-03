<h1>Sch&ouml;n, dass Du da bist</h1>
<h2>Ein kleiner &Uuml;berblick &uuml;ber die n&auml;chsten Termine:</h2>
<?php if(count($nextDates) != 0){
?><ul><?php foreach ($nextDates as $date) {
	?>

	<li><i><?=$date->getBeginDateString()?></i><?=$date->getTitle()?></li>
<?php } ?>	
</ul>
<?php } else { ?>
	<p>keine nächsten Daten</p>
	<?php } ?>