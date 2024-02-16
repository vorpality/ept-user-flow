<?php

function ept_uf_claim_business_render_cb($atts) {
  global $wpdb;
  $user = wp_get_current_user();
  $table_name = $wpdb->prefix . 'bar_owners';
  $unowned_places = $wpdb->get_results("SELECT post_id FROM $table_name WHERE user_id IS NULL OR user_id = 0", ARRAY_A);
  $unowned_places_ids = wp_list_pluck($unowned_places, 'post_id');
  $places_data = array_map(function($post_id) {
    $post = get_post($post_id);
    return ['id' => $post_id, 'name' => $post->post_title];
  }, $unowned_places_ids);

  ob_start();
  ?>
  <div class="wp-block-ept-user-flow-claim-business" 
    data-places='<?php echo json_encode($places_data); ?>'>
    <header id = "block-title"> 
      <?php _e("Here you can claim a business as the owner.", 'e-potis'); ?>
    </header>
    <form id = "own-business-form">
      <label id="new-business-title"> <?php _e('Add new business'); ?> </label>
      <input type="text" class = "business-search" value=""/>
      <input type="hidden" id = "business-data" data-place-id="" data-user-id="<?php echo($user->ID); ?>"/>
      <button type = "submit"> <?php _e('Submit', 'e-potis'); ?>
      </button>
    </form>

    <div id="submit-modal">
      <div class="modal-content">
        <span class="close-button">&times;</span>
        <div id = "modal-details">
          <h2><?php _e('Post Details', 'e-potis'); ?></h2>
          <p id="modal-title"></p>
          <p><a href="" id="modal-link" target="_blank"><?php _e('View Post','e-potis'); ?></a></p>
          <button id="confirm-button"><?php _e('Confirm', 'e-potis'); ?> </button>
        </div>
      </div>
    </div>

  </div>
  <?php

  $output = ob_get_contents();
  ob_end_clean();
  
  return $output;
}