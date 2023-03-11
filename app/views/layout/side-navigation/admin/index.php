<?php

if($_SESSION['type'] == 'guidance') require APPROOT.'/views/layout/side-navigation/admin/guidance/index.php';
if($_SESSION['type'] == 'registrar') require APPROOT.'/views/layout/side-navigation/admin/registrar/index.php';
if($_SESSION['type'] == 'finance') require APPROOT.'/views/layout/side-navigation/admin/finance/index.php';
if($_SESSION['type'] == 'clinic') require APPROOT.'/views/layout/side-navigation/admin/clinic/index.php';

?>