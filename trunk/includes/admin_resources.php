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
$template['page_title'] .= " &raquo; Resource Management";
$template['page_header'] .= " &raquo; Resource Management";

$mode = (isset($_GET['mode'])) ? clean_string($_GET['mode']) : "retrieve";
$cat = (isset($_GET['cat']));

// If the page is updating or retrieving resources
if((strcmp($mode,"update") == 0) || (strcmp($mode,"retrieve") == 0)){
    require_once $root_path . 'includes/functions_locations.' . $phpExt;
    $all_categories = $db->GetAssoc("SELECT * FROM " . RESOURCE_CATEGORIES_TABLE);
    $all_locations = $db->GetArray("SELECT * FROM " . LOCATIONS_TABLE . " WHERE location_id != 0 ORDER BY loc_order_hash ASC, loc_name ASC");    
}

// Main function switch
switch($mode) {

    case 'create':
        require_once $root_path . 'includes/admin/resources_create.' . $phpExt;
        break;
        
    case 'update':
        require_once $root_path . 'includes/admin/resources_update.' . $phpExt;
        break;
        
    case 'delete':
        require_once $root_path . 'includes/admin/resources_delete.' . $phpExt;
        break;
        
    case 'retrieve':
        require_once $root_path . 'includes/admin/resources_retrieve.' . $phpExt;
        break;
}

?>
