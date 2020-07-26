<?php
	/**
	 * Created by Alabi Olawale
	 * Date: 19/07/2020
	 */
	
	namespace App\Controllers\Gateways;
	
	
	use App\Controllers\Gateways\SDK\AfrikasTalkingAPI;
	use App\Controllers\Gateways\SDK\NexmoAPI;
	use App\Controllers\Gateways\SDK\TelnyxAPI;
	use App\Controllers\Gateways\SDK\TwilioAPI;
	
	class Gateways {
		public static $gateways = [
			'afrikastalking' => AfrikasTalkingAPI::class,
			'telynx' => TelnyxAPI::class,
			'nexmo' => NexmoAPI::class,
			'twilio' => TwilioAPI::class
		];
		
		public static function Run(  ) {
		
		}
	}
