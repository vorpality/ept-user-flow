<?php

function ept_uf_account_edit_form_render_cb($atts) {

  $user = wp_get_current_user();
  $nsltr = get_user_meta($user->ID, 'newsletter', true);
  ob_start();
  ?>
  <div class="wp-block-ept-user-flow-account-edit-form">
  <h2 class="inner-page-header"><?php echo (__('Hello, ', 'e-potis').$user->user_login);?></h2>
  <form method = "post"
    id="data-replace-form"
    action = ""
    autocomplete="off"
  >
  <div id ='form-status'>
  </div>
    <fieldset>
 
    <h3 id ="change-acc-title"><?php echo (__('Change account settings: ','e-potis'));?></h3>

    <h3><?php echo (__('E-mail','e-potis'));?></h3>
    <input 
      value="<?php echo esc_html($user->user_email); ?>"
      type="email" 
      name="user_email" 
      id="dr-email">
    </input>
    <h3><?php echo (__('Change Password','e-potis'));?></h3>
    <div class="change-pw">
      <h3><?php echo (__('New Password','e-potis'));?></h3>

      <input 
        value=""
        type="password" 
        name="new-password" 
        id="dr-new-password">
      </input>
      
      
      <h3><?php echo (__('Confirm New Password','e-potis'));?></h3>

      <input 
        value=""
        type="password" 
        name="verify-new-password" 
        id="dr-verify-password">
      </input>
    </div>
    
    <h3><?php echo (__('Current Password','e-potis'));?></h3>

    <input 
      value=""
      type="password" 
      name="old-password" 
      id="dr-old-password">
    </input>
    <div class = "bottom-wrapper">
      <div class = "check_box_container">
        <label for="newsletter_box"><?php _e('Keep me updated', 'e-potis'); ?></label>
        <input 
          id="dr-newsletter" 
          name="newsletter"
          type="checkbox"
          value="0"
          <?php checked($nsltr,1)?>
        />
        <input type="hidden" name="form-id" value = "011"></input>
        <input type="hidden" id="user-id" value = "<?php echo $user->ID?>"></input>
      </div>
      <div class='btn-wrapper'>
          <button type="submit" class='open-confirmation-modal'><?php _e('Submit', 'e-potis'); ?></button>
      </div>
    </div>
</fieldset>
</form>
</div>
  <?php

  $output = ob_get_contents();
  ob_end_clean();
  
  return $output;
}