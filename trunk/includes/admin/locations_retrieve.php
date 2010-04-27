<?php
/*
 * $Id$
 * Copyright (c) 2010 Craig Watson [ craig@cwatson.org ]
 * Distributed Under the Mozilla Public License 1.1 [ http://www.mozilla.org/MPL/MPL-1.1.html ]
 */
 
if (!defined('IN_OB')){
	exit;
}

// Add the template files to the array and define local flags
$template['files'][] = 'locations_create.html';
$template['files'][] = 'locations_retrieve.html';
$template['locations'] = "";
$parent = FALSE; $sel = FALSE;

// Define the base SQL
$sql = "SELECT * FROM " . LOCATIONS_TABLE . " WHERE ";

if (isset($_GET['type'])) {

    // If this ia drop-down request, set the flag and process the parent type
    $parent = TRUE;
    $parent_type = addslashes(htmlspecialchars($_GET['type']));
    
    if (isset($_GET['sel'])) {
        $sel = addslashes(htmlspecialchars($_GET['sel']));
    }
    
    // Append to the SQL, and start the XHTML output
    $sql .= "loc_type < $parent_type AND loc_type != 4";
} else {
    $sql .= "location_id != 0";
}

// Execute query and loop through all returned locations
$sql .= " ORDER BY loc_order_hash ASC, loc_name ASC";
$all_locs = $db->GetArray($sql);

if ($parent) {
    echo display_form($all_locs, "parent", $sel, FALSE);
} else {
    
    foreach($all_locs as $loc) {
    
        $location = display_location($loc);
    
        // If we are doing an AJAX call, just echo to the output stream
        if ($ajax) {
            echo $location;
        } else {
            $template['locations'] .= $location;
        }
        
    }
}

?>
