<?php
	/**
	 * Created by Alabi Olawale
	 * Date: 21/07/2020
	 */

	namespace AppsBay\Models\Messages;

class MessagesCollection {
	public static function collect( $collection ) {
		return collect( $collection )->map(
			function ( $message ) {
				return ( new MessageResource() )->transform( $message );
			}
		);
	}
}
