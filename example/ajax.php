<?php
    /**
     * Instagram PHP API
     */

     require_once 'instagram.class.php';

      // Initialize class for public requests
      $instagram = new Instagram('0b747fb06d8f40368e335e99e8e3aab5');

      // Receive AJAX request and create call object
      $tag = $_GET['tag'];
      $maxID = $_GET['max_id'];
      $clientID = $instagram->getApiKey();

      $call = new stdClass;
      $call->pagination->next_max_id = $maxID;
      $call->pagination->next_url = "https://api.instagram.com/v1/tags/{$tag}/media/recent?client_id={$clientID}&max_tag_id={$maxID}";

      // Receive new data
      $media = $instagram->getTagMedia($tag,$auth=false,array('max_tag_id'=>$maxID));

      // Collect everything for json output
      $images = array();
      foreach ($media->data as $data) {
        $images[] = $data->images->thumbnail->url;
      }

      echo json_encode(array(
        'next_id' => $media->pagination->next_max_id,
        'images'  => $images
      ));
?>