<?php

function ept_header_tools_render_cb($atts) {
    $user = wp_get_current_user();
    $name = $user->exists() ? $user->user_login : __('Sign in', 'e-potis');
    $openClass = $user->exists() ? 'open-user-modal' : 'open-auth-modal';
    $owner = get_user_meta($user->ID, 'business_owner', true);
    
    ob_start();
    ?>
    <div class="wp-block-ept-user-flow-header-tools">
    <?php
    
    if($atts['showAuth']){    
        ?>
        
        <div class = "account-dropdown">
            <div class = "aligner">
                <a class="signin-link <?php echo $openClass; ?>" href="#">
                    <div class="signin-icon">
                        <i class="bi bi-person-circle"></i>
                    </div>

                    <?php if($user->exists()) {
                    ?> 
				</a>
                <div class="signin-text">
                    <div class = "dropbtn">
                        <div class="text-aligner">
                            <?php echo (__('Hello,','e-potis'));?> 
                            <div class="signin-text-link-logged"><?php echo($name) ?></div>
                        </div>
                    </div>
                    <div class = "dropdown-content">
                        <ul class="elements">
                            <li>
                                <?php if($owner) { ?>
                                    <a href="<?php echo esc_url((home_url('/my-business'))); ?>">
                                    <button class = "button-element"> <?php echo (__('My business','e-potis'));?></button>
                                </a>
                                <?php } ?> 
                                <a href="<?php echo esc_url((home_url('/my-account'))); ?>">
                                    <button class = "button-element"> <?php echo (__('My account','e-potis'));?></button>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo esc_url((home_url('/favorites'))); ?>" >
                                    <button class = "button-element"> <?php echo (__('Favorites','e-potis'));?></button>
                                </a>
                            </li>
                            <hr>
                            <li>
                                <a href="<?php echo esc_url((home_url('/logout'))); ?>" >
                                    <button class = "button-element"> <?php echo (__('Log out','e-potis'));?></button>
                                </a>
                            </li>
                        </ul> 
                    </div>
                <?php
                    }
                    else {
                ?>
					
                <div class="signin-text">
                        <small class="text-aligner"> 
                            <?php echo (__('Hello,','e-potis'));?> 
                            <div class="signin-text-link-unlogged"><?php echo $name; ?></div>
                        </small>
					</a>
				</div>
                <?php
                    }
                ?>
            </div> 
        </div>
             
<?php
    }
?>
    </div>
    <?php
    $output = ob_get_contents();
    ob_end_clean();

    return $output;
}