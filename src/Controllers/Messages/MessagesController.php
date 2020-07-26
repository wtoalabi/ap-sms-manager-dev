<?php
	/**
	 * Created by Alabi Olawale
	 * Date: 21/07/2020
	 */
	
	namespace App\Controllers\Messages;
	
	
	use App\Controllers\Gateways\Gateways;
	use App\Models\Base\DataResponse;
	use App\Models\Gateways\Gateway;
	use App\Models\Groups\Group;
	use App\Models\Messages\Message;
	use App\Models\Messages\MessagesCollection;
	
	class MessagesController {
		public function index( $request ) {
			$result = ( new Message() )->filterQuery( $request );
			
			return DataResponse::With( $result,
				MessagesCollection::class,
				200,
				"Successful" );
		}
		
		public function store( $request ) {
			$data            = $request->get_json_params();
			$gateway         = Gateway::find( $data['gateway'] );
			$gatewayClass    = Gateways::$gateways[ $gateway->apiName ];
			$data['gateway'] = $gateway->toArray();
			[
				$data['recipients'],
				$data['groupsName']
			] = static::mergeRecipients( $data['recipients'] );
			$data['recipientsCount'] = count( $data['recipients'] );
			$response                = ( new $gatewayClass() )->send( $data );
			$message                 = static::makeMessage( $data, $response );
			if ( $message ) {
				$recipientsCount = $data['recipientsCount'];
				Message::create( $message );
				$status  = null;
				$message = null;
				
				if ( $response['status'] === 'error' ) {
					$status  = 422;
					$message = $response['message'];
				} else {
					$status  = 200;
					$message = "SMS sent successfully to $recipientsCount recipients";
				}
				$result = ( new Message() )->filterQuery( $request );
				
					//dd( $message );
				return DataResponse::With( $result,
					MessagesCollection::class,
					$status,
					$message );
			}
		}
		
		private static function mergeRecipients( $recipients ) {
			$groupsArray = collect( $recipients['groups'] );
			$manualArray = $recipients['manual'];
			$contacts    = collect();
			$groupsNames = "";
			for ( $index = 0; $groupsArray->count() > $index; $index ++ ) {
				$groupID = $groupsArray[ $index ];
				$group   = Group::find( $groupID );
				if ( $group ) {
					$groupsNames .= "$group->name";
					$groupsNames .= ",";
					$numbers     = $group->contacts->pluck( [ "number" ] );
					$contacts->push( $numbers->toArray() );
				}
			}
			$contacts->push( $manualArray );
			$flatten = $contacts->flatten()->filter();
			
			return [ $flatten->unique()->toArray(), rtrim( $groupsNames, ',' ) ];
		}
		
		private static function makeMessage( $data, $response ) {
			return [
				'gateway_id'      => $data['gateway']['id'],
				'senderID'        => $data['senderID'],
				'status'          => $response['status'],
				'response'        => $response['message'],
				'recipientsCount' => $data['recipientsCount'],
				'groups'          => $data['groupsName'],
				'message'         => $data['message'],
				'time'            => $data['time']
			];
		}
	}
