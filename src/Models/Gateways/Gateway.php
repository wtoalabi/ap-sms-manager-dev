<?php
	/**
	 * Created by Alabi Olawale
	 * Date: 19/07/2020
	 */
	
	namespace App\Models\Gateways;
	
	
	use App\Models\Base\BaseModel;
	use App\Models\Messages\Message;
	
	class Gateway extends BaseModel {
		protected $fillable = ['name','description', 'apiName','apiKey','username','metaData','isDefault'];
		protected $casts = [
			'metaData' => 'json',
			'isDefault' => 'bool'
		];
		protected $with= ['messages'];
		
		public function messages(  ) {
			return $this->hasMany( Message::class);
		}
	}
