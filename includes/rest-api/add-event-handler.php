<?php
function ept_uf_rest_api_add_event_handler($request){
  require_once( ABSPATH . 'wp-admin/includes/image.php' );
  require_once( ABSPATH . 'wp-admin/includes/file.php' );
  require_once( ABSPATH . 'wp-admin/includes/media.php' );

  $file_handler = 'event_image';
  $attach_ids = [];
  if (!empty($_FILES['event_images']['name'][0])) { // Check if at least one file was uploaded
    $files = $_FILES['event_images'];
    for ($i = 0; $i < count($files['name']); $i++) {
      foreach (array_keys($files) as $key) {
          $_FILES['event_image_single'][$key] = $files[$key][$i];
      }
      $attach_id = media_handle_upload('event_image_single', 0);
      if (!is_wp_error($attach_id)) {
          $attach_ids[] = $attach_id;
      }
    }
  }
  unset($_FILES['event_image_single']);

  if (is_wp_error($attach_ids)) {
    $response['message'] = 'File upload failed: ' . $attach_id->get_error_message();
    return new WP_REST_Response($response, 500);
  }

  $response['status']=1;
  if(
    $request->get_param('user_id') == null ||
    $request->get_param('event_title') == null ||
    $request->get_param('event_location') == null
  )
  {
    $response['message'] = 'failed initial check';
    return $response;
  }
  $userID = $request->get_param('user_id');
  $user = get_user_by('id', $userID);

  $title = $request->get_param('event_title');
  $description = '';
  $place_id = $request->get_param('event_location');

  if ($request->get_param('event_description') != null){
    $description = $request->get_param('event_description');
  }
 
  $event_post = array(
    'post_author' => $userID,
    'post_title' => $title,
    'post_content' => $description,
    'post_excerpt' => $description,
    'post_status' => 'publish',
    'post_type' => 'event',
    'meta_input' => array(
      'event_location' => $place_id,
    ),
  );

  $post_id = wp_insert_post($event_post);

  if ($post_id == 0) {
    $response['message'] = 'Failed to create event.';
    return new WP_REST_Response($response, 500);
  }
  if (!empty($attach_ids)) {
    set_post_thumbnail($post_id, $attach_ids[0]);
    delete_post_meta($post_id, 'custom_images');
    foreach($attach_ids as $attach_id){
      add_post_meta($post_id, 'custom_images', $attach_id);
    }
    update_post_meta($post_id, 'primary-image', $attach_ids[0]);
  }
  $response['url']= get_the_permalink($post_id);
  $response['status'] = 2;
  return $response;
}



