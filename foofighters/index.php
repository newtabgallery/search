<?php
$title = "Foo Fighters";

// NewTabGallery: Edit these to change the rendered background images
$background_image_count = 4;
$background_image_style = "
<style>
  header.masthead.background-1 {
    background-image: url('https://home.newtabgallery.com/foofighters/foofighters.jpg')
  }

  header.masthead.background-2 {
    background-image: url('https://home.newtabgallery.com/foofighters/foo-fighters-at-43rd-annual-grammy-awards.jpg')
  }

  header.masthead.background-3 {
    background-image: url('https://home.newtabgallery.com/foofighters/foo-fighters-hugomacedo-108002032.jpg')
  }

  header.masthead.background-4 {
    background-image: url('https://home.newtabgallery.com/foofighters/a181cd-20180122-foo-fighters.jpg')
  }
</style>
";

include('../_template/index.php');
?>