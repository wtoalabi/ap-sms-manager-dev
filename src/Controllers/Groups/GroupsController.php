<?php
	/**
	 * Created by Alabi Olawale
	 * Date: 18/07/2020
	 */
	
	namespace App\Controllers\Groups;
	
	
	use App\Models\Base\DataResponse;
	use App\Models\Contacts\Contact;
	use App\Models\Contacts\ContactsCollection;
	use App\Models\Groups\Group;
	use App\Models\Groups\GroupsCollection;
	
	class GroupsController {
		public function index( $request ) {
			$result = ( new Group() )->filterQuery( $request );
			
			return DataResponse::With( $result, GroupsCollection::class );
		}
		
		public function store( $request ) {
			$groupName = $request->get_json_params()['name'];
			if ( $groupName ) {
				Group::create(['name'=>$groupName]);
			}
			$result = ( new Group() )->filterQuery( $request );
			
			return DataResponse::With( $result, GroupsCollection::class, 201, "Group Added Successfully!!!" );
			
		}
		public function update( $request ) {
			$data  = $request->get_json_params();
			$group = Group::find( $data['id'] );
			if ( $group->update( $data ) ) {
				$message = "Group updated successfully!";
				$code    = 201;
			} else {
				$code    = 500;
				$message = "Unable to save Group. Try again later!";
			}
			
			$result = ( new Group() )->filterQuery( $request );
			
			return DataResponse::With( $result,
				GroupsCollection::class,
				$code,
				$message );
		}
		
		public function delete( $request ) {
			$toBeDeleted = collect( $request->get_json_params()['group_ids'] );
			$toBeDeleted->each( function ( $id ) {
				if ( $id === 1 ) {
					return;
				}
				$group = Group::find( $id );
				if ( $group ) {
					if ( $group->contacts_count > 0 ) {
						static::moveContactGroup( $group );
					}
					$group->delete();
				}
			} );
			$result = ( new Group() )->filterQuery( $request );
			
			return DataResponse::With( $result, GroupsCollection::class, null, "Group(s) deleted successfully!" );
		}
		
		private static function moveContactGroup( $group ) {
			$defaultGroupID = Group::where( 'name', 'Default Group' )->first()->id;
			$group->contacts->each( function ( $contact ) use ( $defaultGroupID ) {
				$contact->update( [ 'group_id' => $defaultGroupID ] );
			} );
		}
	}
