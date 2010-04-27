<?php
/*
 * $Id$
 * Copyright (c) 2010 Craig Watson [ craig@cwatson.org ]
 * Distributed Under the Mozilla Public License 1.1 [ http://www.mozilla.org/MPL/MPL-1.1.html ]
 */

if (!defined('IN_OB')){
	exit;
}

/* ldap_authenticate - authenticates a user with the LDAP server
 * Param: $user			username to authenticate
 * Param: $pass			password to authenticate
 */
function ldap_authenticate($user,$pass) {

    // Global variables
	global $ldap_base_DN, $ldap_server, $template, $admin_users, $ldap_user_cn;

    // Connect to the LDAP server
	$conn = ldap_connect($ldap_server) or die ("Cannot connect");
	ldap_set_option($conn, LDAP_OPT_PROTOCOL_VERSION, 3);

    // Bind anonymously, query the server for the user, and error if it can't be found
    if(!$bind = ldap_bind($conn)){
        $template['message'] = "<p>Anonymous bind failed.</p>";
        return;
    }
    
    // Do a search for the username and get the DN - this is easier than manually constructing it
    if(!$search = ldap_search($conn,$ldap_base_DN, "$ldap_user_cn=$user")){
        $template['message'] = "<p><strong>Error:</strong> Could not find the username.</p>";
        return;
    }
    
    // If there isn't only one row.   
    if(ldap_count_entries($conn, $search) != 1) {
        $template['message'] = "<p>There was an error processing the username, or it cannot be found.</p>";
        return;
    }
    
    // Extract the entries, and bind with the user's full DN, then unset the password for security
    $entries = @ldap_get_entries($conn, $search);
    $bind_auth = @ldap_bind($conn, $entries[0]['dn'], $pass);
    unset($pass);

    // If we have a successful bind, add the relevant session information
    if ($bind_auth){
        $_SESSION['admin'] = in_array($user, $admin_users);
        $_SESSION['username'] = $user;
        header('Location: index.php');
    } else {
        $template['message'] = "<p><strong>Login failed.</strong> Please try again.</p>";
    }
   
}

?>
