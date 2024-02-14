<?php
function checkregex($regex_arr, $str){
    /* checks array of regexes and sees 
     * if given string matches ANY of them */
    foreach ($regex_arr as $regex){
        if (preg_match($regex, $str) != 0){
            return TRUE;
        }
    }
    return FALSE;
}
