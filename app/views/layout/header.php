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
	<script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
	<script src="https://cdn.tiny.cloud/1/7elu8ekkxuva22xqxvntaj3kdbul7nl5s31cn48b1gv2sch3/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
	<script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.1/dist/chart.umd.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/2.3.5/jspdf.plugin.autotable.js"></script>
	<script src="<?php echo URLROOT;?>/public/script/main.js"></script>
	<script src="<?php echo URLROOT;?>/public/script/activity.chart.js"></script>
	<script src="<?php echo URLROOT;?>/public/script/ajax.request.js"></script>
	<script src="<?php echo URLROOT;?>/public/script/calendar.js"></script>
</head>

<body class="text-neutral-700 ">

<!------- websocket client connection ------->

<script>
	<?php
		require_once WEBROOT.'/public/script/ws.client.js';
	?>
</script>