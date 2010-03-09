<?php
/*
 * $Id: index.php 9 2010-02-19 12:57:09Z maidenfan $
 * Copyright (c) 2010 Craig Watson [ craig@cwatson.org ]
 * Distributed Under the Mozilla Public License 1.1 [ http://www.mozilla.org/MPL/MPL-1.1.html ]
 */

define('IN_OB', true);
$root_path = (defined('ROOT_PATH')) ? ROOT_PATH : './';
$phpExt = substr(strrchr(__FILE__, '.'), 1);

require_once $root_path . 'includes/common.' . $phpExt;

require_once $root_path . 'style/templates/page-header.html';

$sql = "SELECT * FROM " . BOOKINGS_TABLE . "";
$result = $db->Execute($sql);
rs2html($result);
echo $db->Version();
require_once $root_path . 'style/templates/page-footer.html';

?>
