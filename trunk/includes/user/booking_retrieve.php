<?php
/*
 * $Id$
 * Copyright (c) 2010 Craig Watson [ craig@cwatson.org ]
 * Distributed Under the Mozilla Public License 1.1 [ http://www.mozilla.org/MPL/MPL-1.1.html ]
 */

if (!defined('IN_OB')){
	exit;
}

// Assign template variables
$template['files'][] = 'bookings_create.html';
$template['files'][] = 'bookings_retrieve.html';
$template['bookings'] = "";

// Get the locations list for stage 1
require_once $root_path . 'includes/functions_locations.' . $phpExt;
$all_locations = $db->GetArray("SELECT * FROM " . LOCATIONS_TABLE . " WHERE location_id != 0 ORDER BY loc_order_hash ASC, loc_name ASC");
$template['locations'] = display_form($all_locations, "location", FALSE, "Please Select","update_resources()");

// Get all bookings made by the logged in user.
$date_today = date("Y-m-d");
$date_operator = (isset($_GET['past'])) ? "<" : ">=";
$all_locations = $db->GetAssoc("SELECT * FROM " . LOCATIONS_TABLE);

$sql = "SELECT b.booking_id, b.date, b.user_id, r.booking_location_id, r.return_location_id, r.resource_name, s.time_start, s.time_end FROM " . BOOKINGS_TABLE . " b " . 
       "LEFT JOIN " . SLOTS_TABLE . " s ON s.slot_id = b.slot_id " .
       "LEFT JOIN " . RESOURCES_TABLE . " r ON b.resource_id = r.resource_id " . 
       "WHERE b.date $date_operator '$date_today' ";
//echo $realm;
if (strcmp($template['realm'],"user") == 0){
    // If we're getting a user, which user?
    $user = (isset($_GET['user'])) ? clean_string($_GET['user']) : $_SESSION['username'];
    $sql .= "AND b.user_id = '$user'";
}

// Complete and execute SQL
$sql .= " ORDER BY date ASC";
//print_debug($sql);
$all_bookings = $db->GetArray($sql);

// If there are no bookings found, display notice.
if(count($all_bookings) == 0){
    $colspan = (strcmp($template['realm'],"all") == 0) ? "7" : "6";
    $template['bookings'] = '<tr><td colspan="' . $colspan . '"><p>There are no bookings to display.</p></td></tr>';
} else {
    // Loop through the bookings
    foreach($all_bookings as $booking) {
        $template['bookings'] .= display_booking($booking);
    }
}

// If this is an AJAX refresh, echo the template output
if ($ajax){
    echo $template['bookings'];
}

?>
