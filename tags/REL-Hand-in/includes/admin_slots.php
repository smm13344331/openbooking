<?php
/*
 * $Id$
 * Copyright (c) 2010 Craig Watson [ craig@cwatson.org ]
 * Distributed Under the Mozilla Public License 1.1 [ http://www.mozilla.org/MPL/MPL-1.1.html ]
 */

if (!defined('IN_OB')){
	exit;
} 
 
// Append page titles
$template['page_title'] .= " &raquo; Slot Management";
$template['page_header'] .= " &raquo; Slot Management";

$mode = (isset($_GET['mode'])) ? clean_string($_GET['mode']) : "retrieve";

// Main function switch
switch($mode) {

    case 'create':
        require_once $root_path . 'includes/admin/slot_create.' . $phpExt;
        break;
        
    case 'update':
        require_once $root_path . 'includes/admin/slot_update.' . $phpExt;
        break;
        
    case 'delete':
        require_once $root_path . 'includes/admin/slot_delete.' . $phpExt;
        break;
        
    case 'retrieve':
        require_once $root_path . 'includes/admin/slot_retrieve.' . $phpExt;
        break;
}

?>

