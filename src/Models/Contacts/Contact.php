<?php
	
	namespace App\Models\Contacts;
	use App\Models\Base\BaseModel;
	use App\Models\Groups\Group;
	use Illuminate\Database\Eloquent\Model;
	
	/**
	 * Created by Alabi Olawale
	 * Date: 11/07/2020
	 */
	
	
	class Contact extends BaseModel {
		protected $fillable =['number','source','group_id'];
		public function group() {
			return $this->belongsTo(Group::class);
		}
	}
