<?php
$url = "http://google.com/sdfsdfdsfsdf";

$headers = get_headers($url);

if (!$headers) {

    //means the url is completely invalid, host not found
    //means tell user his url is not valid, return with errors
}

///but if we get here, that means the url was found, we still need to see if the response code is 404 or not

$responseText = $headers[0];

if (strpos($responseText, '404')) {
    //404 was found in the response text//
} else {
    //here means 404 was NOT found in the response text
}

//\Illuminate\Support\Str::contains($responseText, '404');