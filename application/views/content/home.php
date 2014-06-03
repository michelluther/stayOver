<?php
if(isset($display['helperDates'])){ ?>
<div class="row">
	<div class="span6 functionalArea helperAssigned">
		<div class="alarmClock background-right iconHeading"><h2>N&auml;chste Termine</h2></div>
		<div class="functionalAreaContent" id="nextHelperDatesDiv">
			<?php if(count($nextDatesHelper) != 0){
				include "include/nextDatesHelperList.php";
		} else { ?>
		<div class="dateListEntry">
			<p>keine n&auml;chsten Daten</p>
		</div>	
			<?php } ?>
		</div>
	</div>
	<?php }
if(isset($display['helperOpenDates'])){ ?>
	<div class="span6 functionalArea helperOpen">
		<div class="questionMark background-left iconHeading"><h2>Offene Termine</h2></div>
		<div class="functionalAreaContent" id="openHelperDatesDiv">
			<div>
				<?php if(count($openDatesHelper) != 0){
					include "include/nextOpenDatesHelperList.php";
		} else { ?>
				<div class="dateListEntry">
					<p>keine n&auml;chsten Daten</p>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<?php }
if(isset($display['parentDates'])){ ?>
<div class="row hidden-phone">
	<div class="span12 functionalArea parentDates">
		<div class="calendar background-right iconHeading"><h2>Termine Deiner Kinder</h2></div>
		<div class="functionalAreaContent">
			<a href="#" class="btn btn-small" onclick="openAddDate()"><i
				class="icon-plus"></i> Termin anlegen</a>
			<div id="nextParentDatesDiv">
				<?php
				if(count($nextDatesParent) != 0){
				include "include/nextDatesParentTable.php";
			} else { ?>
				<p>keine n&auml;chsten Daten</p>
				<?php }?>
			</div>
		</div>
	</div>
</div>
<div class="row visible-phone">
	<div class="span12 functionalArea parentDates">
		<div class="pillow"><h2>Termine Deiner Kinder</h2></div>
		<div class="functionalAreaContent">
			<a href="#" class="btn btn-small" onclick="openAddDate()"><i
				class="icon-plus"></i> Termin anlegen</a>
			<div id="nextParentDatesDiv">
				<?php
				if(count($nextDatesParent) != 0){
				include "include/nextDatesParentList.php";
			} else { ?>
				<p>keine n&auml;chsten Daten</p>
				<?php }?>
			</div>
		</div>
	</div>
</div>
<?php 
} ?>