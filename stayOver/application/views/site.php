<?php

if(isset($header['data'])){
	$this->load->view('header', $header['data']);
} else {
	$this->load->view('header');
}

if ($banner['view'] != null) {
	$this->load->view('banner/' . $banner['view'], $banner['data'] );
}

if ($navigation['view'] != null){
	$this->load->view('navigation/' . $navigation['view'], $navigation['data']);
}
?>
<div id="content_wrapper"><div id="msg_area"><?php 
if($msg != null ){
	$this->load->view('system_feedback', $msg);
}
?></div>
<div id="content"><?php
$this->load->view('content/' . $content['view'], $content['data']);
?></div>
</div>
<?php
$this->load->view('footer/' . $footer['view'], $footer['data']);