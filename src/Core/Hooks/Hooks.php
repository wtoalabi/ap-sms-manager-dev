<?php
	/**
	 * Created by Alabi Olawale
	 * Date: 08/07/2020
	 */
	
	namespace App\Core\Hooks;
	
	class Hooks {
		/*
		 * If user is in the admin dashboard, we load  the required scripts, locales and style
		 * After this, we load the menu routes and register the menu links.
		 * */
		public static function Bootstrap() {
			if ( is_admin() ) {
				Scripts::Load();
				Styles::Load();
				Locale::Load();
			}
			Routes::Load();
			Menu::Load();
		}
	}
