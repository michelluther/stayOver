<?php
if($display['helperDates'] == true){ ?>
<div class="row">
	<div class="span12 functionalAreaHeader yellowBg">
		<h2>Deine n&auml;chsten Termine</h2>
	</div>
</div>
	<div class="functionalArea"
		id="nextHelperDatesDiv">
		<?php if(count($nextDatesHelper) != 0){
			include "include/nextDatesHelperTable.php";
		} else { ?>
		<p>keine n&auml;chsten Daten</p>
		<?php } ?>
	</div>
<?php }
if($display['helperOpenDates'] == true){ ?>
<div class="row">
	<div class="span12 functionalAreaHeader blueBg">
		<h2>Offene Termine Deiner unterst&uuml;tzten Kinder</h2>
	</div>
</div>

	<div class="functionalArea"
		id="openHelperDatesDiv">
		<div>
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
	<div class="span12 functionalAreaHeader redBg">
		<h2>Die n&auml;chsten Termine Deiner Kinder</h2>
	</div>
</div>
	<div class="functionalArea">
		<div class="row">
			<div class="span12">
				<a href="#" class="btn btn-small" onclick="openAddDate()"><i
					class="icon-plus"></i> Termin anlegen</a>
			</div>
		</div>
		<div>
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
<?php 
} ?>