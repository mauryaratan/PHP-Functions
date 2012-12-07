<?php
/* Sanitize strings for security */
function clean($str){
    $str = @trim($str);
    if(get_magic_quotes_gpc()){
        $str = stripslashes($str);
    }
    return mysql_real_escape_string($str);
}

/* Convert new lines in <p> tags */
function nl2p($string, $line_breaks = true, $xml = true) {
    $string = str_replace(array('<p>', '</p>', '<br>', '<br />'), '', $string);

    // It is conceivable that people might still want single line-breaks
    // without breaking into a new paragraph.
    if ($line_breaks == true)
        return '<p>'.preg_replace(array("/([\n]{2,})/i", "/([^>])\n([^<])/i"), array("</p>\n<p>", '<br'.($xml == true ? ' /' : '').'>'), trim($string)).'</p>';
    else
        return '<p>'.preg_replace("/([\n]{1,})/i", "</p>\n<p>", trim($string)).'</p>';
}

/* Generate random 8 characters password/string */
function genPassword($length = 8){
    $validChars = "abcdefghijklmnopqrstuxyvwzABCDEFGHIJKLMNOPQRSTUXYVWZ1234567890";
    $validCharNumber = strlen($validChars);

    $result = '';

    for($i = 0; $i < $length; $i++){
        $index = mt_rand(0, $validCharNumber - 1);
        $result .= $validChars[$index];
    }
    return $result;
}

/* Convert URLs to links */
function urls_to_links($str){
    $pattern = '/((?:http|https)(?::\\/{2}[\\w]+)(?:[\\/|\\.]?)(?:[^\\s"]*))/is';
    $replace = '<a target="blank" href="$1">$1</a>';
    return preg_replace($pattern, $replace, $str);
}

/* Email Validation */
function is_valid_email($email, $test_mx = false){
    if(eregi("^([_a-z0-9-]+)(\.[_a-z0-9-]+)*@([a-z0-9-]+)(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email)){
        if($test_mx){
            list($username, $domain) = split("@", $email);
            return getmxrr($domain, $mxrecords);
        }else{
            return true;
        }
    }else{
        return false;
    }
}



?>