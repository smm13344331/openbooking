
    /** JAVASCRIPT -- Functions for resources **/

/** Function to create a category entry and update the categories drop-down list **/    
function create_category(update){

    // If the name is empty, display error. If not, create the category via AJAX
    if($F('category_name').empty()){
        alert('You have not entered a category name.');
    } else {
        ajax_form_submit('create_category','AJAX_update','admin.php?tab=resources&mode=create&ajax&cat',true, update, 'admin.php?tab=resources&cat&ajax');

    }
}

/** Function to toggle display of the category edit box **/
function show_update_category(update){

    if ($('resource_category') === null) { alert("There are no categories to update"); return;}
    
    id = $('resource_category').value;
    
    if(id != 0){
        url = 'admin.php?tab=resources&cat&ajax&mode=update&update=' + update + '&id=' + id;
        ajax_update('AJAX_update',url);
    } else {
        alert('You cannot edit this category.');
    }
}

/** Function to submit a catgeory edit **/
function update_category(update){
    if($F('category_name').empty()){
        alert('You have not entered a category name.');
    } else {
        ajax_form_submit('update_category','AJAX_update','admin.php?tab=resources&cat&ajax&mode=update',true,update,'admin.php?tab=resources&cat&ajax');
    }
}

/** Function to delete a category **/
function delete_category(update){

    if ($('resource_category') === null) { alert("There are no categories to delete"); return;}
    
    id = $('resource_category').value;
    
    if(id == 0){
        alert('You cannot delete this category');
        return;
    }
    
    // Cancel any updates if we're not in edit mode
    if(($('update_toggle').value != 0) & (update != "update_resource_category")){
        cancel_update();
    }
    
    // Now do the AJAX call
    ajax_update('AJAX_update','admin.php?tab=resources&mode=delete&cat&ajax&id=' + id + '&update=' + update);
}

/** Function to create a resource **/
function submitResource(mode,id){

    var empty = mode + '_resource_name';
    
    // If this is an update, cancel it now that it's done
    if(mode == "update"){
        url = 'admin.php?tab=resources&mode=update&ajax&res=' + id;
        form = 'update_resources';
    } else {
        url = 'admin.php?tab=resources&mode=create&ajax';
        form = 'create_resources';
    }

    // If there is no location drop-down box, display an error and return
    if($('parent') === null){
        alert('You have not created any locations. Please create locations and then create a resource.');
        return;
    }
    
    // If there is no category drop-down box, display an error and return
    if($('resource_category') === null){
        alert('You have not created any categories. Please create categories and then create a resource.');
        return;
    }
    
    // If the resource name is empty, display an alert and return	
    if($F(empty).empty()){
        alert('You have not entered a resource name');
        return;
    }
    
    ajax_form_submit(form, 'AJAX_update', url, true, 'resources_container',' admin.php?tab=resources&ajax');
    
    if(mode == "update"){
        cancel_update();
    }

}

/** Function to display the edit form for a resource **/
function toggle_edit(id){

    // Clear any highlights and set the updating flag
    $$('table#resources_table tr').invoke('removeClassName','highlight');

    
    // Take the content of the right panel and put it in "temp" - but only if there aren't any updates taking place
    if($('update_toggle').value == 0){
        $('temp').innerHTML = $('right_panel').innerHTML;
    }
    
    // Add the highlight class to the panel and row, then update the right panel with the edit form
    $('right_panel').addClassName('highlight');
    $('row_' + id).addClassName('highlight');
    ajax_update('right_panel','admin.php?tab=resources&mode=update&ajax&res=' + id);
    
    // Set toggle
    $('update_toggle').value = 1;

}

/** Function to toggle the deletion of a resource **/
function toggle_delete(id){

    // Clear all highlights
    $$('table#resources_table tr').invoke('removeClassName','highlight');

    // Add highlight
    $('row_' + id).addClassName('highlight');
    ajax_update('AJAX_update','admin.php?tab=resources&mode=delete&ajax&id=' + id);

}



/** Function  to cancel an active update **/
function cancel_update(){

    // Remove any highlights
    $$('table#resources_table tr').invoke('removeClassName','highlight');
    $('right_panel').removeClassName('highlight');
 
    // Refresh the categories list
    ajax_update('resource_category_dd','admin.php?tab=resources&cat&ajax');
    
    // Transfer temp back to right panel
    $('right_panel').innerHTML = $('temp').innerHTML;
 
    // Set the toggle to zero   
    $('update_toggle').value = 0;
}

