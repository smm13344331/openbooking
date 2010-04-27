<?php
/*
 * $Id$
 * Copyright (c) 2010 Craig Watson [ craig@cwatson.org ]
 * Distributed Under the Mozilla Public License 1.1 [ http://www.mozilla.org/MPL/MPL-1.1.html ]
 */
 
define('IN_OB', true);
$root_path = '../';
$phpExt = substr(strrchr(__FILE__, '.'), 1);

// Include standard functions
require_once '../includes/functions.' . $phpExt;
require_once '../includes/functions_debug.' . $phpExt;

// Get the tab name and include the header
$tab = (isset($_GET['tab'])) ? clean_string($_GET['tab']) : "display";
$ajax = isset($_GET['ajax']);

if(!$ajax){
    require_once './style/templates/page-header.html';
}

// Switch on the tab
switch($tab) {

    case 'display':
        require_once './style/templates/install_form.html';
        break;
        
    case 'test':
        require_once './includes/test.php';
        break;
        
    case 'install':
        require_once './includes/install.php';
        break;
        
    case 'license':
        require_once './style/templates/license.html';
        break;

}

if(!$ajax) {
    require_once './style/templates/page-footer.html';
}
?>
