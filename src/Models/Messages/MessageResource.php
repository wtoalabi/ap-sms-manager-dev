<?php
	/**
	 * Created by Alabi Olawale
	 * Date: 21/07/2020
	 */
	
	namespace App\Models\Messages;
	use Carbon\Carbon;
	
	
	class MessageResource {
		public function transform( $message ) {
			$created_time = (new Carbon($message->created_at))->format('Y-m-d H:i:s');
			$humanDate = (new Carbon($message->created_at))->diffForHumans();
			$normalDate = (new Carbon($message->created_at))->toDayDateTimeString();
			return [
				'id' => $message->id,
				'gateway' => $message->gateway->apiName,
				'gatewayName' => $message->gateway->name,
				'senderID' => $message->senderID,
				'recipientsCount' => $message->recipientsCount,
				'status' => $message->status,
				'responseMessage' => $message->response,
				'groups' => $message->groups,
				'message' => $message->message,
				'scheduleTime' => $message->time,
				'createdTimeFull' => "$normalDate - $humanDate",
				'created_at' => $created_time
			];
		}
	}
