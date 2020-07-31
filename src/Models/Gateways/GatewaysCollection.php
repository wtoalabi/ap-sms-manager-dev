<?php
	/**
	 * Created by Alabi Olawale
	 * Date: 19/07/2020
	 */

	namespace AppsBay\Models\Gateways;

class GatewaysCollection {
	public static function collect( $collection ) {
		return collect( $collection )->map(
			function ( $contact ) {
				return ( new GatewayResource() )->transform( $contact );
			}
		);
	}
}
