<?php
	/**
	 * Created by Alabi Olawale
	 * Date: 08/07/2020
	 */

	namespace AppsBay\Core\Hooks;

class Hooks {
	/*
	 * If user is in the admin dashboard, we load  the required scripts, locales and style
	 * After this, we load the menu routes and register the menu links.
	 * */
	public static function bootstrap() {
		if ( is_admin() ) {
			Scripts::load();
			Styles::load();
			Locale::load();
		}
		Routes::load();
		Menu::load();
	}
}
