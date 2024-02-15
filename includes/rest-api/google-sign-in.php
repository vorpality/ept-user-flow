<?php
function ept_uf_google_signin_handler($request){

  $params = $request->get_params();
  $credential = $params['credential'];
  $csrf_token = $params['g_csrf_token'];
  $response['status'] = 1;
  $response['user_id'] = -1;
  $response['type'] = 'google';
  $google_client_id = '871559730084-mdf5uea60k4clraguvr76nd17c1517vr.apps.googleusercontent.com';
  $google_client_secret = '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';
  $redirect_uri = home_url();
  $client = new Google_Client();
  $client->setClientId($google_client_id);
  $client->setClientSecret($google_client_secret);
  $client->setRedirectUri($redirect_uri);
  $client->addScope("email");
  $client->addScope("profile");

  try {
    $payload = $client->verifyIdToken($credential);
    if ($payload) {
      $user_id = $payload['sub'];
      $user = get_user_by('email', $payload['email']);
      if (!$user) {
        $user_id = wp_create_user($payload['email'], wp_generate_password(), $payload['email']);
        if (is_wp_error($user_id)) {
          return $response;
        }
        update_user_meta($user_id, 'google_id', $google_user_info->id);
      }

      $response['user_id'] = $user->ID;
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