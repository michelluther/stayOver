<a class="btn btn-small" title="Termindetails"
	onclick="openViewDate(<?php echo $date->getID() ?>)"><i
	class="icon-eye-open"></i> </a>
<a class="btn btn-small" title="Kalendereintrag"
	onClick="openCalendarEntry(<?php echo $date->getID() ?>)"><i
	class="icon-calendar"></i> </a>
<a class="btn btn-small" title="Email an die Eltern"
	onClick="openEmailToParents(<?php echo $date->getID() ?>)"><i
	class="icon-envelope"></i> </a>
<a class="btn btn-small" title="Terminfreigabe"
	onclick="openUnassignDate(<?php echo $date->getID() ?>)"><i
	class="icon-resize-full"></i> </a>
