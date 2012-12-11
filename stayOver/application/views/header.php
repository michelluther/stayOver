<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>StayOver</title>
<?php
$basePath = base_url();
?>
<link rel=stylesheet
	href="<?php echo $basePath . 'css/bootstrap.css'?>" type="text/css"
	media=screen>
<script type="text/javascript">
			var base_url = "<?= $basePath ?>";
		</script>
<script type="text/javascript" src="<?= $basePath ?>js/jquery_1.7.js"></script>
<script type="text/javascript" src="<?= $basePath ?>js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?= $basePath ?>js/bootstrap.alert.js"></script>
<script type="text/javascript"
	src="<?= $basePath ?>js/jquery_ui_datepicker.min.js"></script>
<script type="text/javascript"
	src="<?= $basePath ?>js/jquery.ui.datepicker-de.js"></script>
<script type="text/javascript"
	src="<?= $basePath ?>js/jquery_livequery.js"></script>
<script type="text/javascript"
	src="<?= $basePath ?>js/jquery.blockUI.js"></script>
<script type="text/javascript" src="<?= $basePath ?>js/form2js.js"></script>
<script type="text/javascript" src="<?= $basePath ?>js/so.js"></script>
<?php if(isset($js)){
	foreach ($js as $jsEntry) {
		?>
<script type="text/javascript"
	src="<?= $basePath ?>js/<?= $jsEntry ?>.js"></script>
<?php
	}
} ?>
<link rel=stylesheet
	href="<?php echo $basePath . 'css/ui_lightness/jquery_ui.css'?>"
	type="text/css" media=screen>
<link rel=stylesheet href="<?php echo $basePath . 'css/mpm.css'?>"
	type="text/css" media=screen>
<!-- <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">  -->
</head>
<body>