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

  $params = array(
    'partner' => 'demofeed',
    'qt' => $qt,
    'sub1' => "searchbox1",
    'v' => 7,
    'ip' => $_SERVER['REMOTE_ADDR'],
    'ua' => $_SERVER['HTTP_USER_AGENT'],
    'rfr' => $_SERVER['HTTP_REFERER'],
    'results' => 2,
    'web' => 1,
    'web-results' => 10,
    'out' => 'json',
  );

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, 'https://demofeed.ampfeed.com/xmlamp/feed?' . http_build_query($params));
  $response = curl_exec($ch);
  curl_close($ch);

  libxml_use_internal_errors(TRUE);
  $xml = simplexml_load_string($response);
  libxml_clear_errors();
  
  return json_encode($xml);
