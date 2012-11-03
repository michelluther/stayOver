<p>M&ouml;chten Sie die folgenden Termine wirklich l&ouml;schen?

<ul>
	<?php foreach ($dates as $date) { ?>
		<li><?php echo $date->getName() ?>
	<?php }?>
</ul>

<p><input type="button" value="OK"
				onclick="submitDeletion()"
				class="btn" /></p>
