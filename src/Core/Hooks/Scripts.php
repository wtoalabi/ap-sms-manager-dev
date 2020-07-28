<?php
	/**
	 * Created by Alabi Olawale
	 * Date: 08/07/2020
	 */
	
	namespace App\Core\Hooks;
	
	
	use function AppsBay_Main_Config\config;
	
	class Scripts {
		public static function Load() {
			$name      = config( "plugin" );
			$version   = config( "plugin_version" );
			$path      = config( "plugin_assets" ) . 'js/app.js';
			$fontsPath = config( "plugin_assets" ) . 'fonts/fonts.css';
			wp_enqueue_style( "apps_bay_sms_fonts", $fontsPath, [], "0.0.1", );
			wp_enqueue_script( $name, $path, [], $version, true );
			wp_localize_script( $name, "aps_globals_one", [
				'currentVersion'   => "0.0.1",
				'admin_url' => config("admin_url"),
				'pluginUrl'        => config( "plugin_url" ),
				'installedVersion' => "0.0.1",
				'token'            => wp_create_nonce( "wp_rest" ),
				'restUrl'      => config( "rest_url" ) . config( "rest_namespace" ),
			] );
			
		}
	}
