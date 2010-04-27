<?php
/*
 * $Id$
 * Copyright (c) 2010 Craig Watson [ craig@cwatson.org ]
 * Distributed Under the Mozilla Public License 1.1 [ http://www.mozilla.org/MPL/MPL-1.1.html ]
 */

if (!defined('IN_OB')){
	exit;
}

function display_booking($booking){

    global $root_path, $all_locations, $template;
    
    $booking['time_start'] = substr($booking['time_start'],0,5);
    $booking['time_end'] = substr($booking['time_end'],0,5);

    $date_array = explode("-",$booking['date']);     
    $date_stamp = mktime(0, 0, 0, $date_array[1], $date_array[2], $date_array[0]);
    $booking['date'] = date("D jS F Y",$date_stamp);
    
    // Output buffering - include the HTML, assign to variable, clean the buffer
    ob_start();
    include $root_path . 'style/templates/bookings_retrieve_row.html';
    $return = ob_get_contents();
    ob_end_clean();
    
    return $return;

}

?>
