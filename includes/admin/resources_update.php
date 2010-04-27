<?php
/*
 * $Id$
 * Copyright (c) 2010 Craig Watson [ craig@cwatson.org ]
 * Distributed Under the Mozilla Public License 1.1 [ http://www.mozilla.org/MPL/MPL-1.1.html ]
 */
 
if (!defined('IN_OB')){
	exit;
}

if(isset($_POST['submit'])){

    if($cat){
    
        $name = clean_string($_POST['category_name']);
        $id = clean_string($_POST['id']);
        
        $sql = "UPDATE " . RESOURCE_CATEGORIES_TABLE . " SET category_name = '$name' WHERE category_id = $id";
    
    } else {

        // Resource creation
        $name      = clean_string($_POST['resource_name']);
        $cat       = clean_string($_POST['resource_category']);
        $rt_loc    = clean_string($_POST['return_location']);
        $bk_loc    = clean_string($_POST['bookable_location']);
        $category  = clean_string($_POST['resource_category']);
        /*$advance   = clean_string($_POST['advance_time']);
        $adv_unit  = clean_string($_POST['advance_unit']);
        $mtbb      = clean_string($_POST['mtbb_time']);
        $mtbb_unit = clean_string($_POST['mtbb_unit']);*/
        $active    = (isset($_POST['active'])) ? 1 : 0;
        $id        = clean_string($_GET['res']);
      
        // Generate SQL
        $sql = "UPDATE " . RESOURCES_TABLE . 
               " SET resource_name = '$name', category_id = $category, bookable = $active, return_location_id = $rt_loc, booking_location_id = $bk_loc" . 
               //", mtbb_time = $mtbb, mtbb_unit = '$mtbb_unit', advance = $advance, advance_unit = '$adv_unit' " . 
               " WHERE resource_id = $id";
        
    }
    
    if($db->Execute($sql)){
        $text = "<p>'$name' has been updated.";
        if(!$cat){ $text .= "The table on the left has been updated to reflect the changes.";}
        $text .= "</p>";
    } else {
        $text = "<p>There was a database error: " . $db->ErrorMsg() . "</p>";
    }
    
    echo $text .= "<p><small>[ <a href=\"javascript:hide_element('AJAX_update')\">Hide this message</a> ]</small></p>\n";
        
} else {

    if($cat){
        $id = clean_string($_GET['id']);
        $category = $db->GetArray("SELECT * FROM " . RESOURCE_CATEGORIES_TABLE . " WHERE category_id = $id");
        $category = $category[0];
        $update = clean_string($_GET['update']);
        require_once $root_path . 'style/templates/category_update.html';
    } else {
        $id = clean_string($_GET['res']);
        $resource = $db->GetArray("SELECT * FROM " . RESOURCES_TABLE . " WHERE resource_id = $id");
        $resource = $resource[0];
        require_once $root_path . 'style/templates/resources_update_form.html';
    }
}

?>
