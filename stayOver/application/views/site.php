<?php

if(isset($header['data'])){
	$this->load->view('header', $header['data']);
} else {
	$this->load->view('header');
}
/*
if ($banner['view'] != null) {
	$this->load->view('banner/' . $banner['view'], $banner['data'] );
}*/

if ($navigation['view'] != null){
	$this->load->view('navigation/' . $navigation['view'], $navigation['data']);
}?>
<div id="feedbackArea" class="container">&nbsp;</div>
<div id="content" class="container"><?php
$this->load->view('content/' . $content['view'], $content['data']);
?></div>
<div id="debugArea"></div>
<?php
$this->load->view('preloader');
$this->load->view('popup');
$this->load->view('footer/' . $footer['view'], $footer['data']);
?>


