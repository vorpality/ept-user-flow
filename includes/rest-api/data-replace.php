<?php
function ept_uf_rest_api_data_replace_handler($atts){
  $params = $atts->get_json_params();
  $response['input']=$params;
  $response['status']=1;
  if(
    !isset($atts['user_id']) || empty($params['user_id']) ||
    !isset($atts['user_old_password']) || empty($params['user_old_password']) ||
    !isset($atts['user_email']) || empty($params['user_email'])
  )
  {
    $response['message'] = 'failed 1st check';
    return $response;
  }
  $userID = $atts['user_id'];
  $user = get_user_by('id', $userID);
  $isGoogleUser = get_user_meta($user, 'google_id') == '' ? false : true;
  if (!$isGoogleUser){
    $oldPass = $atts['user_old_password'];
    if(!wp_check_password($oldPass,$user->user_pass, $userID)){
      $response['data'] = [$oldPass,$user->user_pass, $userID];
      $response['message'] = 'failed password check';
      return $response;
    }
  }
  
  $email = $atts['user_email'];
  if (isset($atts['user_new_password']) && !empty($atts['user_new_password'])){
    wp_set_password($_POST['new-password'],$user->user_login);    
    $response['status']=2;   
  }

 
  if(isset($atts['user_newsletter']) && $atts['user_newsletter'] == 'on'){
    delete_user_meta($userID, 'newsletter');
    add_user_meta($userID, 'newsletter', true);
    $response['status']=2;  
  }
  else{
    delete_user_meta($userID, 'newsletter');
    $response['status']=2;  
  }
  return $response;
}



