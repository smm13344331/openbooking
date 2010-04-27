
    /** JAVASCRIPT **/
    
function test_db() {

    var hostname = $('db_hostname').value;
    var database = $('db_name').value;
    var username = $('db_username').value;
    var password = $('db_password').value;
    var prefix = $('db_table_prefix').value;            

    if ((hostname == "") || (hostname == null)){
        alert("Please enter a hostname.");
        return false;
    }
    
    if ((database == "") || (database == null)){
        alert("Please enter a database name.");
        return false;
    }

    if ((username == "") || (username == null)){
        alert("Please enter a username.");
        return false;
    }

    if ((password == "") || (password == null)){
        alert("Please enter a password.");
        return false;
    }

    if ((prefix == "") || (prefix == null)){
        alert("Please enter a table prefix.");
        return false;
    }
    
    post = $('install').serialize();
    //alert(post);
    new Ajax.Updater('db_update', 'index.php?tab=test&form=db&ajax', {method: 'post', parameters: post } );
    document.getElementById('db_update').style.display = 'block';

}

function save(section) {

    var valid = $(section + '_valid').value;
    
    if(valid == 1){
        var section_elements = $$('fieldset#' + section + ' input');
        //section_elements.invoke('disable');
        section_elements.invoke('writeAttribute','readonly','readonly');
        $(section).addClassName('validated');
        hide_element(section + '_update');
    } else {
        alert("You can only save valid data. Please test the data again.");
        $(section).addClassName('invalid');
    }

}

function test_ldap() {

    var hostname = $('ldap_hostname').value;
    var base_dn = $('ldap_base_dn').value;
    var admins = $('ldap_admin_users').value;
    var user_cn = $('ldap_user_cn').value;    
    
    if ((hostname == "") || (hostname == null)){
        alert("Please enter a hostname.");
        return false;
    }
    
    if ((base_dn == "") || (base_dn == null)){
        alert("Please enter a base DN.");
        return false;
    }

    if ((admins == "") || (admins == null)){
        alert("Please enter a username for an administrative user.");
        return false;
    }

    if ((user_cn == "") || (user_cn == null)){
        alert("Please enter a CN to identify users.");
        return false;
    }

    post = $('install').serialize();
    //alert(post);
    new Ajax.Updater('ldap_update', 'index.php?tab=test&form=ldap&ajax', {method: 'post', parameters: post } );
    document.getElementById('ldap_update').style.display = 'block';
    
}

function check() {

    var db_check = $('db_valid');
    var ldap_check = $('ldap_valid');

    if ((db_check == null) || (db_check.value == 0)){
        alert("Please validate your Database details.");
        return false;
    } 
      
    if ((ldap_check == null) || (ldap_check.value == 0)){
        alert("Please validate your LDAP details.");
        return false;
    }
      
}
