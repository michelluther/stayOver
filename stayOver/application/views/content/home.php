<?php
if($display['helperDates'] == true){ ?>

<div class="row">
	<div class="span6 functionalArea helperAssigned">
		<h2 class="yellowBg">Deine n&auml;chsten Termine</h2>
		<div class="functionalAreaContent" id="nextHelperDatesDiv">
			<?php if(count($nextDatesHelper) != 0){
				include "include/nextDatesHelperList.php";
		} else { ?>
			<p>keine n&auml;chsten Daten</p>
			<?php } ?>
		</div>
	</div>

	<?php }
if($display['helperOpenDates'] == true){ ?>
	<div class="span6 functionalArea helperOpen">
		<h2>Offene Termine Deiner unterst&uuml;tzten Kinder</h2>
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
if($display['parentDates'] == true){ ?>
<div class="row">
	<div class="span12 functionalArea parentDates">
		<h2>Die n&auml;chsten Termine Deiner Kinder</h2>
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

<?php 
} ?>