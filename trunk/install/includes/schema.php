<?php
/*
 * $Id$
 * Copyright (c) 2010 Craig Watson [ craig@cwatson.org ]
 * Distributed Under the Mozilla Public License 1.1 [ http://www.mozilla.org/MPL/MPL-1.1.html ]
 */
if (!defined('IN_OB')){
	exit;
}
$schema = array();
$schema['bookings']['fields'] = "
  booking_id I NOTNULL AUTOINCREMENT PRIMARY,
  slot_id I NOTNULL,
  user_id C(255) NOTNULL,
  resource_id I NOTNULL,
  date D NOTNULL";

$schema['locations']['fields'] = "
  location_id I NOTNULL AUTOINCREMENT PRIMARY,
  loc_name C(255) NOTNULL,
  loc_type I NOTNULL,
  loc_order_hash C(15) NOTNULL,
  loc_num_children I NOTNULL DEFAULT '0',
  loc_parent_id I NOTNULL";

$schema['resources']['fields'] = "
  resource_id I NOTNULL AUTOINCREMENT PRIMARY,
  resource_name C(255) NOTNULL,
  owner_id C(255) NOTNULL DEFAULT '0',
  category_id I NOTNULL,
  bookable I NOTNULL DEFAULT '0',
  return_location_id I NOTNULL,
  booking_location_id I NOTNULL,
  mtbb_time I NOTNULL DEFAULT '1',
  mtbb_unit C(1) NOTNULL DEFAULT 'h',
  advance I NOTNULL DEFAULT '1',
  advance_unit C(1) NOTNULL DEFAULT 'm'";

$schema['categories']['fields'] = "
  category_id I NOTNULL AUTOINCREMENT PRIMARY,
  category_name C(255) NOTNULL";

$schema['slots']['fields'] = "
  slot_id I NOTNULL AUTOINCREMENT PRIMARY,
  time_start C(8) NOTNULL,
  time_end C(8) NOTNULL,
  days_hash C(7) NOTNULL";

?>
