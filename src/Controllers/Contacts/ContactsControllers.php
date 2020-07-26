<?php
	/**
	 * Created by Alabi Olawale
	 * Date: 12/07/2020
	 */
	
	namespace App\Controllers\Contacts;
	
	use App\Controllers\Contacts\Syncs\Woocommerce;
	use App\Models\Base\DataResponse;
	use App\Models\Contacts\Contact;
	use App\Models\Contacts\ContactsCollection;
	
	class ContactsControllers {
		public function index( $request ) {
			$result = ( new Contact() )->filterQuery( $request );
			return DataResponse::With( $result, ContactsCollection::class );
		}
		
		public function store( $request ) {
			$data    = collect( $request->get_json_params() );
			$numbers = collect( $data['numbers'] );
			$source  = $data['source'];
			$groupID = $data['group_id'];
			if ( $numbers->isNotEmpty() ) {
				$numbers->each( function ( $number ) use ( $source, $groupID ) {
					$data = [ 'source' => $source, 'groupID' => $groupID, 'number' => $number ];
					self::Save( $data );
				} );
				$result = ( new Contact() )->filterQuery( $request );
				
				return DataResponse::With( $result, ContactsCollection::class, null, "Contacts Added Successfully!!!" );
			}
		}
		
		public function sync( $request ) {
			
			$availableSources = [
				1 => Woocommerce::class
			];
			$data             = $request->get_json_params();
			$plugin           = $data['plugin'];
			$group            = $data['group'];
			$pluginClass      = $availableSources[ $plugin ];
			$count = (new $pluginClass( $group ))->run($group);
			if($count){
				$result = ( new Contact() )->filterQuery( $request );
				
				return DataResponse::With( $result,
					ContactsCollection::class,
					201,
					"$count contact numbers were found and added successfully!!!" );
			}
		}
		
		public function update( $request ) {
			$data = $request->get_json_params();
			
			$contact = Contact::find( $data['id'] );
			if ( $contact->update( $data ) ) {
				$message = "Contact updated successfully!";
				$code    = 201;
			} else {
				$code    = 500;
				$message = "Unable to save Contact. Try again later!";
			}
			
			$result = ( new Contact() )->filterQuery( $request );
			
			return DataResponse::With( $result,
				ContactsCollection::class,
				$code,
				$message );
		}
		
		public function moveContacts( $request ) {
			$data     = collect( $request->get_json_params() );
			$contacts = collect( $data['contactsIDs'] );
			$group    = $data['groupID'];
			$contacts->each( function ( $contactID ) use ( $group ) {
				$contact           = Contact::find( $contactID );
				$contact->group_id = $group;
				$contact->save();
			} );
			$result = ( new Contact() )->filterQuery( $request );
			
			return DataResponse::With( $result, ContactsCollection::class, null, "Contacts Updated Successfully!" );
		}
		
		public function delete( $request ) {
			$toBeDeleted = collect( $request->get_json_params() );
			$toBeDeleted->each( function ( $id ) {
				$contact = Contact::find( $id );
				if ( $contact ) {
					$contact->delete();
				}
			} );
			$result = ( new Contact() )->filterQuery( $request );
			
			return DataResponse::With( $result, ContactsCollection::class, null, "Contact(s) deleted successfully!" );
		}
		
		public static function Save( $data ) {
			$contact           = new Contact();
			$contact->number   = $data['number'];
			$contact->group_id = $data['groupID'];
			$contact->source   = $data['source'];
			$contact->save();
		}
	}
