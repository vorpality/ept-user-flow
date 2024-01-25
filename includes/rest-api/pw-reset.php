<?php
function do_password_reset() {
  if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {

      $rp_key = $_REQUEST['rp_key'];
      $rp_login = $_REQUEST['rp_login'];
      $user = check_password_reset_key( $rp_key, $rp_login );
      if ( ! $user || is_wp_error( $user ) ) {
          if ( $user && $user->get_error_code() === 'expired_key' ) {
              wp_redirect( home_url( '?login=expiredkey' ) );
          } else {
              //wp_redirect( home_url( '?login=invalidkey' ) );
          }
          exit;
      }
      if ( isset( $_POST['pass1'] ) ) {
          if ( $_POST['pass1'] != $_POST['pass2'] ) {
              // Passwords don't match 
              $redirect_url = home_url( 'member-password-reset' );
              $redirect_url = add_query_arg( 'key', $rp_key, $redirect_url );
              $redirect_url = add_query_arg( 'login', $rp_login, $redirect_url );
              $redirect_url = add_query_arg( 'error', 'password_reset_mismatch', $redirect_url );
              wp_redirect( $redirect_url );
              exit;
          }
          if ( empty( $_POST['pass1'] ) ) {
              // Password is empty 
              $redirect_url = home_url( 'member-password-reset' );
              $redirect_url = add_query_arg( 'key', $rp_key, $redirect_url );
              $redirect_url = add_query_arg( 'login', $rp_login, $redirect_url );
              $redirect_url = add_query_arg( 'error', 'password_reset_empty', $redirect_url );
              wp_redirect( $redirect_url );
              exit;
          }
          // Parameter checks OK, reset password 
          reset_password( $user, $_POST['pass1'] );
          wp_redirect( home_url( '?password=changed' ) );
      } else {
          echo "Invalid request.";
      }
      exit;
  }
}