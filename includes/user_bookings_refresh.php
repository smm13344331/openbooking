<?php
/*
 * $Id$
 * Copyright (c) 2010 Craig Watson [ craig@cwatson.org ]
 * Distributed Under the Mozilla Public License 1.1 [ http://www.mozilla.org/MPL/MPL-1.1.html ]
 */

if (!defined('IN_OB')){
	exit;
}

$mode = (isset($_GET['mode'])) ? clean_string($_GET['mode']) : "retrieve";

// Main function switch
switch($mode) {

    case 'resource':
        $loc = clean_string($_GET['loc']);
        $all_resources = $db->GetArray("SELECT * FROM " . RESOURCES_TABLE . " WHERE booking_location_id = $loc AND bookable = 1 ORDER BY resource_id ASC");

        display_resources_form($all_resources);
        break;
        
    case 'slot':
    
        // Default days hash
        $days_hash = array("_","_","_","_","_","_","_");
        
        // Parse the GET parameters
        $date = clean_string($_GET['date']);
        $res = clean_string($_GET['res']);
        
        // Explode the date to an array, and find what day the date is. Then make a hash for that day.
        $date_array = explode("-",$date);     
        $date_stamp = mktime(0, 0, 0, $date_array[1], $date_array[2], $date_array[0]);
        $index = array_search(date("D",$date_stamp),$days_short);
        $days_hash[$index] = 1; $days_hash = implode($days_hash);

        // Do two SQL queries to get all possible slots that match the day hash and all slots booked on that date, and diff them on keys
        $sql = "SELECT * FROM " . SLOTS_TABLE . " WHERE days_hash LIKE '$days_hash'";
        $slots_possible = $db->GetAssoc($sql);
        $slots_booked = $db->GetAssoc("SELECT s.slot_id, s.time_start, s.time_end FROM " . SLOTS_TABLE . " s LEFT JOIN " . BOOKINGS_TABLE . " b ON b.slot_id = s.slot_id WHERE b.date = '$date' ORDER BY s.time_start ASC");      
        $slots_available = array_diff_key($slots_possible,$slots_booked);
   
        // Now do the display. If we don't have any slots, output a <p> instead of the <select>
        if(count($slots_available) == 0) {
            echo "<p id=\"slot\">No slots available</p>";
            exit;
        }
        display_slots_form($slots_available);
}

?>
