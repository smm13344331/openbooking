<?php
/*
 * $Id$
 * Copyright (c) 2010 Craig Watson [ craig@cwatson.org ]
 * Distributed Under the Mozilla Public License 1.1 [ http://www.mozilla.org/MPL/MPL-1.1.html ]
 */

if (!defined('IN_OB')){
	exit;
}

// Start the session
session_start();

// Redirect to Installer if the directory is present and there is no config.php
if((!is_file($root_path . 'includes/config.' . $phpExt)) & (is_dir($root_path . "install"))){
    header("Location: install/index.php");
    exit();
}

// Now include the config.php
require_once $root_path . 'includes/config.' . $phpExt;

// Check for install directory and "installed" constant
if((is_dir($root_path . 'install')) && (defined("OB_INSTALLED"))){
    echo "Please delete the OpenBooking install directory.";
    exit();
} elseif (!defined("OB_INSTALLED")){
    echo "OpenBooking is not installed, nor is the install directory present. Please re-upload the install directory to continue.";
    exit();
}

require_once $root_path . 'includes/constants.' . $phpExt;
require_once $root_path . 'includes/functions.' . $phpExt;

// ADODB Database Abstraction Layer
require_once $root_path . 'includes/adodb5/adodb.inc.' . $phpExt;

// Setup database connection
$db = NewADOConnection($dbms);

// If we're in debug mode...
if (defined('DEBUG')) {
    $_SESSION['username'] = "debug"; $_SESSION['admin'] = FALSE;
    //$_SESSION['username'] = "cpw6"; $_SESSION['admin'] = TRUE;
    require_once $root_path . 'includes/functions_debug.' . $phpExt;
}

// Do the connect, some database initialisation stuff and unset the password
$db->Connect($dbhost, $dbuser, $dbpass, $dbname);
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
unset($dbpasswd);

// Move this to languages, eventually
$days_long = array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
$days_short = array('Mon','Tue','Wed','Thu','Fri','Sat','Sun');
$days_letters = array('M','T','W','T','F','S','S');
$time_units = array( 'm' => 'minutes',
                     'h'  => 'hours',
                     'd' => 'days',
                     'M' => 'months');
                     
// Is this page an AJAX call?
$ajax = isset($_GET['ajax']);
date_default_timezone_set("Europe/London");
                                        
?>
