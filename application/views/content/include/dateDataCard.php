<div class="dateData">
	<h4>
		<?= $date->getTitle() ?>
	</h4>
	<span class="dateEntryAttribute hidden-phone">Kind:</span> <span
		class="dateEntryAttributeValue"> <?php $children = $date->getChildren(); 
		foreach ($children as $child) {
			echo $child->getFirstName();
		}?>
	</span> <br class="hidden-phone"/> <span class="dateEntryAttribute hidden-phone">Datum:</span><span
		class="dateEntryAttributeValue"><span class="display-phone">&nbsp;|&nbsp;</span> <?php echo Mpm_calendar::format_period_for_User($date->getBeginDate(), $date->getEndDate())?>
	</span>
	<?php if(isset($parentDate)){?>
	<br/>
	<span>Helfer: 
		<?php 
		$helpers = $date->getHelpers();
			if (count($helpers) == 0){
				echo 'niemand';
			} else {
				$iterator = 0;
				foreach ($helpers as $helper) {
					if ($iterator != 0){
						echo ',<br />';
					}
					echo $helper->getName();
					$iterator += 1;
				}
			}
		?>
	</span>	
	<?php }?>
</div>
