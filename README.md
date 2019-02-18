# search

Creating a new project

1. Go to https://github.com/newtabgallery/search
2. Click the "Branch master" dropdown button on the left.
3. Type the shortname of your new project (mexicanfood) and click Create.
4. Click "Create new File"
5. In the entry field, type the shortname of your new project /index.html (mexicanfood/index.html)
6. For the contents of the file, copy the html file located in /template/index.html and edit the background image values:

```
<?php
  <style>
    /* NewTabGallery: Edit these to change the rendered background images */
    header.masthead.background-1 {
      background-image: url('./image-1.jpg')
    }
    header.masthead.background-2 {
      background-image: url('./image-2.jpg')
    }
    header.masthead.background-3 {
      background-image: url('./image-3.jpg')
    }
    header.masthead.background-4 {
      background-image: url('./image-4.jpg')
    }
    header.masthead.background-5 {
      background-image: url('./image-5.jpg')
    }
  </style>
```

7. At the bottom of the page, click "Commit New file"
8. Click "Upload Files"
9. Upload all your images here (they must end in jpg or jpeg).
IMPORTANT - Make sure you are not on the master branch.
10. Click Commit changes
11. Click "Compare and pull request"
12. For the reviewer, select Tom or Mike.
12. Click "Create pull request"
