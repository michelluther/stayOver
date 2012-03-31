<div class="popin">
	<h3>Neuen Eintrag erstellen</h3>
	<?php 
		echo form_open('mpm/submit_new_hour_entry');
		echo form_dropdown('dd_project', array('project one', 'project two'));
		echo form_close();
	?>
</div>