<?php
function reconstruct_url($url){    
    $url_parts = parse_url($url);
    $constructed_url = $url_parts['scheme'] . '://' . $url_parts['host'] . (isset($url_parts['path'])?$url_parts['path']:'');

    return $constructed_url;
}


$test = array(
    'http://www.mydomian.com/myurl.html?unwan=abc',
    'http://www.mydomian.com/myurl.html',
    'http://www.mydomian.com',
    'https://mydomian.com/myurl.html?unwan=abc&ab=1'
);

foreach($test as $url){
    print_r(parse_url($url));
}   
?>