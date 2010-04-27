
    /** JAVASCRIPT -- Custom wrapper functions for the AJAX library **/
    
function ajax_update(update_id, update_url){
    var ajax = new Ajax.Updater(update_id, update_url, {method: 'get'});
    document.getElementById(update_id).style.display = 'block';
}

function ajax_form_submit(form_id, update_id, submit_url, after, after_update, after_url){

    // Generate the post text and do the query 
    var post = generate_post(form_id);
    var ajax = new Ajax.Updater(update_id, submit_url, {method: 'post', parameters: post, onSuccess: function() { ajax_update(after_update,after_url); $(after_update).style.display = 'none'; new Effect.BlindDown(after_update);} } );
    document.getElementById(update_id).style.display = 'block';
       
}
