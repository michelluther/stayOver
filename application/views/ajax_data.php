<?php
	$json_array = Array();
	foreach ($ajax_data as $object) {
		$json_entry = $object->getJSONableData();
		array_push($json_array, $json_entry);
	}
	echo (json_encode($json_array));