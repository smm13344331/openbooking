<?php
/*
 * $Id$
 * Copyright (c) 2010 Craig Watson [ craig@cwatson.org ]
 * Distributed Under the Mozilla Public License 1.1 [ http://www.mozilla.org/MPL/MPL-1.1.html ]
 */
 
define('IN_OB', true);
$root_path = (defined('ROOT_PATH')) ? ROOT_PATH : './';
$phpExt = substr(strrchr(__FILE__, '.'), 1);
require_once $root_path . 'includes/common.' . $phpExt;

// If user isn't logged in, display login page. If we're not authorised, redirect to index
if (!isset($_SESSION['username'])) {
	header('Location: login.php');
} elseif(!$_SESSION['admin']){
    header('Location: index.php');
}

// Start the template array
$template = array(
                'page_title' => "Administration",
                'page_header' => "Administration",
                'page_slug' => 'admin',
                'files' => array()
            );

// Instantiate page control variables
$tab = (isset($_GET['tab'])) ? clean_string($_GET['tab']) : "slots";  // DEFAULT TAB
$template['page_slug'] .= "_$tab";

// If this isn't an Ajax call, add overall and admin headers
if (!$ajax) {
    $template['files'][] = 'page-header.html';
}

// Main function switch
switch($tab) {

    case 'slots':
        require_once $root_path . 'includes/functions_slots.' . $phpExt;
        require_once $root_path . 'includes/admin_slots.' . $phpExt;
        break;
    
    case 'locations':
        require_once $root_path . 'includes/functions_locations.' . $phpExt;
        require_once $root_path . 'includes/admin_locations.' . $phpExt;
        break;
        
    case 'resources':
        require_once $root_path . 'includes/functions_resources.' . $phpExt;
        require_once $root_path . 'includes/admin_resources.' . $phpExt;
        break;

}

// If we're NOT in Ajax mode, add the footer and parse the templates
if (!$ajax) {
    $template['files'][] = 'page-footer.html';
    template_parse($template['files']);
}



?>
