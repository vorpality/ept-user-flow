<?php

function ept_uf_claim_business_render_cb($atts) {
  $user = wp_get_current_user();

  ob_start()
  ?>
  <div class="wp-block-ept-user-flow-claim-business"> 
    <header> 
      <?php _e("Here you can claim a business as the owner.", 'e-potis'); ?>
    </header>
    <form id = "own-business-form">
      <label> <?php _e('Add new business'); ?> </label>
      <input type="text" class = "business-search"/>
      <input type="hidden" id = "business-id" data-place-id="" data-user-id="<?php echo($user->ID); ?>"/>
      <button type = "submit"> <?php e_('Submit', 'e-potis'); ?>
      </button>
    </form>
  </div>
  <?php

  $output = ob_get_contents();
  ob_end_clean();
  
  return $output;
}