<?php

	namespace AppsBay\Models\Contacts;

	use AppsBay\Models\Base\BaseModel;
	use AppsBay\Models\Groups\Group;
	use Illuminate\Database\Eloquent\Model;

	/**
	 * Created by Alabi Olawale
	 * Date: 11/07/2020
	 */


class Contact extends BaseModel {
	protected $fillable = array( 'number', 'source', 'group_id' );
	public function group() {
		return $this->belongsTo( Group::class );
	}
}
