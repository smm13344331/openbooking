<?php
/*
 * $Id$
 * Copyright (c) 2010 Craig Watson [ craig@cwatson.org ]
 * Distributed Under the Mozilla Public License 1.1 [ http://www.mozilla.org/MPL/MPL-1.1.html ]
 */
 
if (!defined('IN_OB')){
	exit;
}

/* Outputs a templated location display row
 * Params:  $loc (The raw array of data to output)
 * Returns: The raw XHTML text, ready for a template variable
 */
function display_location($loc) {

    global $root_path;

    // Output buffering - include the HTML, assign to variable, clean the buffer
    ob_start();
    include $root_path . 'style/templates/locations_retrieve_row.html';
    $return = ob_get_contents();
    ob_end_clean();

    // Return completed row
    return $return;

}

/* Outputs a location list (ADODB GetArray) as <select> list
 * Params:  $loc (The raw array of data to output)
 * Returns: XHTML <option> tag
 */ 
function display_form($all_locations, $form_element_name, $selected_id = FALSE, $display_no_parent = TRUE, $onchange = FALSE){

    if(count($all_locations) == 0) {
        return "<p>No locations</p>";
    }
    
    // Start the <select>
    $return = "<select name=\"$form_element_name\" id=\"parent\"";
    if ($onchange) {
        $return .= " onchange=\"$onchange\"";
    } 
    
    $return .= ">\n";
    
    if($display_no_parent){
        $return .= "<option value=\"0\">" . $display_no_parent . "</option>\n";
    }
    
    // Loop through locations
    foreach($all_locations as $location){
    
        // Define padding variable
        $padding = "";
        
        // Start the <option>
        $return .= "\t<option value=\"" . $location['location_id'] . '"';
        if ($location['location_id'] == $selected_id) {
            $return .= ' selected="selected"';
        }
        $return .= ">";
        
        // Creates padding with a width of 2 x the location type if this isn't a base element
        if ($location['loc_type'] != 1) {
            $return .= str_pad($padding, $location['loc_type'] * 2, "-", STR_PAD_LEFT);
        }
        
        // Output the location name and finish the <option>
        $return .= " " . $location['loc_name'] . "</option>\n";

    }
    
    // Close the <select> and return
    return $return . "</select>\n";
}

/* Creates a new hash for a child location from its parent's
 * Params: $parent_hash     (The string-based hash of the parent location)
 *         $num_children    (The number of children currently in the parent location)
 *         $child_type      (The numeric type of the child location)
 * Return: The child's new hash
 */ 
function create_child_hash($parent_hash, $num_children, $child_type){
    $new_hash = explode("-", $parent_hash);     // 1 - Explode the parent hash
    $generate_index = $child_type - 1;          // 2 - Calculate the index of the array to regenerate
                                                // 3 - Zero-pad the new value
    $new_hash[$generate_index] = str_pad($num_children + 1,3,"0",STR_PAD_LEFT);
    return implode($new_hash,"-");              // 4 - Return the new imploded string

}

?>
