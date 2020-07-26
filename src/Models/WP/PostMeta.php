<?php
	/**
	 * Created by Alabi Olawale
	 * Date: 16/07/2020
	 */
	
	namespace App\Models\Wp;
	
	
	use App\Models\Base\BaseModel;
	
	class PostMeta  extends BaseModel {
		protected $table="postmeta";
		protected $connection = "wp";
	}
