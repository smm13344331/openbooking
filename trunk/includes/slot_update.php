<?php
/*
 * $Id$
 * Copyright (c) 2010 Craig Watson [ craig@cwatson.org ]
 * Distributed Under the Mozilla Public License 1.1 [ http://www.mozilla.org/MPL/MPL-1.1.html ]
 */

if (!defined('IN_OB')){
	exit;
}

if (isset($_POST['submit'])) {

    //print_debug($_POST);

    $slot = array(
                    'time_start'    => sprintf("%02d:%02d:00",$_POST['start_time_h'],$_POST['start_time_m']),
                    'time_end'      => sprintf("%02d:%02d:00",$_POST['end_time_h'],$_POST['end_time_m']),
                    'days_hash'     => day_hash($_POST['days'])
                );
    
    // Get the details of all slots EXCEPT the one we're editing
    $all_slots = $db->Execute("SELECT * FROM " . SLOTS_TABLE . " WHERE slot_id != " . $db->qstr($_POST['slot_id']));
    
    // If there are no slots to loop through, there won't be a clash
    if(count($all_slots) == 0) {
        $clash = FALSE;
    } else {
    
        // Loop through existing slots and check for clashes
        foreach ($all_slots as $existing_slot){

            if($clash = check_clash($slot,$existing_slot)) {
                break;
            } else {
               $clash = FALSE;
            }
        }

    }
    
    if ($clash) {

        // If there is a clash, print an error
        echo "<p class\"error\">Error: Your submitted slot clashed with an existing slot, between " . substr($clash['time_start'],0,5) . " and " . $clash['time_end'] . " on " . $days_long[$clash['clash_index']] . ". Please go back and correct the details.</p>";

    } elseif(!$db->Execute("UPDATE " . SLOTS_TABLE . " SET time_start = '" . $slot['time_start'] . "', time_end = '" . $slot['time_end'] . "', days_hash = '" . $slot['days_hash'] . "' WHERE slot_id = " . $db->qstr($_POST['slot_id']))) {
        echo "<p>There was a database error: " . $db->ErrorMsg() . "</p>";
    } else {
        echo "<p>You have successfully edited the slot. The slot now runs from " . substr($slot['time_start'],0,5) . " to " . substr($slot['time_end'],0,5) . " on " . days_hash_to_text($slot['days_hash']) . ".</p>\n";
    }
    
    echo "<p><small>[ <a href=\"javascript:hide_element('AJAX_update')\">Hide this message</a> ]</small></p>\n";
    
} else {
    // If we're not submitting, display an error.
    echo "<p class\"error\">Error: The form was not submitted.</p>\n";
}



//print_debug($_POST);


?>
