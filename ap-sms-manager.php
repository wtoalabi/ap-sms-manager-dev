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
	use function AppsBay_Main_Config\doOrDie;
	
	doOrDie();
	/*This is the entry point*/
	
	appsbay_sms_manager_main_initialize();
	register_activation_hook( __FILE__, 'appsbay_sms_manager_main_activate' );
	register_deactivation_hook( __FILE__, 'appsbay_sms_manager_main_deactivate' );
	
	function appsbay_sms_manager_main_initialize() {
		/*Let there be light. This is where we bootstrap the app.*/
		Instance::InitiateDB();
		add_action( 'init', [ "App\Core\Configs\Instance", "Initialize" ] );
	}
	
	function appsbay_sms_manager_main_activate() {
		/*During plugin activation*/
		Instance::Activate();
	}
	
	function appsbay_sms_manager_main_deactivate() {
		/*During plugin deactivation*/
		Instance::Deactivate();
	}
