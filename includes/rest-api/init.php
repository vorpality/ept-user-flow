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
        'permission_callback' => '__return_true'
    ]);
    
}