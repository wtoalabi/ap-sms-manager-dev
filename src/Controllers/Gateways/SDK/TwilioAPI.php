<?php
	/**
	 * Created by Alabi Olawale
	 * Date: 25/07/2020
	 */
	
	namespace App\Controllers\Gateways\SDK;
	
	
	use App\Controllers\Gateways\GatewaysInterface;
	use Twilio\Rest\Client;
	
	class TwilioAPI implements GatewaysInterface {
		
		public function send( $data ) {
			$gateway = $data['gateway'];
			$sid    = $gateway['username'];
			$token  = $gateway['apiKey'];
			$recipients = collect( $data['recipients'] );
			try {
				$twilio = new Client( $sid, $token );
				$recipients->each( function ( $recipient ) use ( $data,$twilio ) {
				$twilio->messages
					->create($recipient,
						["body" => $data['message'], "from" => $data['senderID']]
					);
				} );
				return [
					'status'  => 'success',
					'message' => "Successfully Sent"
				];
			}catch (\Exception $e){
				return [
					'status'  => 'error',
					'message' => $e->getMessage()
				];
			}
		}
	}
