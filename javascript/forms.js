
    /** JAVASCRIPT **/

function validate_field_limit(field_id,limit) {

    var val = document.getElementById(field_id).value;
    if ((val == null) || (val == "") || (val == '') || (val > limit)) {
        return false;
    } else {
        return true;
    }  

}

/** Validates the create-slot form **/
function slot_validate(form){

    // Form elements
    var s_h = parseInt(document.getElementById("s_h").value);
    var s_m = parseInt(document.getElementById("s_m").value);
    var s_t = s_h + (s_m / 60);

    var e_h = parseInt(document.getElementById("e_h").value);
    var e_m = parseInt(document.getElementById("e_m").value);
    var e_t = e_h + (e_m / 60);

    // Calculate the number of checkboxes
    var days = document.getElementsByName("days[]");
    var num_days = 0;
    for (i = 0; i < days.length; i++){
        if(days[i].checked) {
            num_days++;
        }
    }
    

    // Error variables
    var error = false; var errors = "";

    //with(form) {

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
    //}

    if(error) {
        alert(errors);
        return false;
    } else {
        return true;
    }
}

/** Checks all elements of a given field **/
function check_all(field) {

    var array = document.getElementsByName(field + "[]");

    // Loop through elements
    for (i = 0;i < array.length; i++) {
        array[i].checked = true;
    }
}

/** Returns the POST text for a given form **/
function generate_post(formID){
    // Initialise some variables we'll use later on
    var form = document.getElementById(formID);
    var postText = "";
    var check = 0;
    
    // Loops through the form elements and builds the POST text
    for(i = 0; i < form.elements.length; i++){
        
        var elName = form.elements[i].name;
        var elValue = form.elements[i].value;
        
        // If the element is part of a checkbox array
        if (elName.substr(-2) == "[]"){
            
            // If the checkbox is checked
            if(form.elements[i].checked){
                var checkName = elName.substr(0,elName.length-2);
                postText += checkName + "[" + check + "]=" + elValue;
                check++;

                // If it's not the last element in the array, add the split operator
                if (i != form.elements.length - 1) {
                    postText += "&";
                }
            }

        } else {
            postText += elName + "=" + elValue;
            
            // If it's not the last element in the array, add the split operator
            if (i != form.elements.length - 1) {
                postText += "&";
            }
        }

    }
    
    return postText;
}

