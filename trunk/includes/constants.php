<?php
/*
 * $Id$
 * Copyright (c) 2010 Craig Watson [ craig@cwatson.org ]
 * Distributed Under the Mozilla Public License 1.1 [ http://www.mozilla.org/MPL/MPL-1.1.html ]
 */

if (!defined('IN_OB')){
	exit;
}

// Version Number
define('OB_VERSION','0.0.1');

// Resource Restrictions
define('RESTRICT_ON',   1);
define('RESTRICT_OFF',  0);

// 
define('FORM_CHECKED',       1);
define('FORM_NOT_CHECKED',   0);

// Resource Advance Units
define('ADVANCE_MONTH', 'm');
define('ADVANCE_DAY',   'd');
define('ADVANCE_HOUR',  'h');

// Tables
define('RESOURCES_TABLE',           $table_prefix . "resources");
define('BOOKINGS_TABLE',            $table_prefix . "bookings");
define('SLOTS_TABLE',               $table_prefix . "slots");
define('RESOURCE_CATEGORIES_TABLE', $table_prefix . "categories");
define('LOCATIONS_TABLE',           $table_prefix . "locations");

// Location indentation multiplier, in pixels
define('LOCATION_INDENT', 30);

?>
