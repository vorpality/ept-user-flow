<?php 
function ept_user_flow_load_php_translations() {
  load_plugin_textdomain(
    'e-potis',
    false,
    "ept-user-flow/languages"
  );
}

function ept_user_flow_load_block_translations(){
  $blocks = [
    'ept-user-flow-auth-modal-editor',
    'ept-user-flow-header-tools-editor-script',
    'ept-user-flow-account-edit-form-editor-script',
    'ept-user-flow-header-tools-view-script',
    'ept-user-flow-auth-modal-view-script',
    'ept-user-flow-account-edit-form-view-script'
  ];

  foreach($blocks as $block){
    wp_set_script_translations(
      $block,
      'e-potis',
      EPT_UF_PLUGIN_DIR . "languages"
    );
  }
}