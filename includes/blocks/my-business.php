<?php

function ept_uf_my_business_render_cb($atts) {
  global $wpdb;
  $user = wp_get_current_user();
  if (!get_user_meta($user->ID, 'business_owner', true) && !is_admin()){
    wp_redirect(home_url());
  }
  $bar_owners_table = $wpdb->prefix . 'bar_owners';
  $event_places_table = $wpdb->prefix . 'events_places';


  $query = $wpdb->prepare(
    "SELECT post_id FROM $bar_owners_table WHERE user_id = %d",
    $user->ID
  );

  $results = $wpdb->get_results($query);
  $businesses = [];
  

if (!empty($results)) {
    foreach ($results as $row) {
      $events= [];
      $events_results = $wpdb->get_results("SELECT event_id FROM $event_places_table WHERE place_id = $row->post_id", ARRAY_A);
      foreach($events_results as $e_row){
        $events[] = $e_row['event_id'];
      }
        $businesses[] = [
          'ID'=>$row->post_id,
          'events'=>$events
        ];
    }
}
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
    foreach ($businesses as $business){
      $business_name = get_the_title($business['ID']);
      $business_url = get_permalink($business['ID']);
      ?>
      <dt>
        <a href = <?php echo $business_url?> class="list-item">
          <?php echo($business_name); ?>
        </a>
          <?php foreach($business['events'] as $b_event){ 
            $event_name = get_the_title($b_event);
            $event_url = get_permalink($b_event); ?>
            <dd> -
              <a href = <?php echo $event_url?> class = "sublist-item">
                <?php echo($event_name); ?>
              </a>
            </dd> <?php
          }?>
        </dt>
      <?php
    }
    ?>
    </dl>
    <a href = "<?php echo home_url("claim-business"); ?>" class = "v-aligner add-duo claim-business-button">
      <span class = "add-label">
        <?php _e('Add new business'); ?>
      </span>
      <button class = "add-button">
        <i class="bi bi-plus-square"></i>
      </button> 
    </a>
    <a href = "<?php echo home_url("claim-business"); ?>" class = "v-aligner add-duo add-event-button">
      <span class = "add-label">
        <?php _e('Add new event'); ?>
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