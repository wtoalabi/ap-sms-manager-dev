<?php
	/**
	 * Created by Alabi Olawale
	 * Date: 21/07/2020
	 */

	namespace AppsBay\Models\Messages;

	use AppsBay\Models\Base\BaseModel;
	use AppsBay\Models\Gateways\Gateway;

class Message extends BaseModel {
	protected $fillable = array( 'gateway_id', 'senderID', 'status', 'response', 'recipientsCount', 'groups', 'message', 'time', 'metaData' );

	public function gateway() {
		return $this->belongsTo( Gateway::class );
	}
}
