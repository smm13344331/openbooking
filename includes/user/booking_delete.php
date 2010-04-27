<?php
/*
 * $Id$
 * Copyright (c) 2010 Craig Watson [ craig@cwatson.org ]
 * Distributed Under the Mozilla Public License 1.1 [ http://www.mozilla.org/MPL/MPL-1.1.html ]
 */

if (!defined('IN_OB')){
	exit;
}

if(!isset($_SERVER['HTTP_REFERER'])){
    echo "Direct access is not permitted.";
    exit();
}

$id = clean_string($_GET['id']);

// Pull booking
$booking = $db->GetArray("SELECT * FROM " . BOOKINGS_TABLE . " WHERE booking_id = $id");
    
if (count($booking) != 1){
    echo "<p>There has been a problem with retrieving the booking details or it cannot be found.</p>";
    exit();
}
    
$booking = $booking[0];

// Are we authorised?
if(((!$_SESSION['admin']) && strcmp($_SESSION['username'],$booking['user_id']) != 0)){
    echo "<p>You are not authorised to delete this booking.</p>";
    exit();
}

if (isset($_POST['submit'])){

    // Do the delete
    if($db->Execute("DELETE FROM " . BOOKINGS_TABLE . " WHERE booking_id = $id")){
        echo "<p>The booking has been successfully deleted. The table on the left has also been updated.</p>";
    } else {
        echo "<p>There was a database error: " . $db->ErrorMsg() . "</p>";
    }
    
    echo "<p><small>[ <a href=\"javascript:hide_element('AJAX_update')\">Hide this message</a> ]</small></p>\n";
    
} else {
    
    // Generate referrer URL for AJAX update
    $ref = explode("/",$_SERVER['HTTP_REFERER']);
    $ref = $ref[count($ref)-1] . "&ajax";
           
    require_once $root_path . 'style/templates/bookings_delete.html';
    
}



?>
