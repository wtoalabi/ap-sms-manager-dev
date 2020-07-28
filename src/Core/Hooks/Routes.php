<?php
	/**
	 * Created by Alabi Olawale
	 * Date: 08/07/2020
	 */
	
	namespace App\Core\Hooks;
	
	use App\Core\Configs\Router;
	use function AppsBay_Main_Config\config;
	
	class Routes {
		public static function Load() {
			add_action( 'rest_api_init', function () {
				self::Register();
			} );
		}
		
			/*Registering all the required rest endpoints*/
		private static function Register() {
			Router::Post( "reports", "Messages\MessagesController@index" );
			Router::Post( "send-sms", "Messages\MessagesController@store" );
			Router::Post( "list-gateways", "Gateways\GatewayControllers@index" );
			Router::Patch( "gateways", "Gateways\GatewayControllers@update" );
			Router::Patch( "delete-gateways", "Gateways\GatewayControllers@delete" );
			Router::Post( "save-gateways", "Gateways\GatewayControllers@store" );
			Router::Post( "groups", "Groups\GroupsController@index" );
			Router::Post( "save-group", "Groups\GroupsController@store" );
			Router::PATCH( "groups", "Groups\GroupsController@update" );
			Router::PATCH( "delete-groups", "Groups\GroupsController@delete" );
			Router::Get( "meta", "Metas\MetaController@index");
			Router::Get( "settings", "Settings\SettingsControllers@index" );
			Router::Post( "save-settings", "Settings\SettingsControllers@store" );
			Router::Get( "contacts", "Contacts\ContactsControllers@index" );
			Router::Post( "contacts", "Contacts\ContactsControllers@index" );
			Router::Post( "save-contacts", "Contacts\ContactsControllers@store" );
			Router::Post( "sync-contacts", "Contacts\ContactsControllers@sync" );
			Router::PATCH( "contacts", "Contacts\ContactsControllers@update" );
			Router::PATCH( "move-contacts", "Contacts\ContactsControllers@moveContacts" );
			Router::PATCH( "delete-contacts", "Contacts\ContactsControllers@delete" );
		}
	}
