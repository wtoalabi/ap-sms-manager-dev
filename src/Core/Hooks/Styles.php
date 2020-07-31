<?php
	/**
	 * Created by Alabi Olawale
	 * Date: 08/07/2020
	 */

	namespace AppsBay\Core\Hooks;

	use function AppsBay_Main_Config\config;

class Styles {
	public static function load() {
		$name    = config( 'plugin' ) . '_apps_bay_sms';
		$version = config( 'plugin_version' );
		$path    = config( 'plugin_assets' ) . 'styles/app.css';
		wp_enqueue_style( $name, $path, array(), $version, 'all' );
	}
}
