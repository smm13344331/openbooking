<?php
/*
 * $Id$
 * OpenBooking version 0.0.1
 * Copyright (c) 2010 Craig Watson [ craig@cwatson.org ]
 * Distributed Under the Mozilla Public License 1.1 [ http://www.mozilla.org/MPL/MPL-1.1.html ]
 */

if (!defined('IN_OB')){
	exit;
}

$sql = "SELECT * FROM " . SLOTS_TABLE;

if (!$ajax){
    require_once $root_path . 'style/templates/slot_create.html';?>

<div id="slotsTable"><div style="margin-right: 340px;">

<h3>Current Slots</h3>
<p>To update or delete a slot, click on the appropriate icon in the table below. To create a new slot, enter the details in the form on the right.</p>
<script src="javascript/slots.js" type="text/JavaScript"></script>

<table class="slots" style="margin: 0px auto;" border="0" id="slots" cellspacing="1" cellpadding="5">
    <tr>
        <th>Start</th>
        <th>End</th>
        <th>Days</th>
        <th>Update</th>
        <th>Delete</th>
    </tr>
<?php

} else {
    if ($row){
        $sql .= " WHERE slot_id = " . addslashes(htmlspecialchars($_GET['row']));
    }
}

$sql .= " ORDER BY time_start ASC, days_hash DESC";
$all_slots = $db->Execute($sql);

foreach($all_slots as $slot) {?>
    <?php if (!$row) { echo '<tr id="row_' . $slot['slot_id'] . '">' . "\n"; }?>
        <td>
            <p class="edit_default" id="d_start_<?php echo $slot['slot_id']; ?>"><?php echo substr($slot['time_start'],0,5); ?></p>
            <p style="display: none" id="h_start_<?php echo $slot['slot_id']; ?>">
                <input class="mono" type="text" name="start_time_h" id="start_time_h_<?php echo $slot['slot_id']; ?>" value="<?php echo substr($slot['time_start'],0,2); ?>" size="2" maxlength="2" />&nbsp;:
                <input class="mono" type="text" name="start_time_m" id="start_time_m_<?php echo $slot['slot_id']; ?>" value="<?php echo substr($slot['time_start'],3,2); ?>" size="2" maxlength="2" />
            </p>
        </td>
        <td>
            <p class="edit_default" id="d_end_<?php echo $slot['slot_id']; ?>"><?php echo substr($slot['time_end'],0,5); ?></p>
            <p style="display: none" id="h_end_<?php echo $slot['slot_id']; ?>">
                <input class="mono" type="text" name="end_time_h" id="end_time_h_<?php echo $slot['slot_id']; ?>" value="<?php echo substr($slot['time_end'],0,2); ?>" size="2" maxlength="2" />&nbsp;:
                <input class="mono" type="text" name="end_time_m" id="end_time_m_<?php echo $slot['slot_id']; ?>" value="<?php echo substr($slot['time_end'],3,2); ?>" size="2" maxlength="2" />
            </p>
        </td>
        <td>
            <p class="edit_default" id="d_days_<?php echo $slot['slot_id']; ?>"><?php echo days_hash_to_text_short($slot['days_hash']); ?></p>
            <div style="display: none" id="h_days_<?php echo $slot['slot_id']; ?>"><?php echo days_hash_to_form($slot['days_hash'],$days_letters,$days_short); ?></div>
        </td>
        <td>
            <p class="edit_default" id="d_update_<?php echo $slot['slot_id']; ?>"><a href="javascript:toggle_edit('<?php echo $slot['slot_id']; ?>')"><img src="style/images/icons/update.png" alt="Update" title="Update" /></a></p>
            <p style="display: none" id="h_update_<?php echo $slot['slot_id']; ?>"><input type="button" value="Update" name="update" onclick="javascript:save_edit('<?php echo $slot['slot_id']; ?>')" /><br /><input type="button" value="Cancel" name="cancel" onclick="javascript:toggle_edit('<?php echo $slot['slot_id'];?>')" /></p>
        </td>
        <td><p><a href="javascript:delete_row('<?php echo $slot['slot_id']; ?>','<?php echo substr($slot['time_start'],0,5); ?>','<?php echo substr($slot['time_end'],0,5); ?>','<?php echo days_hash_to_text($slot['days_hash']);?>')"><img src="style/images/icons/delete.png" alt="Delete" title="Delete" /></a></p></td>
    <?php if (!$row) { echo "</tr>\n"; }?>
<?php
} // End foreach

if (!$ajax) {
?>
</table>
</div></div>
<?php
} // End $ajax
?>
