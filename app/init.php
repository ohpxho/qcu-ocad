<?php
session_start();

require_once 'vendor/autoload.php';
require_once 'config/config.php';
require_once 'libraries/App.php';
require_once 'libraries/Controller.php';
require_once 'libraries/Database.php';
require_once 'libraries/Chat.php';
require_once 'helpers/session.helper.php';
require_once 'helpers/file.upload.helper.php';
require_once 'helpers/sms.helper.php';
require_once 'helpers/email.helper.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

return new App();

?>