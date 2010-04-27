
    /** JAVASCRIPT **/
    
function update_resources(){

    var location = $('parent').value;
    ajax_update('resource_container','index.php?tab=refresh&mode=resource&ajax&loc=' + location);

}

function refresh_slot(){

    var location = $('parent').value;
    var resource = $('resource').value;
    var date = $('date').value;
    
    if (location == 0){
        alert("Please select a location.");
        return false;
    }
    
    if (resource == 0){
        alert("Please select a resource.");
        return false;
    }
      
    ajax_update('slot_container','index.php?tab=refresh&mode=slot&ajax&date=' + date + '&res=' + resource);
}

function create_booking(){

    var location = $('parent').value;
    var resource = $('resource').value;
    var date = $('dateVal').value;
    var slot = $('slot').value;
    
    if ((location == 0) || (location == null)){
        alert("Please select a location.");
        return false;
    }
    
    if ((resource == 0) || (resource == null)){
        alert("Please select a resource.");
        return false;
    }    
    
    if ((date == 0) || (date == null)){
        alert("Please select a date.");
        return false;
    } else {
        today = new Date();
      	today.setHours(0);
       	today.setMinutes(0);
       	today.setSeconds(0);
	    today.setMilliseconds(0);
       
        if(date < today.getTime()){
            alert("You cannot make bookings for dates in the past");
            return false;
        }
    }   
    
    if ((slot == 0) || (slot == null)){
        alert("Please select a slot.");
        return false;
    }
    
    ajax_form_submit('create_booking', 'AJAX_update', 'index.php?tab=bookings&mode=create&ajax', true, 'bookings_container', 'index.php?tab=bookings&ajax');
}

function toggle_delete(id){
    $$('table#bookings_table tr').invoke('removeClassName','highlight');
    $('row_' + id).addClassName('highlight');
    
    ajax_update('AJAX_update','index.php?tab=bookings&ajax&mode=delete&id=' + id);

}
