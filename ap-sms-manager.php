<?php
	
	/**
	 * Created by Alabi Olawale
	 * Date: 25/07/2020
	 * Plugin Name: AP SMS Manager
	 * Plugin URI: https://sms.appsbay.xyz
	 * Description: This plugin helps you send bulk sms easily.
	 * Author: AppsBay
	 * Version: 0.0.1
	 * Author URI: https://appsbay.xyz
	 */
	require __DIR__ . '/vendor/autoload.php';
	
	use App\Core\Configs\Instance;
	
	\Config\doOrDie();
	/*This is the entry point*/
	
	Initialize();
	register_activation_hook( __FILE__, 'apps_bay_sms_manager_activate' );
	register_deactivation_hook( __FILE__, 'apps_bay_sms_manager_deactivate' );
	
	function Initialize() {
		/*Let there be light. This is where we bootstrap the app.*/
		Instance::InitiateDB();
		add_action( 'init', [ "App\Core\Configs\Instance", "Initialize" ] );
	}
	
	function apps_bay_sms_manager_activate() {
		/*During plugin activation*/
		Instance::Activate();
	}
	
	function apps_bay_sms_manager_deactivate() {
		/*During plugin deactivation*/
		Instance::Deactivate();
	}
