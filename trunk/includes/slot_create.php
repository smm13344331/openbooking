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

    // Parse data: calculate the hash and populate the data array
    $new_slot = array(
                    'time_start'    => sprintf("%02d:%02d:00",$_POST['start_time_h'],$_POST['start_time_m']),
                    'time_end'      => sprintf("%02d:%02d:00",$_POST['end_time_h'],$_POST['end_time_m']),
                    'days_hash'     => day_hash($_POST['days'])
                );
    
    // Get the data for all slots
    $all_slots = $db->GetAssoc("SELECT * FROM " . SLOTS_TABLE);

    // If there are no slots to loop through, there won't be a clash
    if(count($all_slots) == 0) {
        $clash = FALSE;
    } else {
    
        // Loop through existing slots and check for clashes
        foreach ($all_slots as $existing_slot){

            if($clash = check_clash($new_slot,$existing_slot)) {
                break;
            } else {
               $clash = FALSE;
            }
        }

    }
    
    if ($clash) {
        // If there is a clash, print an error
        echo "<p class=\"error\"><strong>Error:</strong> Your submitted slot clashes with an existing slot, between " . substr($clash['time_start'],0,5) . " and " . substr($clash['time_end'],0,5) . " on " . $days_long[$clash['clash_index']] . ".</p>";

    } elseif(!$db->Execute("INSERT INTO " . SLOTS_TABLE . " (time_start,time_end,days_hash) VALUES ('" . $new_slot['time_start'] . "','" . $new_slot['time_end'] . "','" . $new_slot['days_hash'] . "')")) {
        echo "<p>There was a database error: " . $db->ErrorMsg() . "</p>";
    } else {
        
        echo "<p>You have successfully created " . $db->Insert_ID() . " a slot from <strong>" . substr($new_slot['time_start'],0,5) . "</strong> to <strong>" . substr($new_slot['time_end'],0,5) . "</strong> on <strong>" . days_hash_to_text($new_slot['days_hash']) . "</strong>.</p>\n<p> The list on the left has also been updated.</p>\n";
    }
    
    echo "<p><small>[ <a href=\"javascript:hide_element('AJAX_update')\">Hide this message</a> ]</small></p>\n";

} else {
    display_error("The form was not submitted",TRUE);
}
?>
