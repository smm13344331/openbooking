<?php
/*
 * $Id$
 * Copyright (c) 2010 Craig Watson [ craig@cwatson.org ]
 * Distributed Under the Mozilla Public License 1.1 [ http://www.mozilla.org/MPL/MPL-1.1.html ]
 */
 
if (!defined('IN_OB')){
	exit;
}

// If the form has been submitted, handle the data
if(isset($_POST['submit'])){

    if($cat){

        // Create the category ... fairly simples!
        $name = clean_string($_POST['category_name']);
        
        if($db->Execute("INSERT INTO " . RESOURCE_CATEGORIES_TABLE . " (category_name) VALUES ('$name')")){
            echo "<p>The category '$name' was successfully created. The drop-down below has been updated.</p>";
        } else {
            echo "<p>There was a database error: " . $db->ErrorMsg() . "</p>";
        }
    
    } else {
    
        // Resource creation
        $name      = clean_string($_POST['resource_name']);
        $cat       = clean_string($_POST['resource_category']);
        $rt_loc    = clean_string($_POST['create_base_location']);
        $bk_loc    = clean_string($_POST['create_book_location']);
        /*$advance   = clean_string($_POST['advance_time']);
        $adv_unit  = clean_string($_POST['advance_unit']);
        $mtbb      = clean_string($_POST['mtbb_time']);
        $mtbb_unit = clean_string($_POST['mtbb_unit']);*/

        // No validation needs to be done, so go ahead with the final insert...
        $sql = "INSERT INTO " . RESOURCES_TABLE .
               " (resource_name, owner_id, category_id, return_location_id, booking_location_id, bookable)" .// , mtbb_time, mtbb_unit, advance, advance_unit)" . 
               " VALUES ('$name', 0, $cat, $rt_loc, $bk_loc, 0)";//, $mtbb, '$mtbb_unit', $advance, '$adv_unit')";

       if($db->Execute($sql)){
            echo "<p>The resource '$name' has been created. The table on the left has been updated.</p>";
        } else {
            echo "<p>There was a database error: " . $db->ErrorMsg() . "</p>";
        }
    
    }
    
    echo "<p><small>[ <a href=\"javascript:hide_element('AJAX_update')\">Hide this message</a> ]</small></p>\n";
    
} else {
    
    // Display category form if needed
    if($cat){
        $update = clean_string($_GET['update']);
        include $root_path . 'style/templates/category_create.html';
    }
}

?>
