<?php
<?php
function checkregex($regex_arr, $str, $count = 0){
    /* checks array of regexes 

     * usage: 
     * $str       -> string to be checked
     * $regex_arr -> array of regexes for $str to be checked against
     * $count     -> OPTIONAL. if not specified, 
     *               assume true on first hit (i.e. count == 0) 
     * 
     * https://www.php.net/manual/en/functions.arguments.php */
    foreach ($regex_arr as $regex){
        if (preg_match_all($regex, $str) > $count){
            return TRUE;
        }
    }
    return FALSE;
}
