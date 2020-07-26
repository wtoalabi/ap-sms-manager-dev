<?php
	/**
	 * Created by Alabi Olawale
	 * Date: 19/07/2020
	 */
	
	namespace App\Controllers\Gateways;
	
	use App\Models\Base\DataResponse;
	use App\Models\Gateways\Gateway;
	use App\Models\Gateways\GatewaysCollection;
	
	class GatewayControllers {
		
		public function index( $request ) {
			$result = ( new Gateway() )->filterQuery( $request );
			
			return DataResponse::With( $result, GatewaysCollection::class );
		}
		
		public function store( $request ) {
			$data = $request->get_json_params();
			
			$gateway = Gateway::create( [
				'name'        => $data['name'],
				'description' => $data['description'],
				'apiName'     => $data['apiName'],
				'apiKey'      => $data['apiKey'],
				'username'    => $data['username'],
				'isDefault' => $data['isDefault'],
				'metaData'    => json_encode( $data['metaData'] ),
			] );
			if($gateway->isDefault){
				static::MakeDefault( $gateway);
			}
			$result = ( new Gateway() )->filterQuery( $request );
			
			return DataResponse::With( $result,
				GatewaysCollection::class, 201,
				"Gateway Created!");
		}
		
		public function update( $request ) {
			$data    = $request->get_json_params();
			$gateway = Gateway::find( $data['id'] );
			if ( $gateway->update( $data ) ) {
				$message = "Gateway updated successfully!";
				$code    = 201;
			} else {
				$code    = 500;
				$message = "Unable to save Gateway. Try again later!";
			}
			if($data['isDefault']){
				static::MakeDefault( $gateway);
			}
			$result = ( new Gateway() )->filterQuery( $request );
			
			return DataResponse::With( $result,
				GatewaysCollection::class,
				$code,
				$message );
		}
		
		public function delete( $request ) {
			$toBeDeleted = collect( $request->get_json_params()['gateway_ids'] );
			$toBeDeleted->each( function ( $id ) {
				$gateway = Gateway::find( $id );
				if ( $gateway ) {
					$gateway->delete();
				}
			} );
			$result = ( new Gateway() )->filterQuery( $request );
			
			return DataResponse::With( $result, GatewaysCollection::class, null, "Gateway(s) deleted successfully!" );
		}
		
		public static function MakeDefault( $gateway ) {
			$gatewayID = $gateway->id;
			$allExistingGateways = Gateway::all();
			$allExistingGateways->each(function ($gateway) use($gatewayID){
				if($gateway->id!== $gatewayID){
					return $gateway->update(['isDefault' => 0]);
				}
				return true;
			});
		}
	}
