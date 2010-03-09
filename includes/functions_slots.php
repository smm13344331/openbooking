<?php
/*
 * $Id: functions_slots.php 16 2010-03-09 10:24:59Z maidenfan $
 * Copyright (c) 2010 Craig Watson [ craig@cwatson.org ]
 * Distributed Under the Mozilla Public License 1.1 [ http://www.mozilla.org/MPL/MPL-1.1.html ]
 */

if (!defined('IN_OB')){
	exit;
}

/* Checks two slots for clashes.
 * Params:  $check_slot (The slot to be checked) and $db_slot (The slot pulled from the datbase)
 * Returns: The array of the clashing slot (with day) if the slots clash, FALSE otherwise.
 */
 
function check_clash($check_slot,$db_slot) {

    global $days_long;
    
    // Split the day hashes into arrays of single characters
    $check_slot_array = str_split($check_slot['days_hash']);
    $db_slot_array = str_split($db_slot['days_hash']);

    // Loop through the arrays, checking for a match.
    for($i = 0; $i < 7; $i++){

        // If a match occurs, check the times.
        if (($check_slot_array[$i] == 1) && ($db_slot_array[$i] == 1)) {
            if (check_overlap($check_slot['time_start'], $check_slot['time_end'], $db_slot['time_start'], $db_slot['time_end'])){
                $db_slot['clash_index'] = $i;
                return $db_slot;
            }
        }
    }
    
    // If we made it to here, there are no clashes, so return FALSE
    return FALSE;
}

?>
