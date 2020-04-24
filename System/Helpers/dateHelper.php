<?php
function dateFormat($date = null) {
    # Converting date to USA standard
	if (strpos($date, "/")) {
	    $date = explode("/", $date);
		return $date[2] . "-" . $date[1] . "-" . $date[0];
	} 
    
    # Converting date to BR standard
    if (strpos($date, "-")) {
	    $date = explode("-", $date);
		return $date[2] . "/" . $date[1] . "/" . $date[0];
	}
}