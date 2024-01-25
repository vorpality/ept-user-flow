<?php
function ept_pw_reset_rd_render_cb($atts) {
  if(is_user_logged_in()) {
    return '';
  }

  ?>
 <div class="wp-block-ept-user-flow-reset-password"> 
 <h3><?php _e( 'Pick a New Password', 'e-potis' ); ?></h3>
    <form name="resetpassform" id="resetpassform" action="<?php echo site_url( 'wp-login.php?action=resetpass' ); ?>" method="post" autocomplete="off">
        <input type="hidden" id="user_login" name="rp_login" value="<?php echo esc_attr($_GET['login']); ?>" autocomplete="off" />
        <input type="hidden" name="rp_key" value="<?php echo esc_attr( $_GET['key'] ); ?>" />

        <p>
            <label for="pass1"><?php _e( 'New password', 'e-potis' ) ?></label>
            <input type="password" name="pass1" id="pass1" class="input" size="20" value="" autocomplete="off" />
        </p>
        <p>
            <label for="pass2"><?php _e( 'Repeat new password', 'e-potis' ) ?></label>
            <input type="password" name="pass2" id="pass2" class="input" size="20" value="" autocomplete="off" />
        </p>
        
        <p class="description"><?php echo wp_get_password_hint(); ?></p>
        
        <p class="resetpass-submit">
            <input type="submit" name="submit" id="resetpass-button"
                   class="button" value="<?php _e( 'Reset Password', 'e-potis' ); ?>" />
        </p>
    </form>
</div>
<?php
  $output = ob_get_contents();
  ob_end_clean();

  return $output;
}