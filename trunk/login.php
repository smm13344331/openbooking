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

$template = array(
                'page_title' => 'Login',
                'page_header' => 'Login',
                'page_slug' => 'login',
                'files' => array ('page-header.html'),
                );

// If form submitted, evaluate
if (isset($_POST['submit'])) {

    require_once $root_path . 'includes/functions_login.php';
    
	// Transfer POST variables to local and make safe
	$username = clean_string($_POST['username']);
	$password = clean_string($_POST['password']);

    if ((strcmp($username,"") == 0) || (strcmp($password,"") == 0)){
        $template['message'] = "<p><strong>Error: Please enter a username and password.</strong></p>";
        $template['files'][] = "login_form.html";
    } else {
    	ldap_authenticate($username,$password);

    }

}

$template['files'][] = 'login_form.html';
$template['files'][] = 'page-footer.html';
template_parse($template['files']);


?>
