<?php
/*
 * $Id$
 * Copyright (c) 2010 Craig Watson [ craig@cwatson.org ]
 * Distributed Under the Mozilla Public License 1.1 [ http://www.mozilla.org/MPL/MPL-1.1.html ]
 */

if (!defined('IN_OB')){
	exit;
}

function display_resources_form($all_resources){
    echo '<select name="resource" id="resource">';
    foreach($all_resources as $resource){
        echo '<option value="' . $resource['resource_id'] . '">' . $resource['resource_name'] . '</option>';
    }
    echo '</select>';
}

function display_slots_form($all_slots){

    echo '<select name="slot" id="slot">';
    foreach($all_slots as $key => $slot){
        $text = substr($slot['time_start'],0,5) . " to " . substr($slot['time_end'],0,5);
        echo "<option value=\"$key\">$text</option>";
    }
    echo '</select>';

}

?>
