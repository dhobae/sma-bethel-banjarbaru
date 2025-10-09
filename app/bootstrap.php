<?php
// Load Config
require_once 'config/config.php';
// Load Helper
require_once 'helpers/url_helpers.php';
require_once 'helpers/session_helper.php';
require_once 'helpers/datetime_helper.php';
require_once 'helpers/general_helper.php';

// Autoload Core Libraries
spl_autoload_register(function ($className) {
  require_once 'libraries/' . $className . '.php';
});

//Load Middleware
require_once 'libraries/Middleware.php';
