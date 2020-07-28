<?php
	/**
	 * Created by Alabi Olawale
	 * Date: 08/07/2020
	 */
	
	namespace App\Core\Hooks;
	
	
	use WPHelper\AdminMenuPage;
	use function AppsBay_Main_Config\config;
	
	class Menu {
		public static function Load() {
			self::MainMenu();
		}
		/*The plugin only makes use of one wordpress page/route
		This is where it is created.
		*/
		private static function MainMenu() {
			$main_menu        = [
				'title'      => 'AP SMS Manager',
				'menu_title' => 'AP SMS Manager',
				'capability' => 'manage_options',
				'slug'       => 'sms_manager_dashboard',
				'render'     => config( "plugin_path") . "Templates/dashboard.php",
				'icon_url'   => "dashicons-buddicons-pm",
				'position'   => 1000
			];
			
			$admin_main_menu  = new AdminMenuPage( $main_menu );
			$admin_main_menu->setup();
		}
	}
