# search

Creating a new project

1. Go to https://github.com/newtabgallery/search
2. Click the "Branch master" dropdown button on the left.
3. Type the shortname of your new project (mexicanfood) and click Create.
4. Click "Create new File"
5. In the entry field, type the shortname of your new project /index.php (mexicanfood/index.php)
6. For the contents of the file, copy the php file located in /template/template-index.php and edit the background image values.

```php
$background_image_style = "
<style>
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
";
```
You can use the relative ```background-image: url('./image-1.jpg')``` if the files are uploaded to the new project directory (ex. mexicanfood/):

7. At the bottom of the page, click "Commit New file"
8. Click "Upload Files"
9. Upload all your images here (they must end in jpg or jpeg). Make sure they match the names set in step 6.
IMPORTANT - Make sure you are not on the master branch.
10. Click Commit changes
11. Click "Compare and pull request"
12. For the reviewer, select Tom or Mike.
12. Click "Create pull request"

Vigilink

The secret key and API key are set in environmental variables for nginx: /etc/nginx/snippets/fastcgi-php.conf