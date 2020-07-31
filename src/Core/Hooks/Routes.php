<?php
	/**
	 * Created by Alabi Olawale
	 * Date: 08/07/2020
	 */

	namespace AppsBay\Core\Hooks;

	use AppsBay\Core\Configs\Router;
	use function AppsBay_Main_Config\config;

class Routes {
	public static function Load() {
		add_action(
			'rest_api_init',
			function () {
				self::register();
			}
		);
	}

		/*Registering all the required rest endpoints*/
	private static function register() {
		Router::post( 'reports', 'Messages\MessagesController@index' );
		Router::post( 'send-sms', 'Messages\MessagesController@store' );
		Router::post( 'list-gateways', 'Gateways\GatewayControllers@index' );
		Router::patch( 'gateways', 'Gateways\GatewayControllers@update' );
		Router::patch( 'delete-gateways', 'Gateways\GatewayControllers@delete' );
		Router::post( 'save-gateways', 'Gateways\GatewayControllers@store' );
		Router::post( 'groups', 'Groups\GroupsController@index' );
		Router::post( 'save-group', 'Groups\GroupsController@store' );
		Router::patch( 'groups', 'Groups\GroupsController@update' );
		Router::patch( 'delete-groups', 'Groups\GroupsController@delete' );
		Router::get( 'meta', 'Metas\MetaController@index' );
		Router::get( 'settings', 'Settings\SettingsControllers@index' );
		Router::post( 'save-settings', 'Settings\SettingsControllers@store' );
		Router::get( 'contacts', 'Contacts\ContactsControllers@index' );
		Router::post( 'contacts', 'Contacts\ContactsControllers@index' );
		Router::post( 'save-contacts', 'Contacts\ContactsControllers@store' );
		Router::post( 'sync-contacts', 'Contacts\ContactsControllers@sync' );
		Router::patch( 'contacts', 'Contacts\ContactsControllers@update' );
		Router::patch( 'move-contacts', 'Contacts\ContactsControllers@move_contacts' );
		Router::patch( 'delete-contacts', 'Contacts\ContactsControllers@delete' );
	}
}
