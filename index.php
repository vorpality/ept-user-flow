<?php
/*
 * Plugin Name:       Epotis User Flow
 * Description:       A set of user flow blocks
 * Version:           1.0.0
 * Requires at least: 5.9
 * Requires PHP:      7.2
 * Author:            Epotis team
 * Text Domain:       e-potis
 */

if(!function_exists('add_action')) {
    echo 'Seems like you stumbled here by accident.';
    exit;
} 
 
//  Setup
define('EPT_UF_PLUGIN_DIR', plugin_dir_path(__FILE__));

//  Includes
$rootFiles = glob(EPT_UF_PLUGIN_DIR . 'includes/*.php');
$subDirectoryFiles = glob(EPT_UF_PLUGIN_DIR . 'includes/**/*.php');
$subSubDirectoryFiles = glob(EPT_UF_PLUGIN_DIR . 'includes/**/**/*.php');
$googleApi = glob(EPT_UF_PLUGIN_DIR . '/assets/vendor/autoload.php');

$allFiles = array_merge($rootFiles, $subDirectoryFiles, $subSubDirectoryFiles, $googleApi);

foreach($allFiles as $filename){
    include_once($filename);
}

//  Hooks
add_action('init','ept_uf_register_blocks');
add_action('rest_api_init', 'ept_uf_rest_api_init');
add_action('wp_enqueue_scripts', 'ept_uf_enqueue_scripts');
add_filter('wp_mail_from', 'ept_uf_new_mail_from');
add_filter('wp_mail_from_name', 'ept_uf_new_mail_from_name');
add_action('login_form_resetpass', 'ept_pw_reset_redirect');
add_action('login_form_rp','do_password_reset');
add_action('login_form_resetpass', 'do_password_reset');
add_action('init', 'ept_user_flow_load_php_translations');
add_action('wp_enqueue_scripts', 'ept_user_flow_load_block_translations',100); 
