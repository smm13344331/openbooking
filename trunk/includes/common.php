<?php
/*
 * ./includes/common.php
 * OpenBooking version 0.0.1
 * Copyright (c) 2010 Craig Watson [ craig@cwatson.org ]
 * Distributed Under the Mozilla Public License 1.1 [ http://www.mozilla.org/MPL/MPL-1.1.html ]
 */

if (!defined('IN_OB')){
	exit;
}

require_once $root_path . 'includes/config.' . $phpExt;
require_once $root_path . 'includes/constants.' . $phpExt;

// ADODB Database Abstraction Layer
require_once $root_path . 'includes/adodb5/adodb.inc.' . $phpExt;
//require_once $root_path . 'includes/adodb5/tohtml.inc.' . $phpExt;

// Setup database connection
$db = NewADOConnection($dbms);

// If we're in debug mode...
if (defined('DEBUG')) {
    //$db->debug = TRUE;
    require_once $root_path . 'includes/functions_debug.' . $phpExt;
}

// Do the connect, some database initialisation stuff and unset the password
$db->Connect($dbhost, $dbuser, $dbpass, $dbname);
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
unset($dbpasswd);

?>
