<?php
	/**
	 * Created by Alabi Olawale
	 * Date: 12/07/2020
	 */
	
	namespace App\Models\Contacts;
	
	class ContactsCollection {
		public static function Collect( $collection ) {
			return collect( $collection )->map( function ( $contact ) {
				return ( new ContactResource() )->transform( $contact );
			} );
		}
	}
