<?php

class SO_JSONData implements MPM_JSONData{
	public function getJSONableData(){
		return get_object_vars($this);
	}
}