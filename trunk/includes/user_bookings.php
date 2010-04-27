<?php
/*
 * $Id$
 * Copyright (c) 2010 Craig Watson [ craig@cwatson.org ]
 * Distributed Under the Mozilla Public License 1.1 [ http://www.mozilla.org/MPL/MPL-1.1.html ]
 */

if (!defined('IN_OB')){
	exit;
}

$mode = (isset($_GET['mode'])) ? clean_string($_GET['mode']) : "retrieve";

// Main function switch
switch($mode) {

    case 'create':
        require_once $root_path . 'includes/user/booking_create.' . $phpExt;
        break;
               
    case 'delete':
        require_once $root_path . 'includes/user/booking_delete.' . $phpExt;
        break;
        
    case 'retrieve':
        require_once $root_path . 'includes/user/booking_retrieve.' . $phpExt;
        break;
}

?>
