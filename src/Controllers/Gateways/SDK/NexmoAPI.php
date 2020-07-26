<?php
	/**
	 * Created by Alabi Olawale
	 * Date: 25/07/2020
	 */
	
	namespace App\Controllers\Gateways\SDK;
	
	
	use App\Controllers\Gateways\GatewaysInterface;
	use Nexmo;
	use Telnyx\Message;
	
	class NexmoAPI implements GatewaysInterface{
		
		public function send( $data ) {
			$gateway = $data['gateway'];
			$client = new Nexmo\Client(new Nexmo\Client\Credentials\Basic($gateway['apiKey'], $gateway['username']));
			$recipients = collect( $data['recipients'] );
			try {
				$recipients->each( function ( $recipient ) use ( $data,$client ) {
					$response = $client->message()->send([
						'to' => $recipient,
						'from' => $data['senderID'],
						'text' => $data['message']
					]);
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
			
			/*dd($recipients);
			$message = $client->message()->send([
				'to' => NEXMO_TO,
				'from' => NEXMO_FROM,
				'text' => 'Test message from the Nexmo PHP Client'
			]);
			
			dd($client);
			*/
		}
	}
