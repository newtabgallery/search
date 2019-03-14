<?php
$title = "Blue Green Cubes";

// NewTabGallery: Edit these to change the rendered background images
$background_image_count = 2;
$background_image_style = "
<style>
  header.masthead.background-1 {
    background-image: url('https://home.newtabgallery.com/bluegreen/index.php')
  }

  header.masthead.background-2 {
    background-image: url('https://home.newtabgallery.com/bluegreen/cubes.png')
  }
</style>
";

include('../template/index.php');
?>