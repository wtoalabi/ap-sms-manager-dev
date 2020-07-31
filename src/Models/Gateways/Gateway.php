<?php
	/**
	 * Created by Alabi Olawale
	 * Date: 19/07/2020
	 */

	namespace AppsBay\Models\Gateways;

	use AppsBay\Models\Base\BaseModel;
	use AppsBay\Models\Messages\Message;

class Gateway extends BaseModel {
	protected $fillable = array( 'name', 'description', 'apiName', 'apiKey', 'username', 'metaData', 'isDefault' );
	protected $casts    = array(
		'metaData'  => 'json',
		'isDefault' => 'bool',
	);
	protected $with     = array( 'messages' );

	public function messages() {
		return $this->hasMany( Message::class );
	}
}
