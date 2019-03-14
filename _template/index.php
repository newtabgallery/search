<?php
  require_once($_SERVER["DOCUMENT_ROOT"]."/search-utils.php");

  $qt = '';
  if (isset($_GET["q"]) && !empty($_GET["q"])) {
    $qt = $_GET["q"];
  }

  $ad_marketplace_partner = 'brandthunder_serp';
  $ad_marketplace_params = array(
    'partner' => $ad_marketplace_partner, 
    'qt' => $qt,
    'sub1' => 'serp',
    'sub2' => 'newtabgallery',
    'v' => '1.2',
    'ip' => get_client_ip_server(),
    'ua' => $_SERVER['HTTP_USER_AGENT'],
    'rfr' => $_SERVER['HTTP_REFERER']
  );
  $ad_marketplace_response = file_get_contents('https://' . $ad_marketplace_partner . '.tiles.ampfeed.com/tiles?' . http_build_query($ad_marketplace_params));
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
  <link href="../_assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="../_assets/vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template -->
  <link href="../_assets/css/landing-page.min.css?v=<?php echo filemtime('../_assets/css/landing-page.min.css'); ?>" rel="stylesheet">
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
  <script>window.NEWTABGALLERY_BACKGROUND_COUNT = <?php echo $background_image_count; ?>;</script>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="../_assets/vendor/js/main.min.js?v=<?php echo filemtime('../_assets/vendor/js/main.min.js'); ?>"></script>
</body>
</html>
