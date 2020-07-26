<?php
	/**
	 * Created by Alabi Olawale
	 * Date: 12/07/2020
	 */
	
	namespace App\Controllers\Settings;
	
	
	use App\Models\Base\DataResponse;
	use App\Models\Settings\Setting;
	use App\Models\Settings\SettingResource;
	
	class SettingsControllers {
		public function index( ) {
			$result = Setting::find(1);
			return DataResponse::Single($result, new SettingResource());
		}
		
		public function store($request) {
			$data = $request->get_json_params();
			if($data){
				$setting = Setting::find(1);
				if($setting){
					$setting->update($data);
				}else{
				Setting::create([
						'settings' => json_encode( $data['settings'])
					]);
				}
			}
			$result = Setting::find(1);
			
			return DataResponse::Single($result, new SettingResource(),);
		}
	}
