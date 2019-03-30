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

  $qt = '';
  if (isset($_POST["qt"]) && !empty($_POST["qt"])) {
    $qt = $_POST["qt"];
  } else {
    return;
  }

  # Start vigilink request
  $vigilink_params = array(
    'apiKey' => getenv('VIGILINK_API_KEY'),
    'query' => $qt,
  );

  $vigilink_curl = curl_init();
  curl_setopt($vigilink_curl, CURLOPT_URL, 'https://rest.viglink.com/api/merchant/metadata?' . http_build_query($vigilink_params));
  curl_setopt($vigilink_curl, CURLOPT_HTTPHEADER, array('Authorization: secret ' . getenv('VIGILINK_SECRET_KEY')));
  curl_setopt($vigilink_curl, CURLOPT_RETURNTRANSFER, 1);
  $vigilink_response = curl_exec($vigilink_curl);
  curl_close($vigilink_curl);

  echo $vigilink_response;