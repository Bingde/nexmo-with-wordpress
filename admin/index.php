<?php // Silence is golden

// 	header("Refresh:10");

    add_action('admin_menu', 'test_plugin_setup_menu');

    
	function test_plugin_setup_menu(){
	//  WILL BE insert the menu into sub menu of Setting Page
    //  add_submenu_page( 'options-general.php',' Call voice setting', 'manage_options', 'call-setting', 'call_settings_page_content' );
		
	   add_menu_page( 'Make call setting', ' Call voice setting', 'manage_options', 'call-setting', 'call_settings_page_content' );
	    
	   //call register settings function
	   add_action( 'admin_init', 'register_my_cool_plugin_settings' );
	}
	function register_my_cool_plugin_settings() {
		//register our settings
		 register_setting( 'call_fields', 'api_key' );
		 register_setting( 'call_fields', 'api_secret' );
		 register_setting( 'call_fields', 'option_etc' );
		 register_setting( 'call_fields', 'new_after_payment_before_show' );
		 register_setting( 'call_fields', 'new_order_number' );
		 register_setting( 'call_fields', 'order_number_confirm' );
		 register_setting( 'call_fields', 'sec_new_order_number' );
		 register_setting( 'call_fields', 'sec_order_number_confirm' );
		 register_setting( 'call_fields', 'call_voice_speech' );
		 register_setting( 'call_fields', 'confirm_message' );
		 register_setting( 'call_fields', 'ready_message' );

	}
	
	function call_settings_page_content(){
	
	?>
		<div class="wrap">
			
		
    		<h2>My Awesome Settings Page</h2>
    			<?php
	    		function admin_notice() { ?>
				        <div class="notice notice-success is-dismissible">
				            <p>Your settings have been updated!</p>
				        </div>
				        <?php
					        write_log('nice to save');
				}
	    		if ( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] ){
					admin_notice();
                } 
                               ?>
				<form method="POST" action="options.php">
                <?php
                    settings_fields( 'call_fields' );
                    do_settings_sections( 'call_fields' );
                    
                ?>
                <table class="form-table">
			        <tr valign="top">
			        <th scope="row">API key</th>
			        <td><input type="text" name="api_key" value="<?php echo esc_attr( get_option('api_key') ); ?>" /></td>
			        </tr>
			         
			        <tr valign="top">
			        <th scope="row">API Secret</th>
			        <td><input type="text" name="api_secret" value="<?php echo esc_attr( get_option('api_secret') ); ?>" /></td>
			        </tr>
			        
			        <tr valign="top">
			        <th scope="row">To Call Center</th>
			        <td><input type="text" name="option_etc" value="<?php echo esc_attr( get_option('option_etc') ); ?>" /></td>
			        </tr>
			        
			        
			         <tr valign="top">
			        <th scope="row">New after payment before display</th>
			        <hr style="width:50%;text-align:left;margin-left:0">
			        <td><input type="text" name="new_after_payment_before_show" placeholder="none" value="<?php echo esc_attr( get_option('new_after_payment_before_show') ); ?>" /></td>
			         </tr>
			        
			        
			        
			        <tr valign="top" >
			        <th scope="row"> last Order</th>
			        <hr style="width:50%;text-align:left;margin-left:0">
			        <td><input type="text" name="new_order_number" placeholder="none" value="<?php echo esc_attr( get_option('new_order_number') ); ?>" /></td>
			         </tr>
			        <tr valign="top">
				    <th scope="row">Order confirm or not</th>
			        <td><input type="text" name="order_number_confirm" placeholder="no" value="<?php echo esc_attr( get_option('order_number_confirm') ); ?>" /></td>
			        </tr>
			        <tr valign="top" style="display:none">
			        <th scope="row">Second Order</th>
			        <td><input type="text" name="sec_new_order_number" value="<?php echo esc_attr( get_option('sec_new_order_number') ); ?>" /></td>
                    </tr>
			        <tr valign="top" style="display:none">
	                <th scope="row"> Second Order confirm or not</th>
			        <td><input type="text" name="sec_order_number_confirm" value="<?php echo esc_attr( get_option('sec_order_number_confirm') ); ?>" /></td>
			        </tr>
			        <tr valign="top">
	                <th scope="row">Call voice speech Text</th>
			        <td><input style="width:1500px"  type="text" name="call_voice_speech" value="<?php echo esc_attr( get_option('call_voice_speech') ); ?>" /></td>
			        </tr>
			        <tr valign="top">
	                <th scope="row"> Text message for Confirm</th>
			        <td><input style="width:1500px" type="text" name="confirm_message" value="<?php echo esc_attr( get_option('confirm_message') ); ?>" /></td>
			        </tr>
			        <tr valign="top">
	                <th scope="row"> Text message for Ready to Client</th>
			        <td><input style="width:1500px" type="text" name="ready_message" value="<?php echo esc_attr( get_option('ready_message') ); ?>" /></td>
			        </tr>

			     </table>
			        
			    <?php  submit_button();?>
			 
    		</form>
    		</div> <?php
	    			
			//echo esc_attr( get_option('option_etc') );
	}
    // End of add Admin Menu page
