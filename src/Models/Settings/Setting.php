<?php

	namespace AppsBay\Models\Settings;

	use AppsBay\Models\Base\BaseModel;

class Setting extends BaseModel {
	protected $fillable = array( 'settings' );
	protected $casts    = array(
		'settings' => 'json',
	);
}
