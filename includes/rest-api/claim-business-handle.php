<?php
function ept_uf_rest_api_claim_business_handler($atts){
  
  $params = $atts->get_json_params();
  $response['status'] = 1;
  if(
    !isset($atts['user_id']) || empty($params['user_id']) ||
    !isset($atts['business_id']) || empty($params['business_id'])
  )
  {
    return $response;
  }
  global $wpdb;
  $userID = (int) $params['user_id'];
  $businessID = (int) $params['business_id'];

  $table_name = $wpdb->prefix . 'bar_owners';
  $current_owner = $wpdb->get_var($wpdb->prepare("SELECT user_id FROM $table_name WHERE post_id = %d AND user_id IS NOT NULL", $businessID));

  if (!empty($current_owner)) {
      return new WP_Error('business_already_claimed', __('This business is already claimed.', 'e-potis'), array('status' => 403));
  }

  $result = $wpdb->update(
    $table_name,
    ['user_id' => $userID],
    ['post_id' => $businessID, 'user_id' => NULL], 
    ['%d'], 
    ['%d', '%d'] 
  );

  if (false === $result) {
      $response['message'] = __('Failed to claim the business. Please try again later.', 'e-potis');
      return new WP_REST_Response($response, 500);
  }
  update_user_meta($userID, 'owner', 1);

  $response['status'] = 2;

  return $response;
}



