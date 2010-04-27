<?php
/*
 * $Id$
 * Copyright (c) 2010 Craig Watson [ craig@cwatson.org ]
 * Distributed Under the Mozilla Public License 1.1 [ http://www.mozilla.org/MPL/MPL-1.1.html ]
 */

if (!defined('IN_OB')){
	exit;
}

// Assign template variables
$template['files'][] = 'resources_create.html';
$template['files'][] = 'resources_retrieve.html';
$template['resources'] = "";
$template['category_list'] = "";

// Pull all details
$all_locations_assoc = $db->GetAssoc("SELECT * FROM " . LOCATIONS_TABLE . " WHERE location_id != 0 ORDER BY loc_order_hash ASC, loc_name ASC");    

// Define the SQL to pull all resources, alter if a specific row is requested
$sql = "SELECT * FROM " . RESOURCES_TABLE;
if ($row = isset($_GET['row'])){
    $sql .= " WHERE resource_id = " . clean_string($_GET['row']);
}
$all_resources = $db->Execute($sql . " ORDER BY resource_id ASC");

// If this isn't a category refresh, we generate the return location and bookable location drop-downs
if (!$cat) {
    $template['location_list'] = display_form($all_locations,"create_base_location", FALSE, FALSE);
    $template['book_location'] = str_replace("create_base_location","create_book_location",$template['location_list']);
    
    // Display resources
    foreach($all_resources as $resource){

        $display = display_resource($resource);

        if($ajax){
            echo $display;
        } else {
            $template['resources'] .= $display;
        }
    }
}

$template['category_list'] = display_categories($all_categories);

if(($ajax) && ($cat)){
    echo $template['category_list'];
} else {
    $template['category_list'] = display_categories($all_categories);
}

?>
