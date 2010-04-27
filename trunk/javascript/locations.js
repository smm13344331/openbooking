
    /** JAVASCRIPT -- Functions for locations **/

/** Updates the parent drop-down after the type has been selected **/
function updateParent() {

    var type = $('type').value;
    
    if (type != 0) {
        var url = 'admin.php?tab=locations&type='+type+'&ajax';
        ajax_update('parentHolder', url);
    }
}

/** Validates the location create form **/
function validateForm() {

    var error = false; var errors = "";
    var loc_name = $('name').value;
    var type = $('type').value;
    var parent = $('parent').value;
    
    if ((loc_name == null) || (loc_name == "") || (loc_name == '')){
        error = true; errors += "Please enter a location name.\n";
    }
    
    if (type == 0) {
        error = true; errors += "Please choose a location type.\n";
    }
    
    if (error) {
        alert(errors);
        return false;
    }
    
    if ((parent == 0) && (type != 1)) {
        if(!confirm("Are you sure you want to create this location with no parent?")){
            return false;
        }
       
    }
    
    return true;

}

/** Shows the edit box for a given location **/
function showUpdate(id) {
    var url = 'admin.php?tab=locations&mode=update&loc=' + id + '&ajax';
    ajax_update('AJAX_update', url);
    $$('p.location').invoke('removeClassName','highlight');
    $('loc_' + id).addClassName('highlight');
}

function deleteLoc(id){
    var url = 'admin.php?tab=locations&mode=delete&id=' + id + '&ajax';
    ajax_update('AJAX_update', url);
    $$('p.location').invoke('removeClassName','highlight');
    $('loc_' + id).addClassName('highlight');
}

/** Hides child entries **/
function hideChildren(parent_id){
    var class_name = 'p.parent_' + parent_id;
    $$(class_name).invoke('hide');
    $('hide_' + parent_id).innerHTML = "+";
    $('hide_' + parent_id).writeAttribute("href","javascript:showChildren('" + parent_id + "')");

}

function showChildren(parent_id){
    var class_name = 'p.parent_' + parent_id;
    $$(class_name).invoke('show');
    $('hide_' + parent_id).innerHTML = "-";
    $('hide_' + parent_id).writeAttribute("href","javascript:hideChildren('" + parent_id + "')");
}
