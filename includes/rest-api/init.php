<?php

function ept_uf_rest_api_init(){
    
    //example.com/wp-json/ept/v1/signup
    register_rest_route('ept/v1', '/signup', [
        'methods' => WP_REST_SERVER::CREATABLE,
        'callback' => 'ept_uf_rest_api_signup_handler',
        'permission_callback' => '__return_true'
    ]);

    //example.com/wp-json/ept/v1/signin
    register_rest_route('ept/v1', '/signin', [
        'methods' => WP_REST_SERVER::EDITABLE,
        'callback' => 'ept_uf_rest_api_signin_handler',
        'permission_callback' => '__return_true'
    ]);

    register_rest_route('ept/v1', '/forgot', [
        'methods' => WP_REST_SERVER::EDITABLE,
        'callback' => 'ept_uf_rest_api_forgot_handler',
        'permission_callback' => '__return_true'
    ]);

    register_rest_route('ept/v1', '/replace', [
        'methods' => WP_REST_SERVER::EDITABLE,
        'callback' => 'ept_uf_rest_api_data_replace_handler',
        'permission_callback' =>  function() {
            return is_user_logged_in(); 
        }
    ]);
    
    register_rest_route('ept/v1', '/google-signin', [
        'methods' => 'POST',
        'callback' => 'ept_uf_google_signin_handler',
        'permission_callback' => '__return_true'
    ]);

    register_rest_route('ept/v1', '/force-login', [
        'methods' => 'POST',
        'callback' => 'ept_uf_login_helper',
        'permission_callback' => '__return_true'
    ]);

    register_rest_route('ept/v1', '/claim-business', [
        'methods' => 'POST',
        'callback' => 'ept_uf_rest_api_claim_business_handler',
        'permission_callback' => '__return_true'
    ]);

    register_rest_route('ept/v1', '/add-event', [
        'methods' => WP_REST_SERVER::CREATABLE,
        'callback' => 'ept_uf_rest_api_add_event_handler',
        'permission_callback' => '__return_true'
    ]);
}