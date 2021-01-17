<?php
	require_once __DIR__ . '/vendor/autoload.php';	
// 	This is to create a admin page to view 
//       woocommerce_update_order
// 	 add_action( 'woocommerce_payment_complete', 'action_woocommerce_payment_complete');

//Global Function to send msm 
	 function sms($phonenumber){
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
	add_action( 'woocommerce_payment_complete', 'action_woocommerce_payment_complete');
	// define the woocommerce_payment_complete callback 
	function action_woocommerce_payment_complete( $order_id ) { 
	  if( ! $order_id ) return;
	  	 $order = wc_get_order( $order_id ); 
	  	 $order_id_set= $order->get_id();
		 $phone = '18888888888';// Please update this to your number
		 $text_speech=  get_option('call_voice_speech');//Go to the plugin setting to change to your message
	  	 
		 $keypair = new \Nexmo\Client\Credentials\Keypair(file_get_contents(__DIR__.'/private.key'),'4bb971d0-7f49-41f7-9612-2ed32a203bb4');// update to your private key and visit nexmo document

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
				 ->setFrom('12262101799')// Update this to your Nexmo number
				 ->setNcco($ncco);
		    $response = $client->calls()->create($call);
//If you want to fire a sms the use below
		     sms('18888888888','orderReady'); //Update to yours
			return $response;
	}; 
