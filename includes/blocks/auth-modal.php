<?php

function ept_auth_modal_render_cb($atts) {
  if(is_user_logged_in()) {
    return '';
  }

  ob_start();
  ?>
  <div class="wp-block-ept-user-flow-auth-modal">
    <div class="modal-container"> 
      <div class="modal-overlay"></div> 

      <span class="modal-trick">&#8203;</span>

      <div class="modal-content">
        <button class="modal-btn-close" type="button">
          <i class="bi bi-x"></i>
        </button>
        <!-- Tabs -->
        <ul class="tabs">
          <!-- Login Tab -->
          <li>
            <a href="#signin-tab" class="active-tab">
              <i class="bi bi-key"></i><?php echo (__('Sign in','e-potis'));?>
            </a>
          </li> 
          <?php

          if($atts['showRegister']) {
            ?>
            <!-- Register Tab -->
            <li>
              <a href="#signup-tab">
                <i class="bi bi-person-plus-fill"></i><?php echo (__('Sign up','e-potis'));?>
              </a>
            </li>
          <?php
          }

          ?>
        </ul>
        <div class="modal-body">
          <!-- Login Form -->
          <form id="signin-tab" style="display: block;">
            <div id="signin-status"></div>
            <fieldset>
              <label><?php echo (__('Email address','e-potis'));?></label>
              <input type="text" id="si-email" placeholder="johndoe@example.com" />

              <label><?php echo (__('Password','e-potis'));?></label>
              <input type="password" id="si-password" />
              <div id="forgot-link">
                <a href="www.petkarellas.gr/forgot-password"> <?php echo (__('Forgot your password?','e-potis'));?> </a>
              </div>
              <button type="submit">Sign in</button>
            </fieldset>
          </form>
          <!-- 
          data-login_uri="http://localhost/wp-json/ept/v1/google-signin" 
          data-callback="handleGoogleSignin" 
          -->
          <div id="g_id_onload"
            data-client_id="871559730084-mdf5uea60k4clraguvr76nd17c1517vr.apps.googleusercontent.com"
            data-callback="handleGoogleSignIn"
            data-auto_prompt="false">
          </div>
          <div class="g_id_signin"
            data-type="standard"
            data-size="large"
            data-theme="outline"
            data-text="sign_in_with"
            data-shape="rectangular"
            data-logo_alignment="left">
          </div> <?php
          if($atts['showRegister']) { ?>
            <!-- Register Form -->
            <form id="signup-tab">
              <div id="signup-status"></div>
              <fieldset>
                <label><?php echo (__('Full name','e-potis'));?></label>
                <input type="text" id="su-name" placeholder="John Doe" />

                <label><?php echo (__('Email address','e-potis'));?></label>
                <input type="email" id="su-email" placeholder="johndoe@example.com" />
                
                <label><?php echo (__('Password','e-potis'));?></label>
                <input type="password" id="su-password" />

                <div class="checkbox-duo">
                  <input type="checkbox" id="su-business-owner" />
                  <label><?php echo (__('I am a business owner','e-potis'));?></label>
                </div>

                <div class="checkbox-duo">
                  <input type="checkbox" id="su-newsletter" />
                  <label for="su-business-owner"><?php echo (__('I want to learn news about e-potis','e-potis'));?></label>
                </div>

                <button type="submit"><?php echo (__('Sign up','e-potis'));?></button>
              </fieldset>
            </form>
            <?php
          } ?>
          <!-- Business Owner Checkbox -->
        </div>
      </div>
    </div>
  </div>
  <?php

  $output = ob_get_contents();
  ob_end_clean();

  return $output;
} 