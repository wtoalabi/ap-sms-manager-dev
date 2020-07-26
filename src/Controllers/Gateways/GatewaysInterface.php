<?php
	/**
	 * Created by Alabi Olawale
	 * Date: 19/07/2020
	 */
	
	namespace App\Controllers\Gateways;
	
	
	interface GatewaysInterface {
		public function send( $data );
	}
