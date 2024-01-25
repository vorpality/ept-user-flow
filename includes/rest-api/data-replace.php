<?php
function ept_uf_rest_api_data_replace_handler($atts){

  $response['status']=1;
  if(
    !isset($atts['user_id']) || empty($params['user_id']) ||
    !isset($atts['user_old_password']) || empty($params['user_old_password']) ||
    !isset($atts['user_email']) || empty($params['user_email'])
  )
  {
    return $response;
  }
  $userID = $atts['user_id'];
  $user = get_user_by('id', $userID);
  $oldPw = $atts['user_old_password'];
  $email = $atts['user_email'];

  if(!wp_check_password($oldPass,$user->user_pass, $userID)){
    return $response;
  }
  if (isset($atts['user_new_password']) && !empty($atts['user_new_password'])){
    wp_set_password($_POST['new-password'],$user->user_login);    
    $response['status']=2;   
  }
  if(isset($atts['newsletter']) && $atts['newsletter']){
    delete_user_meta($userID, 'newsletter');
    add_user_meta($userID, 'newsletter');
    $response['status']=2;  
  }
  else{
    delete_user_meta($userID, 'newsletter');
    $response['status']=2;  
  }
  return $response;
}



