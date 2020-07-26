<?php
	/**
	 * Created by Alabi Olawale
	 * Date: 19/07/2020
	 */
	
	namespace App\Controllers\Gateways\SDK;
	
	use App\Controllers\Gateways\GatewaysInterface;
	use AfricasTalking\SDK\AfricasTalking;
	class AfrikasTalkingAPI implements GatewaysInterface {
		
		public function send( $data ) {
			
			$username = $data['gateway']['username'];
			$apiKey   = $data['gateway']['apiKey'];
			$AT       = new AfricasTalking( $username, $apiKey );
			$sms      = $AT->sms();
			$result   = $sms->send( [
				'to'      => $data['recipients'],
				'message' => $data['message'],
				"enqueue" => true,
				'from'    => $data['senderID']
			] );
			$message  = $result['data']->SMSMessageData->Message;
			if ( str_contains( $message, "Sent to" ) ) {
				return [
					'status'  => 'success',
					'message' => $message
				];
			} else {
				return [
					'status'  => 'error',
					'message' => $message
				];
			}
		}
	}
