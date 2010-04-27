<?php
/*
 * $Id: functions_debug.php 16 2010-03-09 10:24:59Z maidenfan $
 * OpenBooking version 0.0.1
 * Copyright (c) 2010 Craig Watson [ craig@cwatson.org ]
 * Distributed Under the Mozilla Public License 1.1 [ http://www.mozilla.org/MPL/MPL-1.1.html ]
 */

if (!defined('IN_OB')){
	exit;
}

/* Simple function to print out an element within <pre> XHTML tags */
function print_debug($text){
    echo "\n<!-- START DEBUG OUTPUT --><pre>";
    print_r($text);
    echo "</pre><!-- END DEBUG OUTPUT -->\n";
}


?>
