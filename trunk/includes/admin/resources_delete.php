<?php
/*
 * $Id$
 * Copyright (c) 2010 Craig Watson [ craig@cwatson.org ]
 * Distributed Under the Mozilla Public License 1.1 [ http://www.mozilla.org/MPL/MPL-1.1.html ]
 */

if (!defined('IN_OB')){
	exit;
}

// Deal with the data if the form has been submitted
if(isset($_POST['submit'])) {

    $id = clean_string($_POST['id']);

    
    if($cat){
        
        $has_resources = FALSE;
        if($has_resources = clean_string($_POST['has_resources'])){
            $new_category = clean_string($_POST['new_category']);
        }

        if($db->Execute("DELETE FROM " . RESOURCE_CATEGORIES_TABLE . " WHERE category_id = $id")){
            echo "<p>Category successfully deleted.";
            if($has_resources){
                $db->Execute("UPDATE " . RESOURCES_TABLE . " SET category_id = $new_category WHERE category_id = $id");
                echo " Resources have been successfully reassigned. To view the changed resources, please refresh the page.";
            }
            echo "</p>";
        } else {
            echo "<p>There was a database error: " . $db->ErrorMsg() . "</p>";
        }
    
    } else {
        // Standard stuff. Get the ID, then run the query. If the query succeeds, print message.

        if($db->Execute("DELETE FROM " . RESOURCES_TABLE . " WHERE resource_id = $id")){
            $db->Execute("DELETE FROM " . BOOKINGS_TABLE . " WHERE resource_id = $id");
            echo "<p>Resource successfully deleted.</p>";
        } else {
            echo "<p>There was a database error: " . $db->ErrorMsg() . "</p>";
        }
    }
    
    echo "<p><small>[ <a href=\"javascript:hide_element('AJAX_update')\">Hide this message</a> ]</small></p>\n";

} else {

    $id = clean_string($_GET['id']);

    if($cat){
    
        // Initialise variables and 
        $update = clean_string($_GET['update']);
        $categories = $db->GetAssoc("SELECT * FROM " . RESOURCE_CATEGORIES_TABLE);
        $cat_resources = $db->GetArray("SELECT * FROM " . RESOURCES_TABLE . " WHERE category_id = $id");
        $name = $categories[$id];
        
        if(($has_resources = count($cat_resources)) > 0){
            // Remove the category to delete from the array, and generate the list
            $categories[$id] = FALSE;
            $categories = array_filter($categories);
        }

        $category_list = display_categories($categories, 0, "new_category");
        require_once $root_path . 'style/templates/category_delete.html';

    } else {
        // Display confirm form
        require_once $root_path . 'style/templates/resources_delete.html';
    }
}

?>
