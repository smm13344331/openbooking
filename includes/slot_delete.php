<?php
/*
 * $Id: slot_delete.php 16 2010-03-09 10:24:59Z maidenfan $
 * Copyright (c) 2010 Craig Watson [ craig@cwatson.org ]
 * Distributed Under the Mozilla Public License 1.1 [ http://www.mozilla.org/MPL/MPL-1.1.html ]
 */

if (!defined('IN_OB')){
	exit;
}

if (isset($_POST['submit'])) {

    $id = addslashes(htmlspecialchars($_POST['id']));
    $start = addslashes(htmlspecialchars($_POST['start']));
    $end = addslashes(htmlspecialchars($_POST['end']));
    $days = addslashes(htmlspecialchars($_POST['days']));

    if($db->Execute("DELETE FROM " . SLOTS_TABLE . " WHERE slot_id = $id")){
        echo "<p>You have successfully deleted the slot running from $start to $end on $days.</p>";
    } else {
        echo "<p class=\"error\">There was an error deleting the slot.</p>";
    }
    
    echo "<p><small>[ <a href=\"javascript:hide_element('AJAX_update')\">Hide this message</a> ]</small></p>\n";

} else {
    echo '<p class="error">The form has not been submitted</p>';
}

?>
