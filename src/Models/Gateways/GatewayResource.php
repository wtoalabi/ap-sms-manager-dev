<?php
	/**
	 * Created by Alabi Olawale
	 * Date: 19/07/2020
	 */
	
	namespace App\Models\Gateways;
	
	class GatewayResource {
		public function transform( $gateway ) {
			$key = substr( $gateway->apiKey, 0, (strlen($gateway->apiKey)/8));
			$username = substr( $gateway->username, 0, (strlen($gateway->username)/2));
			return [
				'id' => $gateway->id,
				'name' => $gateway->name,
				'description' => $gateway->description,
				'apiName' => $gateway->apiName,
				'apiKey' => "$key****",
				'username' => "$username****",
				'isDefault' => $gateway->isDefault,
			];
		}
	}
