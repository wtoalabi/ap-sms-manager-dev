<?php
/**
 * Created by Alabi Olawale
 * Date: 08/07/2020
 */

namespace AppsBay\Core\Configs;

use AppsBay\Core\Hooks\Hooks;
use AppsBay\DB\Migrations\Migration;
use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;

class Instance {
	public static function activate() {
		Migration::install();
	}

	public static function deactivate() {

	}

	/**
	 * Initializing all the needed hooks.
	 */
	public static function initialize() {
		Hooks::bootstrap();
	}

	/**
	 * We create the initial DB instance with the required connections.
	 * The default connection handle all the plugin's created db tables db while the 'wp' connection handles access to WordPress default tables.
	 */
	public static function initiate_db() {
		global $wpdb;
		$capsule = new Capsule();
		$capsule->addConnection(
			array(
				'driver'    => 'mysql',
				'host'      => DB_HOST,
				'database'  => DB_NAME,
				'username'  => DB_USER,
				'password'  => DB_PASSWORD,
				'charset'   => 'utf8',
				'collation' => 'utf8_unicode_ci',
				'prefix'    => 'appsbay_sms_',
			),
			'default'
		);

		$capsule->addConnection(
			array(
				'driver'    => 'mysql',
				'host'      => DB_HOST,
				'database'  => DB_NAME,
				'username'  => DB_USER,
				'password'  => DB_PASSWORD,
				'charset'   => 'utf8',
				'collation' => 'utf8_unicode_ci',
				'prefix'    => $wpdb->prefix,
			),
			'wp'
		);
		$capsule->setEventDispatcher( new Dispatcher( new Container() ) );
		$capsule->bootEloquent();
		$capsule->setAsGlobal();
	}
}
