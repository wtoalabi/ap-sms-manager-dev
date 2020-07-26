<?php
	/**
	 * Created by Alabi Olawale
	 * Date: 08/07/2020
	 */
	
	namespace App\Core\Hooks;
	
	
	use function Config\config;
	
	class Styles {
		public static function Load() {
			$name = config( "plugin" ).'_apps_bay_sms';
			$version = config( "plugin_version" );
			$path = config( "plugin_assets" ). 'styles/app.css';
			wp_enqueue_style( $name,  $path, [],$version , "all" );
		}
	}
