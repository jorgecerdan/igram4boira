<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>Instagram more button example</title>
  <!--
    Instagram PHP API class @ Github
    https://github.com/cosenary/Instagram-PHP-API
  -->
  <style>
    article, aside, figure, footer, header, hgroup, 
    menu, nav, section { display: block; }
    ul {
      width: 950px;
    }
    ul > li {
      float: left;
      list-style: none;
      padding: 4px;
    }
    #more {
      bottom: 8px;
      margin-left: 80px;
      position: fixed;
      font-size: 13px;
      font-weight: 700;
      line-height: 20px;
    }
  </style>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#more').click(function() {
        var tag   = $(this).data('tag'),
            maxid = $(this).data('maxid');

        $.ajax({
          type: 'GET',
          url: 'ajax.php',
          data: {
            tag: tag,
            max_id: maxid
          },
          dataType: 'json',
          cache: false,
          success: function(data) {
            // Output data
            $.each(data.images, function(i, src) {
              $('ul#photos').append('<li><img src="' + src + '"></li>');
            });

            // Store new maxid
            $('#more').data('maxid', data.next_id);
          }
        });
      });
    });
  </script>
</head>
<body>

<?php
  /**
   * Instagram PHP API
   */

   require_once 'instagram.class.php';

    // Initialize class with client_id
    // Register at http://instagram.com/developer/ and replace client_id with your own
    $instagram = new Instagram('0b747fb06d8f40368e335e99e8e3aab5');

    // Get latest photos according to geolocation for Växjö
    // $geo = $instagram->searchMedia(56.8770413, 14.8092744);

	$tag = $_GET['tagname'];

    // Get recently tagged media
    $media = $instagram->getTagMedia($tag);

    // Display first results in a <ul>
    echo '<ul id="photos">';

    foreach ($media->data as $data) 
    {
        echo '<li><img src="'.$data->images->thumbnail->url.'"></li>';
    }
    echo '</ul>';

    // Show 'load more' button
    echo '<br><button id="more" data-maxid="'.$media->pagination->next_max_id.'" data-tag="'.$tag.'">Load more ...</button>';
?>

</body>
</html>