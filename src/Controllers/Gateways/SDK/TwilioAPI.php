<?php
	/**
	 * Created by Alabi Olawale
	 * Date: 25/07/2020
	 */

	namespace AppsBay\Controllers\Gateways\SDK;

	use AppsBay\Controllers\Gateways\GatewaysInterface;
	use Twilio\Rest\Client;

class TwilioAPI implements GatewaysInterface {

	public function send( $data ) {
		$gateway    = $data['gateway'];
		$sid        = $gateway['username'];
		$token      = $gateway['apiKey'];
		$recipients = collect( $data['recipients'] );
		try {
			$twilio = new Client( $sid, $token );
			$recipients->each(
				function ( $recipient ) use ( $data, $twilio ) {
					$twilio->messages
					->create(
						$recipient,
						array(
							'body' => $data['message'],
							'from' => $data['senderID'],
						)
					);
				}
			);
			return array(
				'status'  => 'success',
				'message' => 'Successfully Sent',
			);
		} catch ( \Exception $e ) {
			return array(
				'status'  => 'error',
				'message' => $e->getMessage(),
			);
		}
	}
}
