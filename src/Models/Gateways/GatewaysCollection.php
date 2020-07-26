<?php
	/**
	 * Created by Alabi Olawale
	 * Date: 19/07/2020
	 */
	
	namespace App\Models\Gateways;
	
	
	class GatewaysCollection {
		public static function Collect( $collection ) {
			return collect( $collection )->map( function ( $contact ) {
				return ( new GatewayResource() )->transform( $contact );
			} );
		}
	}
