<?php
	/**
	 * Created by Alabi Olawale
	 * Date: 24/07/2020
	 */
	
	namespace App\Controllers\Gateways\SDK;
	
	
	use App\Controllers\Gateways\GatewaysInterface;
	use Telnyx\Message;
	use Telnyx\Telnyx;
	
	class TelnyxAPI implements GatewaysInterface {
		public function send( $data ) {
			Telnyx::setAppInfo( "APPSBAY_WP_SMS_MANAGER", "0.0.1", site_url() );
			Telnyx::setApiKey( $data['gateway']['apiKey'] );
			$recipients = collect( $data['recipients'] );
			try {
			$recipients->each( function ( $recipient ) use ( $data ) {
				Message::Create( [
					'from' => $data['senderID'],
					'to'   => $recipient,
					'text' => $data['message']
				] );
				
			} );
			return [
				'status'  => 'success',
				'message' => "Successful Sent"
			];
			}catch (\Exception $e){
				return [
					'status'  => 'error',
					'message' => $e->getMessage()
				];
			}
			
		}
	}
