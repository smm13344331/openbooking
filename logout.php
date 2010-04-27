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
                'page_title' => 'Logout',
                'page_header' => 'Logout',
                'page_slug' => 'Logout',
                'files' => array ('page-header.html')
                );

// If there is NO username set
if (!isset($_SESSION['username'])) {
    $template['message'] = "<p><strong>Error:</strong> you are already logged out of the system.</p>";
} else {

    // If the form has been submitted, log the user out
    if(isset($_POST['submit'])) {
        unset($_SESSION['username']);
        session_destroy();
	    header('Location: login.php');
    } else {
        $template['message'] = '<p>Are you sure you want to log out?</p>
    <form method="post" action="logout.php">
    	<p><input type="submit" name="submit" value="Log Out" /></p>
    </form>';
   }

}

$template['files'][] = 'message.html';
$template['files'][] = 'page-footer.html';
template_parse($template['files']);

?>
