<?php
	/**
	 * Created by Alabi Olawale
	 * Date: 12/07/2020
	 */

	namespace AppsBay\Models\Groups;

class GroupResource {

	public function transform( $group ) {
		return array(
			'id'       => $group->id,
			'name'     => $group->name,
			'contacts' => $group->contacts_count,
		);
	}
}
