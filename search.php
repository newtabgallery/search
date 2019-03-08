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

  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");

  $qt = '';
  if (isset($_POST["qt"]) && !empty($_POST["qt"])) {
    $qt = $_POST["qt"];
  } else {
    return;
  }

  $ad_marketplace_params = array(
    'partner' => 'brandthunder_serp',
    'qt' => $qt,
    'sub1' => 'serp',
    'sub2' => 'newtabgallery',
    'v' => 7,
    'ip' => $_SERVER['REMOTE_ADDR'],
    'ua' => $_SERVER['HTTP_USER_AGENT'],
    'rfr' => $_SERVER['HTTP_REFERER'],
    'results' => 6,
    'web' => 1,
    'web-results' => 15,
    'out' => 'json',
  );

  $ad_marketplace_curl = curl_init();
  curl_setopt($ad_marketplace_curl, CURLOPT_URL, 'https://brandthunder_serp.ampfeed.com/xmlamp/feed?' . http_build_query($ad_marketplace_params));
  $ad_marketplace_response = curl_exec($ad_marketplace_curl);
  curl_close($ad_marketplace_curl);
