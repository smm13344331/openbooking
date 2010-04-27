<?php
/*
 * $Id$
 * Copyright (c) 2010 Craig Watson [ craig@cwatson.org ]
 * Distributed Under the Mozilla Public License 1.1 [ http://www.mozilla.org/MPL/MPL-1.1.html ]
 */

if (!defined('IN_OB')){
	exit;
}

/* Outputs a templated resource display row
 * Params:  $res (The raw array of data to output)
 * Returns: The raw XHTML text, ready for a template variable
 */
function display_resource($res){

    global $root_path, $row, $all_categories, $all_locations_assoc, $time_units;
    
    // Output buffering - include the HTML, assign to variable, clean the buffer
    ob_start();
    include $root_path . 'style/templates/resources_retrieve_row.html';
    $return = ob_get_contents();
    ob_end_clean();

    // Return completed row
    return $return;

}

function display_categories($all_categories, $selected = 0, $id = "resource_category", $display_choose = FALSE, $change_function = FALSE){
    if (count($all_categories) == 0){
        return "<p>No categories</p>";
    }
    
    $return = '<select name="' . $id. '" id="' . $id . '"';
    if($change_function) {
        $return .= ' onchange="javascript:' . $change_function . '"';
    }
    $return .= '>' . "\n";
    
    if ($display_choose){
        $return .= '<option value="0">Choose Category</option>';
    }
    
    foreach($all_categories as $key => $category) {
        $return .= "\t<option value=\"" . $key . '"';
        if($selected == $key){ $return .= ' selected="selected"';}
        $return .= '>' . $category . '</option>' . "\n";
    }
    return $return . "</select>\n";
}

?>
