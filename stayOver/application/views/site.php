<?php

if(isset($header['data'])){
	$this->load->view('header', $header['data']);
} else {
	$this->load->view('header');
}
?>


<div id="content" class="container">
	<?php
	if ($navigation['view'] != null){
		$this->load->view('navigation/' . $navigation['view'], $navigation['data']);
	}?>
	<div id="feedbackContainer">
		<div id="feedbackArea" class=""></div>
	</div>
	<div id="contentArea">
		<div id="contentDiv">
			<?php
			$this->load->view('content/' . $content['view'], $content['data']);
			if($content['view'] != 'login_screen'){
				$this->load->view('footer/' . $footer['view'], $footer['data']);
	}
	?>
		</div>
	</div>
</div>
<div id="debugArea"></div>
<?php
$this->load->view('preloader');
$this->load->view('popup');

?>


