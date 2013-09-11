<a class="btn btn-small visible-phone" title="Termindetails"
	onclick="openViewDate(<?php echo $date->getID() ?>)"><i
	class="icon-eye-open"></i> </a>
<a class="btn btn-small" title="Termin bearbeiten"
	onclick="openChangeDate(<?php echo $date->getID() ?>)"><i
	class="icon-pencil"></i>
</a>
<a class="btn btn-small" title="Terminzuweisung"
	onclick="openAssignDate(<?php echo $date->getID() ?>)"><i
	class="icon-resize-small"></i> </a>
<a class="btn btn-small" title="Termin freigeben"
	onclick="openUnassignDate(<?php echo $date->getID() ?>)"><i
	class="icon-resize-full"></i> </a>
<a class="btn btn-small" title="Termin löschen"
	onclick="openDeleteDate(<?php echo $date->getID() ?>)"><i
	class="icon-trash"></i> </a>
