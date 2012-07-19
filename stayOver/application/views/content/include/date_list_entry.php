<li class="date_list_entry">
	<span class="weekday"><?=Mpm_calendar::get_week_day($date->getBeginDate())?></span>
	<div class="date_list_entry_content">
		<span class="date"><?=Mpm_calendar::format_date_for_User($date->getBeginDate())?></span><br />
		<span class="description"><?=$date->getTitle()?></span>
		<div class="dateNavigation">
			<ul>
				<li>Details</li>
				<li>Notiz</li>
				<li>Bearbeiten</li>
			</ul>
		</div>
	</div>
	
	<span class="helper_square">GP</span>
</li>
