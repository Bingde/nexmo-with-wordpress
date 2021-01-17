<?php
	require_once __DIR__ . '/vendor/autoload.php';	
//     require_once __DIR__ . '/functions.php';
// 	This is to create a admin page to view 
		 $blogtag = get_bloginfo ( 'description' ) ;
//       woocommerce_update_order
// 	 	add_action( 'woocommerce_payment_complete', 'action_woocommerce_payment_complete');
	
	add_action( 'woocommerce_payment_complete', 'action_woocommerce_payment_complete');
	// define the woocommerce_payment_complete callback 
	function action_woocommerce_payment_complete( $order_id ) { 
	  if( ! $order_id ) return;
	  	 $order = wc_get_order( $order_id ); 
	  	 $order_id_set= $order->get_id();
	  	 update_option('new_after_payment_before_show',$order_id_set);

		 $phone = bpfwp_setting( 'clickphone', $location = false );
		 error_log($phone);
		 $text_speech=  get_option('call_voice_speech');
	  	 
		 $keypair = new \Nexmo\Client\Credentials\Keypair(file_get_contents(__DIR__.'/private.key'),'4bb971d0-7f49-41f7-9612-2ed32a203bb4');
		 $client = new \Nexmo\Client($keypair);
		 $ncco = [
				  [
				    'action' => 'talk',
				    'voiceName' => 'Hans',
				    'language' => 'cmn-CN',
				    'style'=>5,
				    'text' => $text_speech
				  ]
				 ];
				 $call = new \Nexmo\Call\Call();
				 $call->setTo($phone)
				 ->setFrom('12262101799')
				 ->setNcco($ncco);
		    $response = $client->calls()->create($call);
			 error_log('call resturant finish');
		   
		   $call2 = new \Nexmo\Call\Call();
				 $call2->setTo('15146236456')
				 ->setFrom('12262101799')
				 ->setNcco($ncco);
		    $response2 = $client->calls()->create($call2);

		    
			return $response;
	}; 
	
// 	 Add action to ajax the order ID and Update order status
	add_action("wp_ajax_my_user_vote", "my_user_vote");

	add_action("wp_ajax_nopriv_my_user_vote", "my_must_login");
	
	add_action("wp_ajax_my_checking", "my_checking");
	
	add_action("wp_ajax_order_ready_post", "order_ready_post");

	function my_checking(){
		
	   if ( !wp_verify_nonce( $_REQUEST['nonce'], "my_checkinggg_nonce")) {
// 		    error_log('nonce issue');
	      exit("No naughty business please");
	   }
		$payment_completed_order = get_option('new_after_payment_before_show');
		$orde_ready= get_option('order_number_confirm');
		error_log($orde_ready);
		$last_order =  get_option('new_order_number');
		 if (strcmp($payment_completed_order, $last_order) > 0) {
		 	 $result['type'] = "success";
		 	// $result['vote_count'] = $payment_completed_order;
		 	 //$result['order_ready'] = $orde_ready;
		 	 //error_log('find something and compare sucessfully');
		 }
		 else {
			  //error_log('excute nothing found');
			 // $result['vote_count']=100;
			  $result['type'] = "error";
		 }
		 //Add order ready Trigger to a flag
		 $result['vote_count']= $last_order;
		 $result['order_ready'] = $orde_ready;
		 if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 			{
	      	$result = json_encode($result);
		  	echo $result;
	   		}
	   	else {
	      header("Location: ".$_SERVER["HTTP_REFERER"]);
	   	}
	   	wp_die(); 
// 	   die();
		
	}
	//Global Function to send msm 
	 function sms($phonenumber,$reason){
		   $api_key = get_option('api_key');;
		   $api_secret = get_option('api_secret');
		   $sms_to_client=  get_option('confirm_message');
		   if($reason=='orderReady'){
			$sms_to_client=get_option('ready_message'); 
		   }
// 		   $phone ='15146236456';  
		   $basic  = new \Nexmo\Client\Credentials\Basic($api_key, $api_secret);
		   $client = new \Nexmo\Client($basic);
		   $message = $client->message()->send([
		   'to' => $phonenumber,
		   'from' => '12262101799',
		   'text' => $sms_to_client
		   ]);
	  	}

	function order_ready_post(){
		  if ( !wp_verify_nonce( $_REQUEST['nonce'], "order_ready_nonce")) {
			   
	      exit("No naughty business please");
	   }
	   $ready_number = $_REQUEST["post_id"];
	   $result['type'] = "success";
	   $_order = wc_get_order($ready_number);
	   update_option('order_number_confirm','set');
	   $_order->update_status( 'completed' );
	   $clientNumber= '15146236456';
	   
	   sms($clientNumber,'orderReady');
	   // i am here to next
	    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	      $result = json_encode($result);
	      echo $result;
	   }
	   else {
	      header("Location: ".$_SERVER["HTTP_REFERER"]);
	   }
	   die();
	}
	function my_user_vote() {
	
	   if ( !wp_verify_nonce( $_REQUEST['nonce'], "my_user_vote_nonce")) {
	      exit("No naughty business please");
	   }
	   $order_number = $_REQUEST["post_id"];
	   $insert =$order_number;
	   $_order = wc_get_order($insert);
	   
	   $_order->update_status( 'order-doing' );

	   $phone = $_order->get_billing_phone(); 
// 	   $phone = '15146236456';
	   $vote= update_option('new_order_number', $insert);
	  // update_option('order_number_confirm','non');
	  $sms_to_client=  get_option('confirm_message');

	   if(strlen($phone)<11 && strlen($phone)==10){
		   
		   $phonenumber.='1'.$phone;
		   error_log($phonenumber);
		   sms($phonenumber,$sms_to_client);
		    error_log('msm finish');
		   $my='15146236456';
		   sms($my,$sms_to_client);
	   }
	   else {
		    sms($phone,$sms_to_client);
		    $my='15146236456';
		    sms($my,'orderReady');
		   
	   }
	
	  if($vote === false) {
	      $result['type'] = "error";
	      $result['vote_count'] = $vote_count;
	   }
	   else {
	      $result['type'] = "success";
	      $result['vote_count'] = $insert;
	       $result['phone'] = $phonenumber;
	   }
	   if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	      $result = json_encode($result);
	      echo $result;
	   }
	   else {
	      header("Location: ".$_SERVER["HTTP_REFERER"]);
	   }
	
	   die();
	  	
	} 
	function my_must_login() {
	   echo "You must log in to View";
	   die();
	}
	
/*
	woocommerce_after_cart_contents
	woocommerce_before_cart
*/
// add_action('woocommerce_after_cart_contents', 'addTip', 1);

add_action('woocommerce_before_cart_totals', 'addTip', 1);

function addTip() {
	echo '<a href="/product/tips/"><img src="https://beijingdumpling.ca/wp-content/uploads/2020/12/CHW0118_fd_tipping-416x312.jpg" style=" width: 100px; height: 100px;"></a>';
	echo 'Donner un pourboire / Want to give some tips';
}