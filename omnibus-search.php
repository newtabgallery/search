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
  if (isset($_GET["q"]) && !empty($_GET["q"])) {
    $qt = $_GET["q"];
  }

  header("Location: https://www.my-search.com/search?q=$qt&zoneid=89128928");