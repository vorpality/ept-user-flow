<?php

function ept_forgot_password_render_cb($atts) {
  if(is_user_logged_in()) {
    wp_redirect(home_url());
  }

  
  ob_start();
  ?>
  <div class="wp-block-ept-user-flow-forgot-password">
  <form id = "reset-form">
  <div id="submit-status"></div>
    <fieldset>
      <label><?php echo (__('Enter the email associated with your account.','e-potis'));?></label>
      <input type="text" id="f-email" placeholder="someone@example.com"></input>
      <div class='btn-wrapper'>
        <button type="submit"><?php echo (__('Submit','e-potis'));?></button>
      </div>
    </fieldset>
        </form>
  </div>
  <?php

  $output = ob_get_contents();
  ob_end_clean();
  
  return $output;
}