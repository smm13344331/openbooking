
    /** JAVASCRIPT **/

function validate_field_limit(field_id,limit) {

    var val = document.getElementById(field_id).value;
    if ((val == null) || (val == "") || (val == '') || (val > limit)) {
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

