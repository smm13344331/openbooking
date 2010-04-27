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

    // Parse POST data
    $loc   = clean_string($_POST['location']);
    $res   = clean_string($_POST['resource']);
    $date  = clean_string($_POST['date']);
    $slot  = clean_string($_POST['slot']);
    
    // Generate SQL
    $sql = "INSERT INTO " . BOOKINGS_TABLE . " (slot_id, user_id, resource_id, date) VALUES ($slot, '" . $_SESSION['username'] . "', $res, '$date')";
    
    // Execute the insert
    if($db->Execute($sql)){      
        echo "<p>You have successfully created a booking. The list on the left has also been updated.</p>";
    } else {
        echo "<p>There was a database error: " . $db->ErrorMsg() . "</p>";
    }

} else {
    echo "<p>The form was not submitted via 'POST'.</p>";
}

echo "<p><small>[ <a href=\"javascript:hide_element('AJAX_update')\">Hide this message</a> ]</small></p>\n";

?>
