<?php
	/**
	 * Created by Alabi Olawale
	 * Date: 11/07/2020
	 */

	namespace AppsBay\DB\Migrations;

	use Illuminate\Database\Capsule\Manager as Capsule;
	use Illuminate\Database\Schema\Blueprint;

class SettingsMigration01 {
	public static function up() {
		$table_name = 'settings';
		if ( ! Capsule::schema()->hasTable( $table_name ) ) {
			Capsule::schema()->create(
				$table_name,
				function ( $table ) {
					$table->increments( 'id' );
					$table->json( 'settings' )->nullable();
					$table->timestamps();
				}
			);
		}
	}

	public static function down() {
		Capsule::schema()->dropIfExists( 'settings' );
	}
}
