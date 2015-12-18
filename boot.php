<?php

/**
 * This is a very basic loader. 
 * 
 * @author Casper Wilkes <casper@casperwilkes.net>
 */

// Define all constants //
defined('DS') ? NULL : define('DS', DIRECTORY_SEPARATOR);
defined('SITE_ROOT') ? NULL : define('SITE_ROOT', dirname(__FILE__));
defined('APP_ROOT') ? NULL : define('APP_ROOT', SITE_ROOT . DS . 'app');
defined('VIEWS') ? NULL : define('VIEWS', APP_ROOT . DS . 'views');

// Load all required files used across project //
require(APP_ROOT . DS . 'classes' . DS . 'logger.php');
require(APP_ROOT . DS . 'classes' . DS . 'image.php');
require(APP_ROOT . DS . 'classes' . DS . 'sizer.php');

// Start sesssion because it will be used across entire project //
session_start();
