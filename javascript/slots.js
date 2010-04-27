
    /** JAVASCRIPT -- Functions for slots **/

function toggle_edit(row_num) {

    // Clear highlights
    $$('table.#slotsTable td').invoke('removeClassName','highlight');

    // Declare an array of fields to toggle
    var fields = ["start","end","days","update"];
    
    // Loop through the array
    for (i = 0; i < fields.length; i++){
        
        // If the "hidden" field is hidden, mark it to display and vice versa
        if($("h_" + fields[i] + "_" + row_num).getStyle('display') == "none"){
        
        	var to_show = 'h_' + fields[i] + "_" + row_num;
        	var to_hide = 'd_' + fields[i] + "_" + row_num;
        	var toggle = true;
        } else {
			var to_hide = 'h_' + fields[i] + "_" + row_num;
		    var to_show = 'd_' + fields[i] + "_" + row_num;
		    var toggle = false;
		}
        
        // Do the hiding/showing as appropriate
        new Effect.BlindUp(to_hide, {duration: 0.6});
        new Effect.BlindDown(to_show, {duration: 0.6});
        if(toggle){
            $('row_' + row_num).addClassName('highlight');
        } else {
            $('row_' + row_num).removeClassName('highlight');
        }
    }

}

function save_edit(row_num) {

    // Normal form fields
    var fields = ["start_time_h", "start_time_m", "end_time_h", "end_time_m"];

    // Declare an empty string for POST text
    var post = "slot_id=" + row_num + "&";
    
    // Loop through the array
    for (i = 0; i < fields.length; i++){
        post += fields[i] + "=" + $(fields[i] + "_" + row_num).getValue() + "&";
    }
    
    // Get all checkboxes
    var checks = $$('#h_days_' + row_num + ' input[name="days[]"]');
    var num_checked = 0;
  
    for(i = 0; i < checks.length; i++){
        if (checks[i].checked) {
            post += "days[" + num_checked + "]=" + checks[i].getValue() + "&";
            num_checked++;
        }
    }
    
    post += "submit=submit";
    
    var ajax = new Ajax.Updater('AJAX_update',
                                'admin.php?tab=slots&mode=update&ajax',
                                { method: 'post',
                                  parameters: post,
                                  onSuccess: function() {
                                    var table = new Ajax.Updater(
                                                                'row_' + row_num,
                                                                'admin.php?tab=slots&ajax&row=' + row_num,
                                                                { method: 'get'});
                                    }
                                 });
    document.getElementById('AJAX_update').style.display = 'block';

}

function delete_row(row_num, start, end, days) {
    var confirmed = confirm("Please confirm that you would like to delete the slot running from " + start + " to " + end + " on " + days + ".\n\nNote that this will also delete any bookings associated with this slot.");
    
    if (!confirmed) {
        return;
    }
    
    
    post = "submit=submit&id=" + row_num + "&start=" + start + "&end=" + end + "&days=" + days;

    var del = new Ajax.Updater('AJAX_update',
                               'admin.php?tab=slots&mode=delete&ajax',
                                {  method: 'post',
                                   parameters: post,
                                   onSuccess: function() {
                                       var hide = new Effect.BlindUp("row_" + row_num, {duration: 0.6});
                                   }
                                });
                                
    document.getElementById('AJAX_update').style.display = 'block';
    
}

/** Validates the create-slot form **/
function slot_validate(){

    // Form elements
    var s_h = parseInt(document.getElementById("s_h").value);
    var s_m = parseInt(document.getElementById("s_m").value);
    var s_t = s_h + (s_m / 60);

    var e_h = parseInt(document.getElementById("e_h").value);
    var e_m = parseInt(document.getElementById("e_m").value);
    var e_t = e_h + (e_m / 60);

    // Calculate the number of checkboxes
    var days = $$('form#create input[name="days[]"]');
    var num_days = 0;
    for (i = 0; i < days.length; i++){
        if(days[i].checked) {
            num_days++;
        }
    }
    
    //alert(num_days + " of " + days.length);

    // Error variables
    var error = false; var errors = "";

        if(!validate_field_limit("s_h",24)) {
            error = true; errors += "The start-time hours field is invalid.\n";
        }

        if(!validate_field_limit("s_m",60)) {
            error = true; errors += "The start-time minutes field is invalid.\n";
        }

        if(!validate_field_limit("e_h",24)) {
            error = true; errors += "The end-time hours field is invalid.\n";
        }

        if(!validate_field_limit("e_m",60)) {
            error = true; errors += "The end-time minutes field is invalid.\n";
        }

        if (s_t > e_t) {
            error = true;
            errors += "The end time has to be after the start time.\n";
        }

        if(num_days == 0){
            error = true; errors += "You have not selected any days.\n";
        }


    if(error) {
        alert(errors);
        return false;
    } else {
        return true;
    }
}
