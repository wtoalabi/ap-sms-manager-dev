<?php
/**
 * Created by Alabi Olawale
 * Date: 08/07/2020
 */

namespace AppsBay\Core\Hooks;

use function AppsBay_Main_Config\config;

class Scripts {
	public static function load() {
		$version    = config( 'plugin_version' );
		$name       = config( 'plugin' );
		$path       = config( 'plugin_assets' ) . 'js/app.js';
		$fonts_path = config( 'plugin_assets' ) . 'fonts/fonts.css';
		wp_enqueue_style( 'apps_bay_sms_fonts', $fonts_path, array(), '0.0.1' );
		//print_r( config( "plugin" ) );
		//die();
		wp_enqueue_script( $name, $path, array(), $version, true );
		wp_localize_script(
			$name,
			'aps_globals_one',
			array(
				'currentVersion'   => config( 'plugin_version' ),
				'admin_url'        => config( 'admin_url' ),
				'pluginUrl'        => config( 'plugin_url' ),
				'installedVersion' => config( 'plugin_version' ),
				'token'            => wp_create_nonce( 'wp_rest' ),
				'restUrl'          => config( 'rest_url' ) . config( 'rest_namespace' ),
			)
		);

	}
}
