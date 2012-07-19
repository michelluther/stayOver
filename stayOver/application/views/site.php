<div id="full_wrapper">
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
<div id="content"><?php
$this->load->view('content/' . $content['view'], $content['data']);
?></div>
<div id="debugArea"></div>
</div>
<?php
$this->load->view('footer/' . $footer['view'], $footer['data']);
?>
</div>
<?php
$this->load->view('preloader');
?>

