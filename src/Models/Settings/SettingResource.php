<?php
	/**
	 * Created by Alabi Olawale
	 * Date: 12/07/2020
	 */
	
	namespace App\Models\Settings;
	
	class SettingResource{
		
		public function transform( $data ) {
			return [
				'settings' => $data->settings
			];
		}
	}
