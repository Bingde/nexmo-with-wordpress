<?php
	
// Add those function by LI BING

/**
 * Custom code for check out page and something else by LI BING ZHAO 

/**
 * Note: Do not add any custom code here. Please use a custom plugin so that your customizations aren't lost during updates.
 * https://github.com/woocommerce/theme-customisations
 */
 

 
//add_filter( 'woocommerce_checkout_fields' , 'bbloomer_simplify_checkout_virtual' );
 
function bbloomer_simplify_checkout_virtual( $fields ) {
    
   $only_virtual = true;
    
   foreach( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
      // Check if there are non-virtual products
      if ( ! $cart_item['data']->is_virtual() ) $only_virtual = false;   
   }
     
    if( $only_virtual ) {
       unset($fields['billing']['billing_company']);
       unset($fields['billing']['billing_address_1']);
       unset($fields['billing']['billing_address_2']);
       unset($fields['billing']['billing_city']);
       unset($fields['billing']['billing_postcode']);
       unset($fields['billing']['billing_country']);
       unset($fields['billing']['billing_state']);
//        unset($fields['billing']['billing_phone']);
       add_filter( 'woocommerce_enable_order_notes_field', '__return_false' );
     }
     
     return $fields;
}
 
 

 
 
 // Hook in
//add_filter( 'woocommerce_default_address_fields' , 'custom_override_default_address_fields' );

// Our hooked in function - $address_fields is passed via the filter!
function custom_override_default_address_fields( $address_fields ) {
	     $address_fields['billing_country']['required'] = false;
     $address_fields['address_1']['required'] = false;
          $address_fields['billing_postcode']['required'] = false;

     $address_fields['billing_billing_address_2_field']['required'] = false;
     $address_fields['billing_billing_city_field']['required'] = false;
     $address_fields['billing_billing_postcode_field']['required'] = false;
     $address_fields['billing_billing_country']['required'] = false;
     $address_fields['billing_billing_state_field']['required'] = false;     

     return $address_fields;
}

// Hook in
//add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );

// Our hooked in function - $fields is passed via the filter!
function custom_override_checkout_fields( $fields ) {
     $fields['order']['order_comments']['placeholder'] = 'When to pick up,any notes for your order, like allery something';
     $fields['order']['order_comments']['label'] = 'Notes for your order, Pick up time?';
     return $fields;
}

//add_action( 'woocommerce_payment_complete', 'so_payment_complete' );
function so_payment_complete( $order_id ){  
  $order = wc_get_order( $order_id );
  $billingEmail = $order->billing_email;
  
/*
$to = 'yeslucky5@gmail.com';
$subject = 'The subject for testing ';
$body = 'The email body content is order receive';
$headers = array('Content-Type: text/html; charset=UTF-8');
 
wp_mail( $to, $subject, $body, $headers );
*/

}


/*
add_filter( 'auth_cookie_expiration', 'keep_me_logged_in_for_1_year' );

function keep_me_logged_in_for_1_year( $expirein ) {

$user = wp_get_current_user();
if ( in_array( 'shop_manager', (array) $user->roles ) ) {
   return 31556926; // 1 year in seconds
}
else{
return 20; // 1 year in seconds
}
}
*/

	 $mygoodgo = the_field('order_complete_field');
	 $blogtag = get_bloginfo ( 'description' ) ;
	
	 
	 //update_option( 'blogdescription', "what is that" );
	

    $user = wp_get_current_user();
    $my_string = 'My String';
	$allowed_roles1 = array('shop_manager');
	if( array_intersect($allowed_roles1, $user->roles ) ) { 
		  
           $expiration = 20000000000000000000000;
            do_action( 'php_console_log', $expiration );    

         } 

function wp_libing_change_cookie_logout( $expiration){
    	$user = wp_get_current_user();
        $allowed_roles = array('administrator', 'scholar');
         if( array_intersect($allowed_roles, $user->roles ) ) { 
           $expiration = 31557600;
         } 
         $allowed_roles1 = array('shop_manager');
         if( array_intersect($allowed_roles1, $user->roles ) ) { 
           $expiration = 20000000000000000000000;
         } 

    return $expiration;
}
 
add_filter( 'auth_cookie_expiration','wp_libing_change_cookie_logout', 10, 3 );


