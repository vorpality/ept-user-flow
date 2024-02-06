<?php

function ept_uf_claim_business_render_cb($atts) {
  $user = wp_get_current_user();
  if (!get_user_meta($user->ID, 'business_owner', true) && !is_admin()){
    wp_redirect(home_url());
  }
  $businesses = get_user_meta($user->ID, 'has_business');

  ob_start()
  ?>
  <div class="wp-block-ept-user-flow-my-business"> 
    <header> 
      <?php _e("Here you can claim a business as the owner, manage your businesses or add an event.", 'e-potis'); ?>
    </header>
    <span class = "list-title">
        <?php _e('Your businesses', 'e-potis');?>
      </span>
    <dl class = "business-list"> 
      <?php
    foreach ($businesses as $businessID){
      $business_name = get_the_title($businessID);
      $business_url = get_permalink($businessID);
      ?>
      <li>
        <a href = <?php echo $business_url?> class="list-item">
          <?php echo($business_name); ?>
        </a>
      </li>
      <?php
    }
    ?>
    </dl>
    <a href = "<?php echo home_url("claim-business"); ?>" class = "v-aligner add-duo">
      <span class = "add-label">
        <?php _e('Add new business'); ?>
      </span>
      <button class = "add-button">
        <i class="bi bi-plus-square"></i>
      </button> 
    </a>
  </div>
  <?php

  $output = ob_get_contents();
  ob_end_clean();
  
  return $output;
}