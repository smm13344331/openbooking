<?php
/*
 * $Id: slot_retrieve.php 16 2010-03-09 10:24:59Z maidenfan $
 * Copyright (c) 2010 Craig Watson [ craig@cwatson.org ]
 * Distributed Under the Mozilla Public License 1.1 [ http://www.mozilla.org/MPL/MPL-1.1.html ]
 */

if (!defined('IN_OB')){
	exit;
}


$sql = "SELECT * FROM " . SLOTS_TABLE;

$template['days_hash_form'] = days_hash_to_form("0000000", $days_letters, $days_short);
$template['files'][] = 'slot_create.html';
$template['files'][] = 'slot_retrieve.html';
$template['slots'] = "";

// If we're getting a single row, add the SQL clause
if ($row = isset($_GET['row'])){
    $sql .= " WHERE slot_id = " . clean_string($_GET['row']);
}

// Complete the SQL and execute the query
$sql .= " ORDER BY time_start ASC, days_hash DESC";
$all_slots = $db->Execute($sql);

// Loop through the slots
foreach($all_slots as $slot) {

    // If this is an Ajax call, just echo the slot. If not, add it to the template
    if ($ajax) {
        echo display_slot($slot);
    } else {
        $template['slots'] .= display_slot($slot);
    }
}

?>
