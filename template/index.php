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

  $qt = '';
  if (isset($_POST["q"]) && !empty($_POST["q"])) {
    $qt = $_POST["q"];
  } else {
    return;
  }

  $ad_marketplace_params = array(
    'partner' => 'brandthunder_tiles',
    'qt' => $qt,
    'sub1' => '10004',
    'sub2' => 'newtabgallery',
    'v' => 1.2,
    'ip' => get_client_ip_server(),
    'ua' => $_SERVER['HTTP_USER_AGENT'],
    'rfr' => $_SERVER['HTTP_REFERER'],
    'results' => 20,
    'out' => 'json',
  );

  $ad_marketplace_response = file_get_contents('https://brandthunder_tiles.tiles.ampfeed.com/tiles?' . http_build_query($ad_marketplace_params));
  $ad_marketplace_json = json_decode($ad_marketplace_response, true);

  $tiles = $ad_marketplace_json["tiles"];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title><?php echo $title; ?></title>

  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <!-- Custom fonts for this template -->
  <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="../assets/vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template -->
  <link href="../assets/css/landing-page.min.css" rel="stylesheet">
</head>

<?php echo $background_image_style; ?>

<body>
  <!-- Masthead -->
  <header class="masthead text-white text-center">
    <div class="overlay">
    </div>
    <div class="container">
      <div class="row">
        <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
          <form id="search-form">
            <div class="form-row">
              <div class="col-12 col-md-9 mb-2 mb-md-0">
                <input id="search-input" type="search" class="form-control form-control-lg" placeholder="Search">
              </div>
              <div class="col-12 col-md-3">
                <button id="search-submit" type="submit" class="btn btn-block btn-lg btn-primary">
                  <i class="fas fa-search">
                  </i>
                </button>
              </div>
              <div class="icon-row col-12">
                <?php generate_search_tiles($tiles); ?>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </header>

  <!-- Results -->
  <div class="container">
    <div id="web-listings" class="results"></div>
  </div>

  <!-- Footer -->
  <footer class="footer bg-light">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 h-100 text-center text-lg-left my-auto">
          <ul class="list-inline mb-2">
          </ul>
          <p class="text-muted small mb-4 mb-lg-0">&copy; NewTabGallery 2019. All Rights Reserved.</p>
        </div>
      </div>
    </div>
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="../assets/vendor/js/main.min.js"></script>
</body>
</html>
