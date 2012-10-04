<tr>
	<td><?=Mpm_calendar::get_week_day($date->getBeginDate())?></td>
	<td class="date_list_entry_content">
		<span class="date"><?=Mpm_calendar::format_date_for_User($date->getBeginDate())?></span><br />
		<span class="description"><?=$date->getTitle()?></span>
	</td>
	<td>GP</td>
</tr>
