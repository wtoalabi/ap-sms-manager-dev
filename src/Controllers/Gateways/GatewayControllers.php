<?php
/**
 * Created by Alabi Olawale
 * Date: 19/07/2020
 */

namespace AppsBay\Controllers\Gateways;

use AppsBay\Models\Base\DataResponse;
use AppsBay\Models\Gateways\Gateway;
use AppsBay\Models\Gateways\GatewaysCollection;

class GatewayControllers {

	public function index( $request ) {
		$result = ( new Gateway() )->filter_query( $request );

		return DataResponse::with( $result, GatewaysCollection::class );
	}

	public function store( $request ) {
		$data = $request->get_json_params();

		$gateway = Gateway::create(
			array(
				'name'        => $data['name'],
				'description' => $data['description'],
				'apiName'     => $data['apiName'],
				'apiKey'      => $data['apiKey'],
				'username'    => $data['username'],
				'isDefault'   => $data['isDefault'],
				'metaData'    => json_encode( $data['metaData'] ),
			)
		);
		if ( $gateway->is_default ) {
			static::make_default( $gateway );
		}
		$result = ( new Gateway() )->filter_query( $request );

		return DataResponse::with(
			$result,
			GatewaysCollection::class,
			201,
			'Gateway Created!'
		);
	}

	public static function make_default( $gateway ) {
		$gateway_id            = $gateway->id;
		$all_existing_gateways = Gateway::all();
		$all_existing_gateways->each(
			function ( $gateway ) use ( $gateway_id ) {
				if ( $gateway->id !== $gateway_id ) {
					return $gateway->update( array( 'isDefault' => 0 ) );
				}

				return true;
			}
		);
	}

	public function update( $request ) {
		$data    = $request->get_json_params();
		$gateway = Gateway::find( $data['id'] );
		if ( $gateway->update( $data ) ) {
			$message = 'Gateway updated successfully!';
			$code    = 201;
		} else {
			$code    = 500;
			$message = 'Unable to save Gateway. Try again later!';
		}
		if ( $data['is_default'] ) {
			static::make_default( $gateway );
		}
		$result = ( new Gateway() )->filter_query( $request );

		return DataResponse::with(
			$result,
			GatewaysCollection::class,
			$code,
			$message
		);
	}

	public function delete( $request ) {
		$to_be_deleted = collect( $request->get_json_params()['gateway_ids'] );
		$to_be_deleted->each(
			function ( $id ) {
				$gateway = Gateway::find( $id );
				if ( $gateway ) {
					$gateway->delete();
				}
			}
		);
		$result = ( new Gateway() )->filter_query( $request );

		return DataResponse::with( $result, GatewaysCollection::class, null, 'Gateway(s) deleted successfully!' );
	}
}
