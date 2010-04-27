<?php
/*
 * $Id$
 * Copyright (c) 2010 Craig Watson [ craig@cwatson.org ]
 * Distributed Under the Mozilla Public License 1.1 [ http://www.mozilla.org/MPL/MPL-1.1.html ]
 */
 
if (!defined('IN_OB')){
	exit;
}

// If the form has NOT been submitted
if (!isset($_POST['submit'])) {

    $id = (int) clean_string($_GET['loc']);
    
    // Pull the details for the location and its parent, and display the form
    $location = $db->GetArray("SELECT * FROM " . LOCATIONS_TABLE . " WHERE location_id = $id");
    $poss_parents = $db->getArray("SELECT * FROM " . LOCATIONS_TABLE .
                                  " WHERE loc_type < " . $location[0]['loc_type'] .
                                  " ORDER BY loc_order_hash");
    
    // Build the possible parents box
    if ($location[0]['loc_num_children'] == 0) {
        $parents_form = display_form($poss_parents, "update_parent", $location[0]['loc_parent_id']);
    }
    
    // Include the update form
    include $root_path . 'style/templates/locations_update_form.html';

} else {

    // Parse submitted values
    $id = (int) clean_string($_POST['id']);
    $name = clean_string($_POST['update_name']);  
    $parent_update = FALSE;
    
    // Define base SQL
    $sql = "UPDATE " . LOCATIONS_TABLE . " SET loc_name = '$name'";        
    
    // If the number of children is greater than zero (i.e. true)
    if (!$_POST['children']){
    
        // Parse values
        $new_parent_id = (int) clean_string($_POST['update_parent']);
        $old_parent_id = (int) clean_string($_POST['old_parent']);
        $type = (int) clean_string($_POST['type']);

        // Do we need to update parents?
        if ($new_parent_id != $old_parent_id) {
            $parent_update = TRUE;
            
            // Get hash of new parent, and calculate new location hash
            $new_parent = $db->GetArray("SELECT loc_order_hash, loc_num_children FROM " . LOCATIONS_TABLE . 
                                         " WHERE location_id = $new_parent_id");
             
            $new_hash = create_child_hash($new_parent[0]['loc_order_hash'],
                                          $new_parent[0]['loc_num_children'],
                                          $type);
            
            // Add to SQL
            $sql .= ", loc_parent_id = $new_parent_id, loc_order_hash = '$new_hash'";
        }
    }


    // Complete SQL and execute
    $sql .=" WHERE location_id = $id";
    if ($db->Execute($sql)){
        
        echo "<p>$name successfully updated.</p>";
        
        // Update the parents' child-counts if needed
        if($parent_update){
            $db->Execute("UPDATE " . LOCATIONS_TABLE . " SET loc_num_children = loc_num_children-1 WHERE location_id = $old_parent_id");
            $db->Execute("UPDATE " . LOCATIONS_TABLE . " SET loc_num_children = loc_num_children+1 WHERE location_id = $new_parent_id");
        }
        
    } else {
        echo "<p>There was a database error: " . $db->ErrorMsg() . "</p>";
    }
    
    echo "<p><small>[ <a href=\"javascript:hide_element('AJAX_update')\">Hide this message</a> ]</small></p>\n";

    
}

?>
