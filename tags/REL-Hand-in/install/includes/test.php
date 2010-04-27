<?php
/*
 * $Id$
 * Copyright (c) 2010 Craig Watson [ craig@cwatson.org ]
 * Distributed Under the Mozilla Public License 1.1 [ http://www.mozilla.org/MPL/MPL-1.1.html ]
 */
if (!defined('IN_OB')){
	exit;
}

switch(clean_string($_GET['form'])){

    case 'db':
    
        // Parse input
        $dbhost = clean_string($_POST['db_hostname']);
        $dbuser = clean_string($_POST['db_username']);
        $dbpass = addslashes(trim($_POST['db_password']));
        $dbname = clean_string($_POST['db_name']);
        $dbms = clean_string($_POST['db_dbms']);
        
        // Try the connection.
        require_once $root_path . 'includes/adodb5/adodb.inc.' . $phpExt;        
        $db = NewADOConnection($dbms);
        if(@$db->Connect($dbhost, $dbuser, $dbpass, $dbname)){
            echo '<p><strong>The connection was successful.</strong><input type="hidden" name="db_valid" id="db_valid" value="1" /></p>';
            echo '<p><input type="button" name="db_save" id="db_save" value="Save Details" onclick="save(\'db\')" />';
            $db->Close();
        } else {
            echo '<p><strong>The details entered are invalid.</strong></p><p>The error from the database server was: ' . $db->ErrorMsg() . '</strong></p>';
        }
        echo "<p><small>[ <a href=\"javascript:hide_element('db_update')\">Hide this message</a> ]</small></p>\n";
        break;
        
    case 'ldap':
    
        // Parse input
        $host = clean_string($_POST['ldap_hostname']);
        $base_dn = clean_string($_POST['ldap_base_dn']);
        $admins = clean_string($_POST['ldap_admin_users']);
        $cn = clean_string($_POST['ldap_user_cn']);
        
        // Try to connect (NOTE this may not fail for OpenLDAP servers if not found - the fail will happen when ldap_* functions are called)
        if(!$conn = @ldap_connect($host)){
            echo "<p><strong>Cannot connect the LDAP server at '$host'.</strong></p>";
            exit();
        }
        
        // Use LDAPv3 if the checkbox says so
        if(strcmp($_POST['ldap_v3'],"on") == 0){
            ldap_set_option($conn, LDAP_OPT_PROTOCOL_VERSION, 3);
        }
        
        // Bind anonymously
        if(!$bind_anon = @ldap_bind($conn)){
            echo "<p><strong>Cannot bind anonymously to the LDAP server at '$host'.</strong></p><p>This could also be because the server could not be found, or that LDAP v3 should be used.</strong></p>";
            echo "<p><small>[ <a href=\"javascript:hide_element('ldap_update')\">Hide this message</a> ]</small></p>\n";
            exit();
        }
        
        // Pick an admin at random from the list
        $admins_array = explode(",",$admins);
        $picked_admin = $admins_array[rand(0,count($admins_array)-1)];
        //print_debug($admins_array);
        
        // Do the search for the picked admin, this validates the BASE DN, not the ADMIN
        if(!$search = @ldap_search($conn, $base_dn, "$cn=$picked_admin")){
            echo "<p><strong>Could not search for an admin user ('$picked_admin'). </strong></p><p>This could be because of an illegal Base DN.</strong></p>";
            echo "<p><small>[ <a href=\"javascript:hide_element('ldap_update')\">Hide this message</a> ]</small></p>\n";
            exit();        
        }
        
         // If there isn't only one row.   
        if(@ldap_count_entries($conn, $search) != 1) {
            echo "<p><strong>There was an error processing the username '$picked_admin', or it cannot be found.</p>";
            echo "<p><small>[ <a href=\"javascript:hide_element('ldap_update')\">Hide this message</a> ]</small></p>\n";
            exit();
        }

        // Validate the user and check that we got the one we wanted. Trivial, as the user should have matched the search, but this is validation!   
        $entries = @ldap_get_entries($conn, $search);
        if(array_search($picked_admin, $entries[0][$cn]) === NULL){
            echo "<p><strong>The username '$picked_admin', was not found in the LDAP server's search results.</strong></p>";
            echo "<p><small>[ <a href=\"javascript:hide_element('ldap_update')\">Hide this message</a> ]</small></p>\n";
            exit();
        }
        
        echo '<p>The LDAP server details have been validated successfully. <input type="hidden" name="ldap_valid" id="ldap_valid" value="1" /></p>';
        echo '<p><input type="button" name="ldap_save" id="ldap_save" value="Save Details" onclick="save(\'ldap\')" />';
        echo "<p><small>[ <a href=\"javascript:hide_element('ldap_update')\">Hide this message</a> ]</small></p>\n";
        
        break;
        
}

?>
