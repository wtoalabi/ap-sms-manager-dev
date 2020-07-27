<?php
	/**
	 * Created by Alabi Olawale
	 * Date: 17/07/2020
	 */
	
	namespace App\DB\Migrations;
	
	
	use App\Models\Groups\Group;
	
	class SeedData {
		public static function Run() {
			self::Group();
			self::Settings();
			self::Contacts();
		}
		
		private static function Group() {
			if ( !Group::first() ) {
				$group       = new Group();
				$group->name = "Default Group";
				$group->save();
			}
		}
		
		private static function Settings() {
		
		}
		
		private static function Contacts() {
		}
	}
