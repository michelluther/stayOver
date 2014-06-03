<?php foreach ($availableHelpers as $helper) {
			echo ('<tr><td>' . $helper->getName() . '</td><td width="40px"><a class="btn btn-small" onclick="removeHelperFromChild(' . 
						$kid->getID() . ', ' . $helper->getID() . ')"><i class="icon-trash"></i></a></td></tr>');
		}?>