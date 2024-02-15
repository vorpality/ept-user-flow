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
    <header> 
      <?php _e("Here you can claim a business as the owner.", 'e-potis'); ?>
    </header>
    <form id = "own-business-form">
      <label> <?php _e('Add new business'); ?> </label>
      <input type="text" class = "business-search" value=""/>
      <input type="hidden" id = "business-data" data-place-id="" data-user-id="<?php echo($user->ID); ?>"/>
      <button type = "submit"> <?php _e('Submit', 'e-potis'); ?>
      </button>
    </form>
  </div>
  <?php

  $output = ob_get_contents();
  ob_end_clean();
  
  return $output;
}