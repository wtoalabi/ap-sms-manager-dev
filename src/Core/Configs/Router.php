<?php
	/**
	 * Created by Alabi Olawale
	 * Date: 08/07/2020
	 */

	namespace AppsBay\Core\Configs;

	use WP_REST_Server;
	use function AppsBay_Main_Config\config;

		/*The Router class registers all the helper methods needed to generate a restful endpoints */
class Router {

	/**
	 * @param $endpoint
	 * @param $controller
	 * @param bool       $auto_action
	 */
	public static function get( $endpoint, $controller, $auto_action = false ) {
		self::register( $endpoint, $controller, WP_REST_Server::READABLE, $auto_action );
	}

	/**
	 * @param $endpoint
	 * @param $controller
	 * @param bool       $auto_action
	 */
	public static function post( $endpoint, $controller, $auto_action = false ) {
		self::register( $endpoint, $controller, WP_REST_Server::CREATABLE, $auto_action );
	}

	/**
	 * @param $endpoint
	 * @param $controller
	 * @param bool       $auto_action
	 */
	public static function patch( $endpoint, $controller, $auto_action = false ) {
		self::register( $endpoint, $controller, WP_REST_Server::EDITABLE, $auto_action );
	}

	/**
	 * @param $endpoint
	 * @param $controller
	 * @param bool       $auto_action
	 */
	public static function put( $endpoint, $controller, $auto_action = false ) {
		self::register( $endpoint, $controller, WP_REST_Server::EDITABLE, $auto_action );
	}

	/**
	 * @param $endpoint
	 * @param $controller
	 * @param bool       $auto_action
	 */
	public static function delete( $endpoint, $controller, $auto_action = false ) {
		self::register( $endpoint, $controller, WP_REST_Server::DELETABLE, $auto_action );
	}

	/**
	 * @param $endpoint
	 * @param $controller
	 */
	public static function rest( $endpoint, $controller ) {
		self::get( $endpoint, $controller, 'index' );
		self::post( $endpoint, $controller, 'store' );
		self::put( $endpoint, $controller, 'update' );
		self::patch( $endpoint, $controller, 'update' );
		self::delete( $endpoint, $controller, 'delete' );

	}

	/**
	 * @param $endpoint
	 * @param $controller
	 * @param $method
	 * @param bool       $auto_action
	 *
	 * @return null
	 */
	protected static function register( $endpoint, $controller, $method, $auto_action = false ) {
		$namespace             = config( 'rest_namespace' );
		$controllers_path       = config( 'controllers_path' );
		list($class, $action ) = get_action( $controller );
		if ( ! $action && $auto_action != false ) {
			$action = $auto_action;
		}

		register_rest_route(
			$namespace,
			$endpoint,
			array(
				'methods'  => $method,
				'callback' => array( "$controllers_path\\$class", $action ),
			)
		);

		return null;
	}
}

function get_action( $controller ) {
	return preg_split( '/@/', $controller, '2' );
}
