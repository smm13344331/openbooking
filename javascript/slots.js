
    /** JAVASCRIPT -- Functions to edit slots **/

function toggle_edit(row_num) {

    // Declare an array of fields to toggle
    var fields = ["start","end","days","update"];
    
    // Loop through the array
    for (i = 0; i < fields.length; i++){
        
        // If the "hidden" field is hidden, mark it to display and vice versa
        if($("h_" + fields[i] + "_" + row_num).getStyle('display') == "none"){
        
        	var to_show = 'h_' + fields[i] + "_" + row_num;
        	var to_hide = 'd_' + fields[i] + "_" + row_num;
        } else {
			var to_hide = 'h_' + fields[i] + "_" + row_num;
		    var to_show = 'd_' + fields[i] + "_" + row_num;
		}
        
        // Do the hiding/showing as appropriate
        new Effect.BlindUp(to_hide, {duration: 0.6});
        new Effect.BlindDown(to_show, {duration: 0.6});
        
        
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
                                'slots.php?mode=update&ajax',
                                { method: 'post',
                                  parameters: post,
                                  onSuccess: function() {
                                    var table = new Ajax.Updater(
                                                                'row_' + row_num,
                                                                'slots.php?ajax&row=' + row_num,
                                                                { method: 'get'});
                                    }
                                 });
    document.getElementById('AJAX_update').style.display = 'block';
    $('row_' + row_num).addClassName('highlight');  

}

function delete_row(row_num, start, end, days) {
    var confirmed = confirm("Please confirm that you would like to delete the slot running from " + start + " to " + end + " on " + days + ".\n\nNote that this will also delete any bookings associated with this slot.");
    
    if (confirmed) {
    
        post = "submit=submit&id=" + row_num + "&start=" + start + "&end=" + end + "&days=" + days;

        var del = new Ajax.Updater('AJAX_update',
                                    'slots.php?mode=delete&ajax',
                                    { method: 'post',
                                      parameters: post,
                                      onSuccess: function() {
                                        var hide = new Effect.BlindUp("row_" + row_num, {duration: 0.6});
                                        }
                                     });

    }
    document.getElementById('AJAX_update').style.display = 'block';
    
}
