<?php
	/**
	 * Created by Alabi Olawale
	 * Date: 21/07/2020
	 */
	
	namespace App\Models\Messages;
	
	class MessagesCollection {
		public static function Collect( $collection ) {
			return collect( $collection )->map( function ( $message ) {
				return ( new MessageResource() )->transform( $message );
			} );
		}
	}
