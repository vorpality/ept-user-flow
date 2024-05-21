<?php

function ept_uf_rest_api_signin_handler($request){
  $response = ['status' => 1];
  $params = $request->get_json_params();
  
  if(
      !isset($params['user_login'], $params['password']) ||
      empty($params['user_login']) ||
      empty($params['password'])
  )
  {
    $response['message'] = 'Please provide both username and password';
  }

  $email = sanitize_email($params['user_login']);
  $password = sanitize_text_field($params['password']);

  // Mobile login 

  if (isset($params['app']) && $params['app'] == 'true') {
    $username = get_user_by('email', $email)->user_login;
    $user = wp_authenticate($username, $password);

    if (is_wp_error($user)) {
        return new WP_Error('invalid_credentials', 'Invalid username or password.', array('status' => 403));
    }

    wp_set_current_user($user->ID);

      // Generate a token and set expiration time (15 days from now)
      $token = bin2hex(openssl_random_pseudo_bytes(16));
      $persist = (isset($params['remember']) && $params['app'] == 'true') ? (12 * 365) : 1 ; // persist a year if remember me is checked.
      $expiration = time() + (2 * 60 * 60 * $persist); // 2 hours in seconds or a year if remember me is activated.

  
      update_user_meta($user->ID, 'auth_token', $token);
      update_user_meta($user->ID, 'auth_token_expiration', $expiration);

    return rest_ensure_response(array(
        'status' => 200,
        'token' => $token,
        'message' => 'Login successful', 
        'user' => $user));
}


 // Normal login
  $user =  wp_signon([
      'user_login' => $email,
      'user_password' => $password,
      'remember' => true
  ]);
  

  if(is_wp_error($user)){
      return $user;
      return $response;
  }
  
  $response['status'] = 2;
  return $response;
}


