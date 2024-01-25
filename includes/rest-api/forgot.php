<?php

function ept_uf_rest_api_forgot_handler($request){
    $response = ['status' => 1];
    $params = $request->get_json_params();
    if(
        !isset($params['email']) || empty($params['email'])
       
    )
    {
      return $response;
    }

    $email = sanitize_email($params['email']);
  
    if (!email_exists($email)){
      return $email;
    }
    $user =  get_user_by('email', $email);
    /*
    $msg = ("Hello, ".$user->user_login. "\nYour current password is " . $user->user_pass);
    $msg = wordwrap($msg,70);

    $success = wp_mail($email, 'Password recovery', $msg);
    */

    $success = retrieve_password($user->user_login);

    if (!$success){
      $response = ['status' => 3];
      return $response;
    }
    $response['status'] = 2;
    return $response;
}