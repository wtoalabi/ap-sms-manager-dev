<?php
	/**
	 * Created by Alabi Olawale
	 * Date: 24/07/2020
	 */

	namespace AppsBay\Controllers\Gateways\SDK;

	use AppsBay\Controllers\Gateways\GatewaysInterface;
	use Telnyx\Message;
	use Telnyx\Telnyx;

class TelnyxAPI implements GatewaysInterface {
	public function send( $data ) {
		Telnyx::setAppInfo( 'APPSBAY_WP_SMS_MANAGER', '0.0.1', site_url() );
		Telnyx::setApiKey( $data['gateway']['apiKey'] );
		$recipients = collect( $data['recipients'] );
		try {
			$recipients->each(
				function ( $recipient ) use ( $data ) {
					Message::Create(
						array(
							'from' => $data['senderID'],
							'to'   => $recipient,
							'text' => $data['message'],
						)
					);

				}
			);
			return array(
				'status'  => 'success',
				'message' => 'Successful Sent',
			);
		} catch ( \Exception $e ) {
			return array(
				'status'  => 'error',
				'message' => $e->getMessage(),
			);
		}

	}
}
