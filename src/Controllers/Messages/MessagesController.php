<?php
/**
 * Created by Alabi Olawale
 * Date: 21/07/2020
 */

namespace AppsBay\Controllers\Messages;

use AppsBay\Controllers\Gateways\Gateways;
use AppsBay\Models\Base\DataResponse;
use AppsBay\Models\Gateways\Gateway;
use AppsBay\Models\Groups\Group;
use AppsBay\Models\Messages\Message;
use AppsBay\Models\Messages\MessagesCollection;

class MessagesController {
	public function index( $request ) {
		$result = ( new Message() )->filter_query( $request );

		return DataResponse::with(
			$result,
			MessagesCollection::class,
			200,
			'Successful'
		);
	}

	public function store( $request ) {
		$data            = $request->get_json_params();
		$gateway         = Gateway::find( $data['gateway'] );
		$gateway_class   = Gateways::$gateways[ $gateway->apiName ];
		$data['gateway'] = $gateway->toArray();
		list( $data['recipients'],
			$data['groupsName'] ) = static::merge_recipients( $data['recipients'] );
		$data['recipients_count'] = count( $data['recipients'] );
		$response                 = ( new $gateway_class() )->send( $data );
		$message                  = static::make_message( $data, $response );
		if ( $message ) {
			$recipients_count = $data['recipients_count'];
			Message::create( $message );
			$status  = null;
			$message = null;

			if ( 'error' === $response['status'] ) {
				$status  = 422;
				$message = $response['message'];
			} else {
				$status  = 200;
				$message = "SMS sent successfully to $recipients_count recipients";
			}
			$result = ( new Message() )->filter_query( $request );

			return DataResponse::with(
				$result,
				MessagesCollection::class,
				$status,
				$message
			);
		}
	}

	private static function merge_recipients( $recipients ) {
		$groups_array = collect( $recipients['groups'] );
		$manual_array = $recipients['manual'];
		$contacts     = collect();
		$groups_names = '';
		for ( $index = 0; $groups_array->count() > $index; $index ++ ) {
			$group_id = $groups_array[ $index ];
			$group    = Group::find( $group_id );
			if ( $group ) {
				$groups_names .= "$group->name";
				$groups_names .= ',';
				$numbers      = $group->contacts->pluck( array( 'number' ) );
				$contacts->push( $numbers->toArray() );
			}
		}
		$contacts->push( $manual_array );
		$flatten = $contacts->flatten()->filter();

		return array( $flatten->unique()->toArray(), rtrim( $groups_names, ',' ) );
	}

	private static function make_message( $data, $response ) {
		return array(
			'gateway_id'      => $data['gateway']['id'],
			'senderID'        => $data['senderID'],
			'status'          => $response['status'],
			'response'        => $response['message'],
			'recipientsCount' => $data['recipients_count'],
			'groups'          => $data['groupsName'],
			'message'         => $data['message'],
			'time'            => $data['time'],
		);
	}
}
