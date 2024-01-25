<?php

function ept_log_out_render_cb() {
  global $wp;
  if( $wp->request === 'logout'){
    wp_logout();
    wp_redirect(home_url());
  }
}