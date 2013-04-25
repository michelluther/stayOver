<p>M&ouml;chtest Du <?php echo $child->getName() ?> wirklich l&ouml;schen?</p>
<div class="buttonRow"><a 
				onclick="deleteChild(<?php echo $child->getID() ?>)"
				class="btn btn-small" >Ja, Kind l&ouml;schen</a>
				<a onclick="closePopup()" class="btn btn-small">Nein, Kind behalten</a></div>