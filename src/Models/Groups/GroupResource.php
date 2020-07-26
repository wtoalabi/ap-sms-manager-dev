<?php
	/**
	 * Created by Alabi Olawale
	 * Date: 12/07/2020
	 */
	
	namespace App\Models\Groups;
	
	
	
	class GroupResource{
		
		public function transform( $group ) {
			return [
				'id' => $group->id,
				'name' => $group->name,
				'contacts' => $group->contacts_count
			];
		}
	}
