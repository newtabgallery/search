<?php
$title = "NASA Logo";

// NewTabGallery: Edit these to change the rendered background images
$background_image_count = 4;
$background_image_style = "
<style>
  header.masthead.background-1 {
    background-image: url('https://home.newtabgallery.com/nasalogo/hddw4lumtxgz.png')
  }

  header.masthead.background-2 {
    background-image: url('https://home.newtabgallery.com/nasalogo/MAIN.png')
  }

  header.masthead.background-3 {
    background-image: url('https://home.newtabgallery.com/nasalogo/0000.jpg')
  }

  header.masthead.background-4 {
    background-image: url('https://home.newtabgallery.com/nasalogo/logo-nasa-1975.jpg')
  }
</style>
";

include('../template/index.php');
?>