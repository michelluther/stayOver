<?php
if($display['helperDates'] == true){ ?>
<div class="row">
	<div class="span12 headerBg">
		<h2>Deine n&auml;chsten Termine</h2>
	</div>
</div>
<div class="row">
	<div class="span12 functionalArea borderTopBlue"
		id="nextHelperDatesDiv">
		<?php if(count($nextDatesHelper) != 0){
			include "include/nextDatesHelperTable.php";
		} else { ?>
		<p>keine n&auml;chsten Daten</p>
		<?php } ?>
	</div>
</div>
<?php }
if($display['helperOpenDates'] == true){ ?>
<div class="row">
	<div class="span12 headerBg">
		<h2>Offene Termine Deiner unterst&uuml;tzten Kinder</h2>
	</div>
</div>
<div class="row">
	<div class="span12 functionalArea borderTopMighty"
		id="openHelperDatesDiv">
		<?php if(count($openDatesHelper) != 0){
			include "include/nextOpenDatesHelperTable.php";
		} else { ?>
		<p>keine n&auml;chsten Daten</p>
		<?php } ?>
	</div>
</div>
<?php }
if($display['parentDates'] == true){ ?>
<div class="row">
	<div class="span12 headerBg">
		<h2>Die n&auml;chsten Termine Deiner Kinder</h2>
	</div>
</div>
	<div class="functionalArea borderTopMighty">
		<div class="row">
			<div class="span12">
				<a href="#" class="btn btn-small" onclick="openAddDate()"><i
					class="icon-plus"></i> Termin anlegen</a>
			</div>
		</div>
		<div class="row">
			<div id="openHelperDatesDiv" class="span12">
			<?php
			if(count($nextDatesParent) != 0){
				include "include/nextDatesParentTable.php";
			} else { ?>
				<p>keine n&auml;chsten Daten</p>
	<?php }?>
			</div>
		</div>
	</div>
<?php 
} ?>