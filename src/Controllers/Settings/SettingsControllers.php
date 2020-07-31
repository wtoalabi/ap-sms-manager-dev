<?php
	/**
	 * Created by Alabi Olawale
	 * Date: 12/07/2020
	 */

	namespace AppsBay\Controllers\Settings;

	use AppsBay\Models\Base\DataResponse;
	use AppsBay\Models\Settings\Setting;
	use AppsBay\Models\Settings\SettingResource;

class SettingsControllers {
	public function index() {
		$result = Setting::find( 1 );
		return DataResponse::single( $result, new SettingResource() );
	}

	public function store( $request ) {
		$data = $request->get_json_params();
		if ( $data ) {
			$setting = Setting::find( 1 );
			if ( $setting ) {
				$setting->update( $data );
			} else {
				Setting::create(
					array(
						'settings' => json_encode( $data['settings'] ),
					)
				);
			}
		}
		$result = Setting::find( 1 );

		return DataResponse::single( $result, new SettingResource() );
	}
}
