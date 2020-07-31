<?php
	/**
	 * Created by Alabi Olawale
	 * Date: 11/07/2020
	 */

	namespace AppsBay\DB\Migrations;

	use Illuminate\Database\Capsule\Manager as Capsule;
	use Illuminate\Database\Schema\Blueprint;

class GatewaysMigration01 {
	public static function up() {
		$table_name = 'gateways';
		if ( ! Capsule::schema()->hasTable( $table_name ) ) {
			Capsule::schema()->create(
				$table_name,
				function ( $table ) {
					$table->bigIncrements( 'id' );
					$table->string( 'name' );
					$table->text( 'description' )->nullable();

					$table->string( 'apiName' );
					$table->string( 'apiKey' );
					$table->string( 'username' );
					$table->boolean( 'isDefault' )->default( false );
					$table->text( 'metaData' )->nullable();

					$table->timestamps();
				}
			);
		}
	}

	public static function down() {
		Capsule::schema()->dropIfExists( 'gateways' );
	}
}
