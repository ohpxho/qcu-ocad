<!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo SITENAME?></title>
	<link rel="icon" href="<?php echo URLROOT;?>/public/assets/img/logo.png">
	<link rel="stylesheet" href="<?php echo URLROOT;?>/public/css/style.css">
	<link rel="stylesheet" href="<?php echo URLROOT;?>/public/css/dist/datatables.css" />
	<!--<script src="https://cdn.tailwindcss.com"></script>-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>	
	<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js" type="text/javascript"></script>
	<script src="https://cdn.tiny.cloud/1/7elu8ekkxuva22xqxvntaj3kdbul7nl5s31cn48b1gv2sch3/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
	<script src="<?php echo URLROOT;?>/public/script/main.js"></script>
	<script src="<?php echo URLROOT;?>/public/script/activity.chart.js"></script>
	<script src="<?php echo URLROOT;?>/public/script/ajax.request.js"></script>
</head>

<body class="text-neutral-700 ">

<!------- websocket client connection ------->

<script>
	<?php
		require_once WEBROOT.'/public/script/ws.client.js';
	?>
</script>