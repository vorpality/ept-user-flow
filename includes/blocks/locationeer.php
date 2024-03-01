<?php

function ept_locationeer_render_cb($atts) {

  if (isset($_COOKIE['location'])){
    return '';
  }

  ob_start();
    ?>
    <div class="wp-block-ept-user-flow-locationeer">
      <div class="content">
        <div class= "form-container">
          <p id = "location-message"> 
            <?php _e('Enter your location for personalized results, if you choose to skip this results may not be accurate.', 'e-potis'); ?>
          </p>
          <p id = "extra-information">
            <?php _e('If your location isn\'t accepted, you can use the map instead.', 'e-potis'); ?> 
          </p>
          

          <form id = "location-form">
          <div class = "btn-container">
            <input type = "text" id = "user-address" valid = 0 />
            <button id = "map-select"> <?php _e('Choose from map', 'e-potis'); ?> </button>
          </div>
            <div class = "btn-container">
              <button type = "submit" id = "submit-location"> <?php _e('Submit', 'e-potis'); ?> </button>
              <button id = "skip-location"> <?php _e('Skip location.', 'e-potis');?></button>
            </div>
            <input type = "hidden" id = "location-lat"/>
            <input type = "hidden" id = "location-lng"/>
          </form>        
        </div>
      </div>
      <div id="invalid-address-popup"><?php _e('Can\'t submit, invalid address', 'e-potis');?></div>
      <div id="map-popup" >
        <input type = "hidden" id = "temp-lng">
        <input type = "hidden" id = "temp-lat">

        <div id="map-overlay" class = "close-popup"></div>
        <div id = "popup-container">
          <button class = "close-popup"> X </button>
          <div id="map-canvas"></div>
          <button id="confirm-location"><?php _e('Confirm Location', 'e-potis');?></button>
        </div>
      </div>
    </div>
    <?php
  $output = ob_get_contents();
  ob_end_clean();
  
  return $output;
}