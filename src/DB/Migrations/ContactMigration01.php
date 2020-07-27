<?php
	/**
	 * Created by Alabi Olawale
	 * Date: 11/07/2020
	 */
	
	namespace App\DB\Migrations;
	use Illuminate\Database\Capsule\Manager as Capsule;
	use Illuminate\Database\Schema\Blueprint;
	
	class ContactMigration01 {
		public static function Up( ) {
			$table_name = 'contacts';
			if ( !Capsule::schema()->hasTable( $table_name ) ) {
				Capsule::schema()->create( $table_name, function ( $table ) {
					$table->bigIncrements( 'id' );
					$table->unsignedBigInteger( 'group_id' );
					$table->string( 'number' );
					$table->string( 'source' );
					$table->foreign( 'group_id' )->references( 'id' )->on( 'groups' )->onDelete( 'CASCADE' );
					$table->timestamps();
				} );
			}
		}
		
		public static function Down(  ) {
			Capsule::schema()->dropIfExists('contacts');
		}
	}
