<?php

echo '<pre>';
print_r($_SERVER);

// client ip
$_SERVER['REMOTE_ADDR'];

// server ip
$_SERVER['SERVER_ADDR'];

// client os + all broweses
$_SERVER['HTTP_USER_AGENT'];

// for where (what page) the client is hadding for
$_SERVER['REQUEST_URI'];

// in what method the request was send
$_SERVER['REQUEST_METHOD'];

// only the query string from url
$_SERVER['QUERY_STRING'];

// the server document root
$_SERVER['DOCUMENT_ROOT'];

// from where (site) the client came from
$_SERVER['HTTP_REFERER'];
