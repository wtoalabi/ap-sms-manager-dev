<?php
	/**
	 * Created by Alabi Olawale
	 * Date: 11/07/2020
	 */
	
	namespace App\DB\Migrations;
	
	use Illuminate\Database\Capsule\Manager as Capsule;
	use Illuminate\Database\Schema\Blueprint;
	
	class GroupMigration01 {
		public static function Up() {
			$table_name = 'groups';
			if ( ! Capsule::schema()->hasTable( $table_name ) ) {
				Capsule::schema()->create( $table_name, function ( $table ) {
					$table->bigIncrements( 'id' );
					$table->string( 'name' );
					$table->timestamps();
				} );
			}
			
		}
		
		public static function Down() {
			Capsule::schema()->dropIfExists( 'groups' );
		}
	}
