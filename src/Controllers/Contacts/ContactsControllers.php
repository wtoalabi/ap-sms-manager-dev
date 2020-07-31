<?php

/**
 * Created by Alabi Olawale
 * Date: 12/07/2020
 */

namespace AppsBay\Controllers\Contacts;

use AppsBay\Controllers\Contacts\Syncs\Woocommerce;
use AppsBay\Models\Base\DataResponse;
use AppsBay\Models\Contacts\Contact;
use AppsBay\Models\Contacts\ContactsCollection;

class ContactsControllers {
	public function index( $request ) {
		$result = ( new Contact() )->filter_query( $request );

		return DataResponse::with( $result, ContactsCollection::class );
	}

	public function store( $request ) {
		$data     = collect( $request->get_json_params() );
		$numbers  = collect( $data['numbers'] );
		$source   = $data['source'];
		$group_id = $data['group_id'];
		if ( $numbers->isNotEmpty() ) {
			$numbers->each(
				function ( $number ) use ( $source, $group_id ) {
					$data = array(
						'source'   => $source,
						'group_id' => $group_id,
						'number'   => $number,
					);
					self::save( $data );
				}
			);
			$result = ( new Contact() )->filter_query( $request );

			return DataResponse::with( $result, ContactsCollection::class, 201, 'Contacts Added Successfully!!!' );
		}

		return null;
	}

	public static function save( $data ) {
		$contact           = new Contact();
		$contact->number   = $data['number'];
		$contact->group_id = $data['group_id'];
		$contact->source   = $data['source'];
		$contact->save();
	}

	public function sync( $request ) {

		$available_sources = array(
			1 => Woocommerce::class,
		);
		$data              = $request->get_json_params();
		$plugin            = $data['plugin'];
		$group             = $data['group'];
		$plugin_class      = $available_sources[ $plugin ];
		$count             = ( new $plugin_class( $group ) )->run( $group );
		if ( $count ) {
			$result = ( new Contact() )->filter_query( $request );

			return DataResponse::with(
				$result,
				ContactsCollection::class,
				201,
				"$count contact numbers were found and added successfully!!!"
			);
		}
	}

	public function update( $request ) {
		$data = $request->get_json_params();

		$contact = Contact::find( $data['id'] );
		if ( $contact->update( $data ) ) {
			$message = 'Contact updated successfully!';
			$code    = 201;
		} else {
			$code    = 500;
			$message = 'Unable to save Contact. Try again later!';
		}

		$result = ( new Contact() )->filter_query( $request );

		return DataResponse::with(
			$result,
			ContactsCollection::class,
			$code,
			$message
		);
	}

	public function move_contacts( $request ) {
		$data     = collect( $request->get_json_params() );
		$contacts = collect( $data['contactsIDs'] );
		$group    = $data['groupID'];
		$contacts->each(
			function ( $contact_id ) use ( $group ) {
				$contact           = Contact::find( $contact_id );
				$contact->group_id = $group;
				$contact->save();
			}
		);
		$result = ( new Contact() )->filter_query( $request );

		return DataResponse::with( $result, ContactsCollection::class, null, 'Contacts Updated Successfully!' );
	}

	public function delete( $request ) {
		$to_be_deleted = collect( $request->get_json_params() );
		$to_be_deleted->each(
			function ( $id ) {
				$contact = Contact::find( $id );
				if ( $contact ) {
					$contact->delete();
				}
			}
		);
		$result = ( new Contact() )->filter_query( $request );

		return DataResponse::with( $result, ContactsCollection::class, null, 'Contact(s) deleted successfully!' );
	}
}
