<?php

function ept_uf_enqueue_scripts(){
    ept_uf_enqueue_rest_shorts();
}


function ept_uf_enqueue_rest_shorts(){
    $authURLs = json_encode([
        'signup' => esc_url_raw(rest_url('ept/v1/signup')),
        'signin' => esc_url_raw(rest_url('ept/v1/signin')),
        
    ]);
    $passwordToolURLs = json_encode([
        'forgot' => esc_url_raw(rest_url('ept/v1/forgot'))
    ]);
    $dataURLs = json_encode([
        'replace' => esc_url_raw(rest_url('ept/v1/replace')),
    ]);

    

    wp_add_inline_script(
        'ept-user-flow-auth-modal-view-script',
        "const ept_auth_rest = {$authURLs}",
        'before' //after
    );

    wp_add_inline_script(
        'ept-user-flow-forgot-password-view-script',
        "const ept_pwt_rest = {$passwordToolURLs}",
        'before' //after
    );
    
    wp_add_inline_script(
        'ept-user-flow-account-edit-form-view-script',
        "const ept_account_edit = {$dataURLs}",
        'before' //after
    );
}




