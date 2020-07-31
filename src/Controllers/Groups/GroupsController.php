<?php
/**
 * Created by Alabi Olawale
 * Date: 18/07/2020
 */

namespace AppsBay\Controllers\Groups;

use AppsBay\Models\Base\DataResponse;
use AppsBay\Models\Groups\Group;
use AppsBay\Models\Groups\GroupsCollection;

class GroupsController {
	public function index( $request ) {
		$result = ( new Group() )->filter_query( $request );

		return DataResponse::with( $result, GroupsCollection::class );
	}

	public function store( $request ) {
		$group_name = $request->get_json_params()['name'];
		if ( $group_name ) {
			Group::create( array( 'name' => $group_name ) );
		}
		$result = ( new Group() )->filter_query( $request );

		return DataResponse::with( $result, GroupsCollection::class, 201, 'Group Added Successfully!!!' );

	}

	public function update( $request ) {
		$data  = $request->get_json_params();
		$group = Group::find( $data['id'] );
		if ( $group->update( $data ) ) {
			$message = 'Group updated successfully!';
			$code    = 201;
		} else {
			$code    = 500;
			$message = 'Unable to save Group. Try again later!';
		}

		$result = ( new Group() )->filter_query( $request );

		return DataResponse::with(
			$result,
			GroupsCollection::class,
			$code,
			$message
		);
	}

	public function delete( $request ) {
		$to_be_deleted = collect( $request->get_json_params()['group_ids'] );
		$to_be_deleted->each(
			function ( $id ) {
				if ( 1 === $id ) {
					return;
				}
				$group = Group::find( $id );
				if ( $group ) {
					if ( $group->contacts_count > 0 ) {
						static::move_contact_group( $group );
					}
					$group->delete();
				}
			}
		);
		$result = ( new Group() )->filter_query( $request );

		return DataResponse::with( $result, GroupsCollection::class, null, 'Group(s) deleted successfully!' );
	}

	private static function move_contact_group( $group ) {
		$default_group_id = Group::where( 'name', 'Default Group' )->first()->id;
		$group->contacts->each(
			function ( $contact ) use ( $default_group_id ) {
				$contact->update( array( 'group_id' => $default_group_id ) );
			}
		);
	}
}
