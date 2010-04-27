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

// If user isn't logged in, display login page
if (!isset($_SESSION['username'])) {
	header('Location: login.php');
}

// Start the template array
$template = array(
                'page_title' => 'Home',
                'page_header' => 'Home'
                );
          
$tab = (isset($_GET['tab'])) ? clean_string($_GET['tab']) : "bookings";  // DEFAULT TAB
//$template['page_slug'] = "get";
if (isset($_GET['all'])) {
    $template['realm'] = "all";
    $template['page_slug'] = "all";
} elseif(isset($_GET['user'])){
    $template['page_slug'] = "all";
    $template['realm'] = "user";   
} else {
    $template['page_slug'] = "me";
    $template['realm'] = "user";
}

// If this isn't an Ajax call, add overall and admin headers
if (!$ajax) {
    $template['files'][] = 'page-header.html';
}

// Main function switch
switch($tab) {

    case 'bookings':
        require_once $root_path . 'includes/functions_bookings.' . $phpExt;
        require_once $root_path . 'includes/user_bookings.' . $phpExt;
        break;
        
    case 'refresh':
        require_once $root_path . 'includes/functions_refresh.' . $phpExt;
        require_once $root_path . 'includes/user_bookings_refresh.' . $phpExt;
        break;
    
}

if(!$ajax){
    $template['files'][] = "page-footer.html";
    template_parse($template['files']);
}

?>
