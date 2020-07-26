<?php
	
	namespace App\Models\Settings;
	use App\Models\Base\BaseModel;
	
	class Setting extends BaseModel {
		protected $fillable = ['settings'];
		protected $casts = [
			'settings'=>'json'
		];
	}
