<?php
	/**
	 * Created by Alabi Olawale
	 * Date: 12/07/2020
	 */

	namespace AppsBay\Models\Contacts;

	use AppsBay\Models\Groups\GroupResource;

class ContactResource {
	public function transform( $contact ) {
		return array(
			'id'     => $contact->id,
			'number' => $contact->number,
			'source' => $contact->source,
			'group'  => ( new GroupResource() )->transform( $contact->group ),
		);
	}
}

