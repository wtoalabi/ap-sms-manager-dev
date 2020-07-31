<?php
/**
 * Created by AppsBay
 * Date: 25/07/2020
 * Plugin Name: AP SMS Manager
 * Plugin URI: https://sms.appsbay.xyz
 * Description: This plugin helps you send bulk sms easily.
 * Author: AppsBay
 * Version: 0.0.4
 * Author URI: https://appsbay.xyz
 */
require __DIR__ . '/vendor/autoload.php';

use AppsBay\Core\Configs\Instance;
use function AppsBay_Main_Config\do_or_die;

do_or_die();
appsbay_sms_manager_main_initialize();
register_activation_hook( __FILE__, 'appsbay_sms_manager_main_activate' );
register_deactivation_hook( __FILE__, 'appsbay_sms_manager_main_deactivate' );
/**
 * Let there be light. This is where we bootstrap the app.
 */
function appsbay_sms_manager_main_initialize() {
	Instance::initiate_db();
	add_action( 'init', array( 'AppsBay\Core\Configs\Instance', 'initialize' ) );
}

/**
 * During plugin activation
 */
function appsbay_sms_manager_main_activate() {
	Instance::activate();
}

/**
 * During plugin deactivation
 */
function appsbay_sms_manager_main_deactivate() {
	Instance::deactivate();
}
