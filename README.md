# search

Creating a new project

1. Go to https://github.com/newtabgallery/search
2. Click the "Branch master" dropdown button on the left.
3. Type the shortname of your new project (mexicanfood) and click Create.
4. Click "Create new File"
5. In the entry field, type the shortname of your new project /index.php (mexicanfood/index.php)
6. For the contents of the file, copy the php file located in /template/template-index.php and edit the background image values. The sample below has 1 relative images that will need uploaded and 1 image taken from an existing home tab page's previously uploaded assets.

```php
$background_image_count = 2;
$background_image_style = "
<style>
    header.masthead.background-1 {
      background-image: url('./image-1.jpg')
    }
    header.masthead.background-2 {
      background-image: url('https://home.newtabgallery.com/mexicanfood/sample-background.jpg')
    }
</style>
";
```

Be sure to update the value for `$background_image_count = 2;` to match the number of images that can display as this is used to randomly select the available assets. For example, if there are 5 `header.masthead.background-X` definitions here, set `$background_image_count = 5;`.
You can only use the relative ```background-image: url('./image-1.jpg')``` if the files are uploaded to the new project directory in this project (ex. search/mexicanfood/), otherwise use the `background-image: url('https://home.newtabgallery.com/HOME_PAGE_NAME/BACKGROUND_ASSET_FILE_NAME')` definition.

7. At the bottom of the page, click "Commit New file"
8. If needed, click "Upload Files" and upload all your images here (they must end in jpg or jpeg). Make sure they match the relative names set in step 6.
IMPORTANT - Make sure you are not on the master branch.
9. Click Commit changes
10. Click "Compare and pull request"
11. For the reviewer, select Tom or Mike.
12. Click "Create pull request"

Vigilink

The secret key and API key are set in environmental variables for nginx: /etc/nginx/snippets/fastcgi-php.conf