<?php
	/**
	 * Created by Alabi Olawale
	 * Date: 21/07/2020
	 */

	namespace AppsBay\DB\Migrations;

	use Illuminate\Database\Capsule\Manager as Capsule;

class MessageMigration01 {
	public static function up() {
		$table_name = 'messages';
		if ( ! Capsule::schema()->hasTable( $table_name ) ) {
			Capsule::schema()->create(
				$table_name,
				function ( $table ) {
					$table->bigIncrements( 'id' );
					$table->unsignedBigInteger( 'gateway_id' );
					$table->string( 'senderID' );
					$table->string( 'recipientsCount' );
					$table->string( 'status' );
					$table->string( 'response' );
					$table->string( 'groups' );
					$table->text( 'message' );
					$table->string( 'time' )->nullable();
					$table->json( 'metaData' )->nullable();
					$table->foreign( 'gateway_id' )->references( 'id' )->on( 'gateways' )->onDelete( 'CASCADE' );
					$table->timestamps();
				}
			);
		}
	}

	public static function down() {
		Capsule::schema()->dropIfExists( 'messages' );
	}
}
