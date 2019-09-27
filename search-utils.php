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
    echo '<a href="http://redirect.viglink.com?key=' . getenv('VIGILINK_API_KEY') . '&u=http%3A%2F%2Fwww.walmart.com "><img class="tile" height="50" width="50" alt="Walmart" title="Walmart" src="https://home.newtabgallery.com/global/images/walmart.png"></a>';
    echo '<a href="http://redirect.viglink.com?key=' . getenv('VIGILINK_API_KEY') . '&u=http%3A%2F%2Fwww.parachutehome.com"><img class="tile" height="50" width="50" alt="Parachute Home" title="Parachute Home" src="https://home.newtabgallery.com/global/images/parachute.png"></a>';
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
      $count = min(sizeof($tiles), 8);

      $rand_keys = [0];
      if ($count > 1) {
        $rand_keys = array_rand($tiles, $count);
      }

      for ($i = 0; $i < $count; $i++) {
        $tile = $tiles[$rand_keys[$i]];
        if (!is_object($tile)) {
          continue;
        }
        if ($tile->{'name'} != "Amazon" &&
          $tile->{'name'} != "Samsung - Performics") {
          outputTile($tile);
        }
      }
    }
  }

  function get_client_referrer() {
    $client_referrer = '';
    if (array_key_exists('HTTP_REFERER', $_SERVER))
        $client_referrer = $_SERVER['HTTP_REFERER'];
    else
        $client_referrer = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
    return $client_referrer;
  }
