<?php
/*
 * $Id$
 * Copyright (c) 2010 Craig Watson [ craig@cwatson.org ]
 * Distributed Under the Mozilla Public License 1.1 [ http://www.mozilla.org/MPL/MPL-1.1.html ]
 */
 
if (!defined('IN_OB')){
	exit;
}

// Parse the submitted data
$name = clean_string($_POST['name']);
$type = clean_string($_POST['type']);
$parent_id = clean_string($_POST['parent']);

// Pull all possible parents from database, and display an error if the specified parent is invalid
$poss_parents = $db->GetAssoc("SELECT * FROM " . LOCATIONS_TABLE . " WHERE loc_type < $type AND loc_type != 4");
if (!array_key_exists($parent_id,$poss_parents)){
    echo '<p class="error">Error: The parent location (id: ' . $parent_id . ') is not valid.</p>';
    exit();
}

// Find the right parent, create the new hash and increase the number of parent children
$parent = $poss_parents[$parent_id];
$new_hash = create_child_hash($parent['loc_order_hash'], $parent['loc_num_children'], $type);
$parent['loc_num_children']++;

// Generate the insertion SQL
$sql = "INSERT INTO " . LOCATIONS_TABLE . " (loc_name, loc_type, loc_order_hash, loc_num_children, loc_parent_id) ";
$sql .= "VALUES ('$name', $type, '$new_hash', 0, $parent_id)";

// Execute the insert
if($db->Execute($sql)){
    
    // If the insert was successful, update the number of parent's children
    $db->Execute("UPDATE " . LOCATIONS_TABLE .
                 " SET loc_num_children = " . $parent['loc_num_children'] .
                 " WHERE location_id = $parent_id");
                 
    echo "<p>You have successfully created the location '$name' as a subsidary of '" . $parent['loc_name'] . "'. The location map on the left has also been updated.</p>";
} else {
    echo "<p>There was a database error: " . $db->ErrorMsg() . "</p>";
}
    
    echo "<p><small>[ <a href=\"javascript:hide_element('AJAX_update')\">Hide this message</a> ]</small></p>\n";

?>
