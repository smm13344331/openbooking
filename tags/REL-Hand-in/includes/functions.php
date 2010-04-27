<?php
/*
 * $Id: functions.php 16 2010-03-09 10:24:59Z maidenfan $
 * Copyright (c) 2010 Craig Watson [ craig@cwatson.org ]
 * Distributed Under the Mozilla Public License 1.1 [ http://www.mozilla.org/MPL/MPL-1.1.html ]
 */

if (!defined('IN_OB')){
	exit;
}

/* Creates a binary string from an array of day values with a MTWTFSS order.
 * Params:  $array - The array of days to be parsed.
 * Returns: The finished 7-character binary string.
 */
function day_hash($array) {
    
    // Include the global array of searchable days, and create a blank hash
    global $days_short; $hash = "";

    // Loop through days, checking against the passed array
    foreach ($days_short as $day) {
        (in_array($day,$array)) ? $hash .= "1" : $hash .= "0";
    }

    // Return the finished hash
    return $hash;
}

/* Checks for an overlap between two times.
 * Params: $time1 and $time2 - The times to compare in HH:MM:SS format
 * Returns: TRUE if there is an overlap, FALSE otherwise.
 */
function check_overlap($time1_start, $time1_end, $time2_start, $time2_end){

    if ((($time1_start >= $time2_start) && ($time1_start < $time2_end)) || (($time1_end > $time2_start) && ($time1_end <= $time2_end))) {
	    return TRUE;
	} else {
		return FALSE;
	}
}

/* Converts a MTWTFSS format days hash to a printable text string.
 * Params: $time1 and $time2 - The times to compare in HH:MM:SS format
 * Returns: A string version of the hash
 */
function days_hash_to_text($hash){

    global $days_long;
    
    $hash_array = str_split($hash);
    $text = "";
    
    // Loop through the hash, adding days to the array when found
    for($i = 0; $i < count($days_long); $i++) {
    
        if ($hash_array[$i] == 1) {
            $return_array[] = $days_long[$i];                        
        }
    }

    // Implode the array back to a string
    $text = implode(", ",$return_array);
    
    // If more than one day in the array, replce the last comma with "and"
    if (count($return_array) > 1) {
        $text = preg_replace('#,(?![^,]+,)#',' and',$text); 
    }
    
    return $text;
}

function days_hash_to_text_short($hash) {

    global $days_letters;
    
    $hash_array = str_split($hash);
    $text = "";
    
    for ($i = 0; $i < count($days_letters); $i++) {
    
        $text .= "<span";
        
        if ($hash_array[$i] != 1) {
            $text .= " class=\"faded\"";
        }
        
        $text .= ">" . $days_letters[$i] . "</span>&nbsp;&nbsp;";
        
    }
    
    return $text;     
}

/* Creates an XHTML checkbox table from a days hash */
function days_hash_to_form($hash,$days,$days_vals){

    $table = "<table class=\"days_form\">\n\t<tr>\n";
    $hash_array = str_split($hash);
    
    // Output the header row
    foreach ($days as $day){
        $table .= "\t<th>$day</th>\n";
   }
   
   // Now start the days row
   $table .= "</tr><tr>\n";
   
   for($i = 0; $i < count($hash_array); $i++) {
        $table .= "\t<td><input type=\"checkbox\" name=\"days[]\" value=\"" . $days_vals[$i] . '"';

        if ($hash_array[$i] == 1)
            $table .= " checked=\"checked\"";

        $table .= " /></td>\n";
   }

    // Finish the row and the table
    $table .= "</tr>\n</table>\n";
    return $table;

}

/* Displays an error message. */
function display_error($text,$fatal = FALSE){

    global $root_path;

    echo "<p class=\"error\">Error: $text</p>\n";
    if($fatal) {
        require_once $root_path . 'style/templates/page-footer.html';
        exit();
   }

}

/* Loops through an array of files, including each */
function template_parse($files) {

    global $template, $root_path;

    foreach ($files as $file) {
        require_once $root_path . "style/templates/$file";
    }
}

/** Simple function to encapsulate cleaning of strings **/
function clean_string($string){
    return trim(addslashes(htmlspecialchars($string)));
}

?>
