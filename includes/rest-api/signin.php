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
        return $response;
    }

    $email = sanitize_email($params['user_login']);
    $password = sanitize_text_field($params['password']);
    
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

function ept_uf_google_signin_handler($request){
  $params = $request->get_params();
  $credential = $params['credential'];
  $csrf_token = $params['g_csrf_token'];
  $response['status'] = 1;
  // Proceed with your Google Client setup
  $google_client_id = '871559730084-mdf5uea60k4clraguvr76nd17c1517vr.apps.googleusercontent.com';
  $google_client_secret = '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';
  $redirect_uri = home_url();


  // Create Client Request to access Google API
  $client = new Google_Client();
  $client->setClientId($google_client_id);
  $client->setClientSecret($google_client_secret);
  $client->setRedirectUri($redirect_uri);
  $client->addScope("email");
  $client->addScope("profile");

  try {
    // Verify the ID token and get the user data
    $payload = $client->verifyIdToken($credential);
    //print_r($payload);
    //exit();
    if ($payload) {
      $user_id = $payload['sub'];
      // Perform user sign in or account creation in WordPress

      // Example: Check if the user exists in WordPress
      $user = get_user_by('email', $payload['email']);
      //echo $user->id;
      //exit();
      if (!$user) {
        $user_id = wp_create_user($payload['email'], wp_generate_password(), $payload['email']);

        if (is_wp_error($user_id)) {
          return $response;
        }

        // Update user meta with Google ID and set role
        update_user_meta($user_id, 'google_id', $google_user_info->id);
        $user = new WP_User($user_id);
      }

      // Log the user in
      wp_set_current_user($user->ID, $user->user_login);
      
      wp_set_auth_cookie($user->ID);

      do_action('wp_login', $user->user_login, $user);
      $response['status'] = 2;
      
    }
    else{
      return new WP_Error('invalid_token', 'Invalid ID token', array('status' => 401));
    }
    } 
    catch (Exception $e) {
      // Handle exception
      return new WP_Error('google_signin_error', $e->getMessage(), array('status' => 500));
    }
  return $response;
}


