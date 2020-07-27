<?php
	
	namespace App\DB\Migrations;
	use Illuminate\Database\Capsule\Manager as Capsule;
	
	
	class Migration  {
		public static function Install(  ) {
			GroupMigration01::Up();
			ContactMigration01::Up();
			SettingsMigration01::Up();
			GatewaysMigration01::Up();
			MessageMigration01::Up();
			SeedData::Run();
		}
		
		public static function UnInstall(  ) {
			ContactMigration01::Down();
			MessageMigration01::Down();
			GroupMigration01::Down();
			GatewaysMigration01::Down();
			SettingsMigration01::Down();
		}
	}
