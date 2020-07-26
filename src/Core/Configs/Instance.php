<?php
	/**
	 * Created by Alabi Olawale
	 * Date: 08/07/2020
	 */
	
	namespace App\Core\Configs;
	
	use App\Core\Hooks\Hooks;
	use App\DB\Migrations\Migration;
	use Illuminate\Database\Capsule\Manager as Capsule;
	use Illuminate\Events\Dispatcher;
	use Illuminate\Container\Container;
	
	class Instance {
		public static function Activate() {
			Migration::Install();
		}
		
		public static function Deactivate() {
		
		}
		
		/**
		 * Initializing all the needed hooks.
		 */
		public static function Initialize() {
			Hooks::Bootstrap();
		}
		
		/**
		 *We create the initial DB instance with the required connections.
		 * The default connection handle all the plugin's created db tables db while the 'wp' connection handles access to wordpress default tables.
		 */
		public static function InitiateDB() {
			global $wpdb;
			$capsule = new Capsule;
			$capsule->addConnection( [
				'driver'    => 'mysql',
				'host'      => DB_HOST,
				'database'  => DB_NAME,
				'username'  => DB_USER,
				'password'  => DB_PASSWORD,
				'charset'   => 'utf8',
				'collation' => 'utf8_unicode_ci',
				'prefix'    => 'appsbay_sms_',
			], "default", );
			
			
			$capsule->addConnection( [
				'driver'    => 'mysql',
				'host'      => DB_HOST,
				'database'  => DB_NAME,
				'username'  => DB_USER,
				'password'  => DB_PASSWORD,
				'charset'   => 'utf8',
				'collation' => 'utf8_unicode_ci',
				'prefix'    => $wpdb->prefix
			], "wp" );
			$capsule->setEventDispatcher( new Dispatcher( new Container ) );
			$capsule->bootEloquent();
			$capsule->setAsGlobal();
		}
	}
