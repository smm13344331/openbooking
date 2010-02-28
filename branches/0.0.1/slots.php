<?php
/*
 * $Id: slots.php 8 2010-02-19 12:55:41Z maidenfan $
 * OpenBooking version 0.0.1
 * Copyright (c) 2010 Craig Watson [ craig@cwatson.org ]
 * Distributed Under the Mozilla Public License 1.1 [ http://www.mozilla.org/MPL/MPL-1.1.html ]
 */
 
define('IN_OB', true);
$root_path = (defined('ROOT_PATH')) ? ROOT_PATH : './';
$phpExt = substr(strrchr(__FILE__, '.'), 1);

require_once $root_path . 'includes/common.' . $phpExt;
require_once $root_path . 'includes/functions_slots.' . $phpExt;

$mode = (isset($_GET['mode'])) ? $_GET['mode'] : "retrieve";
$ajax = isset($_GET['ajax']);

$template = array(
                'page_title' => "Slot Management",
                'page_header' => "Slot Management"
            );

if (!$ajax) {
    require_once $root_path . 'style/templates/page-header.html';
    $row = FALSE;
} else {
    $row = isset($_GET['row']);
}

switch($mode) {

    case 'create':
        require_once $root_path . 'includes/slot_create.' . $phpExt;
        break;
        
    case 'update':
        require_once $root_path . 'includes/slot_update.' . $phpExt;
        break;
        
    case 'delete':
        require_once $root_path . 'includes/slot_delete.' . $phpExt;
        break;
        
    case 'retrieve':
        require_once $root_path . 'includes/slot_retrieve.' . $phpExt;
        break;
}

if (!$ajax) {
    require_once $root_path . 'style/templates/page-footer.html';
}
    

?>

