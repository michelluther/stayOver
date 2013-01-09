<p>M&ouml;chtest Du <?php echo $child->getName() ?> wirklich l&ouml;schen?</p>
<p><input type="button" value="Ja, Kind l&ouml;schen"
				onclick="deleteChild(<?php echo $child->getID() ?>)"
				class="btn" /></p>