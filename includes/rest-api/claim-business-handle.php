<?php
function ept_uf_rest_api_claim_business_handler($atts){

  $params = $atts->get_json_params();
  $response['status'] = 1;
  if(
    !isset($atts['user_id']) || empty($params['user_id']) ||
    !isset($atts['place_id']) || empty($params['place_id'])
  )
  {
    return $response;
  }

  $userID = $atts['user_id'];
  $placeID = $atts['place_id'];

  $current_owner = get_post_meta($placeID, 'current_owner', true);
  if (!empty($current_owner)) {
      return new WP_Error('business_already_claimed', __('This business is already claimed.', 'e-potis'), array('status' => 403));
  }

  update_post_meta($placeID, 'current_owner', $userID);
  update_user_meta($userID, 'owner', 1);
  $response['status'] = 2;

  return $response;
}



