<?php

function custom_is_user_logged_in(WP_REST_Request $request) {
  $token = $request->get_header('auth-token');
  if (!$token) {
      return new WP_Error('rest_not_logged_in', 'Authentication token missing.', array('status' => 401));
  }

  $user_query = new WP_User_Query(array(
      'meta_key' => 'auth_token',
      'meta_value' => $token,
      'number' => 1,
  ));
  $users = $user_query->get_results();

  if (empty($users)) {
    return new WP_Error('rest_not_logged_in', 'Invalid authentication token.', array('status' => 401));
  }

  $user = $users[0];
  $stored_token = get_user_meta($user->ID, 'auth_token', true);
  $expiration = get_user_meta($user->ID, 'auth_token_expiration', true);

  if ($stored_token !== $token || time() > $expiration) {
      return new WP_Error('rest_not_logged_in', 'Authentication token expired.', array('status' => 401));
  }

  wp_set_current_user($user->ID);

  return true;
}
