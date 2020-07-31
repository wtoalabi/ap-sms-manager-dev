<?php
/**
 * Created by Alabi Olawale
 * Date: 19/07/2020
 */

namespace AppsBay\Controllers\Gateways\SDK;

use AfricasTalking\SDK\AfricasTalking;
use AppsBay\Controllers\Gateways\GatewaysInterface;

class AfrikasTalkingAPI implements GatewaysInterface {

	public function send( $data ) {

		$username = $data['gateway']['username'];
		$api_key  = $data['gateway']['apiKey'];
		$at       = new AfricasTalking( $username, $api_key );
		$sms      = $at->sms();
		try {
			$result  = $sms->send(
				array(
					'to'      => $data['recipients'],
					'message' => $data['message'],
					'enqueue' => true,
					'from'    => $data['senderID'],
				)
			);
			$message = $result['data']->SMSMessageData->Message;
			if ( str_contains( $message, 'Sent to' ) ) {
				return array(
					'status'  => 'success',
					'message' => $message,
				);
			}

			return array(
				'status'  => 'success',
				'message' => 'Sent',
			);
		} catch ( \Exception $e ) {
			return array(
				'status'  => 'error',
				'message' => $e->getMessage(),
			);

		}
	}
}
