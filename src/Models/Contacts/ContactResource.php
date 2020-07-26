<?php
	/**
	 * Created by Alabi Olawale
	 * Date: 12/07/2020
	 */
	
	namespace App\Models\Contacts;
	use App\Models\Groups\GroupResource;
	
	class ContactResource {
		public function transform( $contact ) {
			return [
				'id' => $contact->id,
				'number' => $contact->number,
				'source' => $contact->source,
				'group' => (new GroupResource())->transform( $contact->group),
			];
		}
	}

