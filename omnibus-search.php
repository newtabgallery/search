<?php
  if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
    header('Access-Control-Allow-Headers: token, Content-Type');
    header('Access-Control-Max-Age: 1728000');
    header('Content-Length: 0');
    header('Content-Type: text/plain');
    die();
  }

  require_once($_SERVER["DOCUMENT_ROOT"]."/search-utils.php");

  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  $qt = '';
  if (isset($_GET["q"]) && !empty($_GET["q"])) {
    $qt = $_GET["q"];
  }
  
  try {
    # Start GA request
    $ga_params = array(
        'v' => 1,
        'tid' => 'UA-127110494-2',
        'cid' => uniqid(),
        't' => 'pageview',
        'dh' => 'search.newtabgallery.com',
        'dp' => urlencode(utf8_encode("/omnibus-search.php?q=$qt")),
        'dt' => urlencode(utf8_encode("omnibus-search"))
    );
    $payload = http_build_query($ga_params);

    $ga_curl = curl_init();
    curl_setopt($ga_curl, CURLOPT_URL, 'https://www.google-analytics.com/collect');
    curl_setopt($ga_curl, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ga_curl, CURLOPT_RETURNTRANSFER, 1);
    $ga_response = curl_exec($ga_curl);
    curl_close($ga_curl);
  } catch (Exception $e) {
    error_log($e);
  }

  header("Location: https://www.my-search.com/search?q=$qt&zoneid=89128928");