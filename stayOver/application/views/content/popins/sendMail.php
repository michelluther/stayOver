<form id="mailToParents">
<div class="row">
	<div class="span2">Empf&auml;nger</div>
	<div class="span4">
		<?php
			$iterator = 1; 
			foreach ($parents as $parent) {
				if($iterator > 1){
					echo ', ';
				}
				echo $parent->getName();
				$iterator ++;
			}
		?>	
	</div>
</div>
<div class="row">
	<div class="span2">Betreff</div><div class="span4">Nachricht zu Termin: <?php echo $date->getTitle(); ?></div>
</div>
<div class="row">
	<div class="span2">Nachricht</div>
	<div class="span4"><textarea name="mail.text" rows="10" cols="45"></textarea></div>
</div>
<div class="row">
	<div class="span2"><a class="btn btn-small" href="#" onClick="sendMail(<?php echo $date->getID() ?>)"><i class="icon-envelope"></i> E-Mail absenden</a></div>
</div>
</form>