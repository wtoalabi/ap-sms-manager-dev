<?php
	/**
	 * Created by Alabi Olawale
	 * Date: 21/07/2020
	 */
	
	namespace App\Models\Messages;
	
	
	use App\Models\Base\BaseModel;
	use App\Models\Gateways\Gateway;
	
	class Message extends BaseModel {
		protected $fillable = ['gateway_id','senderID','status','response','recipientsCount','groups','message','time','metaData'];
		
		public function gateway(  ) {
			return $this->belongsTo( Gateway::class);
		}
	}
