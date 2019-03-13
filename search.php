<?php
  // Function to get the client ip address
  function get_client_ip_server() {
    $ipaddress = '';
    if (array_key_exists('HTTP_CLIENT_IP', $_SERVER))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if (array_key_exists('HTTP_X_FORWARDED', $_SERVER))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if (array_key_exists('HTTP_FORWARDED_FOR', $_SERVER))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if (array_key_exists('HTTP_FORWARDED', $_SERVER))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if (array_key_exists('REMOTE_ADDR', $_SERVER))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    // for testing
    if ($ipaddress == '127.0.0.1') {
      $ipaddress = '104.54.208.204';
    }
    return $ipaddress;
  }

  function generate_search_tiles($tiles) {
    if (isset($tiles)) {
        function outputTile($tile) {
            if ($tile["image_url"]) {
              echo '<a href="'.$tile['click_url'].'"><img class="tile" height="50" width="50" alt="'.$tile["name"].'" title="'.$tile["name"].'" src="'.$tile["image_url"].'"></a>';
              echo '<img src="'.$tile["impression_url"].'">';
            }
        }
        $stickyArray = array_filter(
            $tiles,
            function ($e) {
                return ($e["name"] == "Amazon" || $e["name"] == "Samsung - Performics");
            }
        );
        function my_sort($a,$b)
        {
            if ($a["name"] == $b["name"]) return 0;
            return ($a["name"] < $b["name"]) ? -1 : 1;
        }
        usort($stickyArray, 'my_sort');
        foreach ($stickyArray as $tile) {
          outputTile($tile);
        }
        echo '<a href="http://redirect.viglink.com?key=8860b76d9d55e5e067640b5beb7354ca&u=http%3A%2F%2Fwww.walmart.com "><img class="tile" height="50" width="50" alt="Walmart" title="Walmart" src="https://home.newtabgallery.com/global/images/walmart.png"></a>';
        echo '<a href="http://redirect.viglink.com?key=8860b76d9d55e5e067640b5beb7354ca&u=http%3A%2F%2Fwww.parachutehome.com"><img class="tile" height="50" width="50" alt="Parachute Home" title="Parachute Home" src="https://home.newtabgallery.com/global/images/parachute.png"></a>';
        $count = min(sizeof($tiles), 8);
        $rand_keys = array_rand($tiles, $count);
        for ($i = 0; $i < $count; $i++) {
          $tile = $tiles[$rand_keys[$i]];
          if ($tile["name"] != "Amazon" && $tile["name"] != "Samsung - Performics") {
            outputTile($tile);
          }
        }
    }    
  }

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
    'ip' => get_client_ip_address(),
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
