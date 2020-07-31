<?php
	/**
	 * Created by Alabi Olawale
	 * Date: 17/07/2020
	 */
	namespace AppsBay\DB\Migrations;

	use AppsBay\Models\Groups\Group;

class SeedData {
	public static function run() {
		self::group();
		self::settings();
		self::contacts();
	}

	private static function group() {
		if ( ! Group::first() ) {
			$group       = new Group();
			$group->name = 'Default Group';
			$group->save();
		}
	}

	private static function settings() {

	}

	private static function contacts() {
	}
}
