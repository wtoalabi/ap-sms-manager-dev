<?php
/**
 * Created by Alabi Olawale
 * Date: 25/07/2020
 */

namespace AppsBay\Controllers\Gateways\SDK;

use AppsBay\Controllers\Gateways\GatewaysInterface;
use Nexmo;

class NexmoAPI implements GatewaysInterface {

	public function send( $data ) {
		$gateway    = $data['gateway'];
		$client     = new Nexmo\Client( new Nexmo\Client\Credentials\Basic( $gateway['apiKey'], $gateway['username'] ) );
		$recipients = collect( $data['recipients'] );
		try {
			$recipients->each(
				function ( $recipient ) use ( $data, $client ) {
					$response = $client->message()->send(
						array(
							'to'   => $recipient,
							'from' => $data['senderID'],
							'text' => $data['message'],
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
