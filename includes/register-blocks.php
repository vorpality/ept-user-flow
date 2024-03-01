<?php

function ept_uf_register_blocks() {
    $blocks = [
        [ 'name' => 'header-tools', 'options' => [
            'render_callback' => 'ept_header_tools_render_cb'
        ]],
        [ 'name' => 'auth-modal', 'options' => [
            'render_callback' => 'ept_auth_modal_render_cb'
        ]],      
        [ 'name' => 'log-out-helper', 'options' => [
            'render_callback' => 'ept_log_out_render_cb'
        ]],
        [ 'name' => 'forgot-password', 'options' => [
            'render_callback' => 'ept_forgot_password_render_cb'
        ]],
        [ 'name' => 'reset-password', 'options' => [
            'render_callback' => 'ept_pw_reset_rd_render_cb'
        ]],
        [ 'name' => 'account-edit-form', 'options' => [
            'render_callback' => 'ept_uf_account_edit_form_render_cb'
        ]],
        [ 'name' => 'my-business', 'options' => [
            'render_callback' => 'ept_uf_my_business_render_cb'
        ]],
        [ 'name' => 'claim-business', 'options' => [
            'render_callback' => 'ept_uf_claim_business_render_cb'
        ]],
        [ 'name' => 'locationeer', 'options' => [
            'render_callback' => 'ept_locationeer_render_cb'
        ]],
        
    ]; 

    foreach($blocks as $block){
        register_block_type(
            EPT_UF_PLUGIN_DIR . 'build/blocks/'. $block['name'] .'/block.json',
            isset($block['options']) ? $block['options'] : []
        ); 
    }
} 