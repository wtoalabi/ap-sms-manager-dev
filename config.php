<?php

namespace AppsBay_Main_Config;

function config( $key ) {
	$config = array(
		'plugin_version'   => '0.0.3',
		'rest_namespace'   => 'apps_bay/v1',
		'controllers_path' => 'AppsBay\Controllers',
		'rest_url'         => site_url() . '/?rest_route=/',
		'admin_url'        => admin_url(),
		'plugin'           => plugin_basename( __DIR__ ),
		'plugin_url'       => plugin_dir_url( __FILE__ ) . 'src/',
		'plugin_path'      => plugin_dir_path( __FILE__ ) . 'src/',
		'plugin_assets'    => plugin_dir_url( __FILE__ ) . 'src/Assets/',
	);
	$value  = $config[ $key ];
	if ( null === $value ) {
		return new \Exception( "$key Not found in configs" );
	} else {
		return $value;
	}
}

function do_or_die() {

	if ( ! defined( 'ABSPATH' ) ) {
		die( 'Get away you silly human!' );
	}
}
