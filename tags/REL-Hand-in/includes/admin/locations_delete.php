<?php
/*
 * $Id$
 * Copyright (c) 2010 Craig Watson [ craig@cwatson.org ]
 * Distributed Under the Mozilla Public License 1.1 [ http://www.mozilla.org/MPL/MPL-1.1.html ]
 */
 
if (!defined('IN_OB')){
	exit;
}

if(!isset($_POST['submit'])){

    $id = addslashes(htmlspecialchars($_GET['id']));
    include $root_path . 'style/templates/locations_delete.html';

} else {

    $id = addslashes(htmlspecialchars($_POST['id']));

    // Pull the details for the location
    $location = $db->GetArray("SELECT * FROM " . LOCATIONS_TABLE . " WHERE location_id = $id");
    
    if ($location[0]['loc_num_children'] != 0){
        echo '<p class="error">This location has child elements, and cannot be deleted.</p>';
        exit();
    } else {
        
        // Go ahead and delete the location
        if($db->Execute("DELETE FROM " . LOCATIONS_TABLE . " WHERE location_id = $id")){
            
            // Cascade-delete bookings for this location and resources using this location
            $loc_resources = $db->Execute("SELECT resource_id FROM " . RESOURCES_TABLE . " WHERE return_location_id = $id OR booking_location_id = $id");
            foreach($loc_resources as $resource){
                $db->Execute("DELETE FROM " . RESOURCES_TABLE . " WHERE return_location_id = $id OR booking_location_id = $id");
                $db->Execute("DELETE FROM " . BOOKINGS_TABLE . " WHERE resource_id = " . $resource['resource_id']);
            }
                    
            // If we are successful, decrease the parent's child-count
            $db->Execute("UPDATE " . LOCATIONS_TABLE . " SET loc_num_children = loc_num_children-1" . 
                         " WHERE location_id = " . $location[0]['loc_parent_id']);
                         
            echo "<p>The location was successfully deleted.</p>";
        
        } else {
            echo "<p>There was a database error: " . $db->ErrorMsg() . "</p>";
        }
        
    }
    
    echo "<p><small>[ <a href=\"javascript:hide_element('AJAX_update')\">Hide this message</a> ]</small></p>\n";

}

?>
