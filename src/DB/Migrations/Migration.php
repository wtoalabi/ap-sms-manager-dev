<?php

	namespace AppsBay\DB\Migrations;

	use Illuminate\Database\Capsule\Manager as Capsule;


class Migration {
	public static function install() {
		GroupMigration01::up();
		ContactMigration01::up();
		SettingsMigration01::up();
		GatewaysMigration01::up();
		MessageMigration01::up();
		SeedData::run();
	}

	public static function un_install() {
		ContactMigration01::down();
		MessageMigration01::down();
		GroupMigration01::down();
		GatewaysMigration01::down();
		SettingsMigration01::down();
	}
}
