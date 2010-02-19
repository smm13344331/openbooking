<?php
/*
 * ./slots.php
 * OpenBooking version 0.0.1
 * Copyright (c) 2010 Craig Watson [ craig@cwatson.org ]
 * Distributed Under the Mozilla Public License 1.1 [ http://www.mozilla.org/MPL/MPL-1.1.html ]
 */

define('IN_OB', true);
$root_path = (defined('ROOT_PATH')) ? ROOT_PATH : './';
$phpExt = substr(strrchr(__FILE__, '.'), 1);

require_once $root_path . 'includes/common.' . $phpExt;

require_once $root_path . 'style/templates/page-header.php';?>
<h2>Slot Management</h2>

<?php 
// Check for POST Submit
if (isset($_POST['submit'])) {

    print_debug($_POST);

}

require_once $root_path . 'style/templates/form_slots.php';

//$all_slots = $db->GetAssoc("SELECT * FROM " . SLOTS_TABLE);
//print_debug($all_slots);

require_once $root_path . 'style/templates/page-footer.php';

?>

