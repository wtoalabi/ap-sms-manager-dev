<?php
	/**
	 * Created by Alabi Olawale
	 * Date: 13/07/2020
	 */
	
	namespace App\Models\Groups;
	
	
	class GroupsCollection {
		public static function Collect( $collection ) {
			return collect( $collection )->map( function ( $group ) {
				return ( new GroupResource() )->transform( $group );
			} );
		}
	}
