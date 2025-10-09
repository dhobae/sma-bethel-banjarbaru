<?php
//SET TIMEZONE WITA
date_default_timezone_set("Asia/Ujung_Pandang");

//URL Root
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$name_server = explode("/", $_SERVER['PHP_SELF']);
define('URLROOT', $protocol . $_SERVER['HTTP_HOST'] . '/' . $name_server[1]);
// DB Params
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'skatel');

// App Root
define('APPROOT', dirname(dirname(__FILE__)));
// Site Name
define('SITENAME', 'STMIK BANJARBARU');
// App Version
define('APPVERSION', '1.2.0');
// API Key Whatsapp Sender Device
define('API_WA', '7ae0a771-12ed-4f71-a69d-0b900f9ac9b7_pahdi');
