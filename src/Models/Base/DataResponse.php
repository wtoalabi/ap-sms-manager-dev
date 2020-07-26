<?php
	/**
	 * Created by Alabi Olawale
	 * Date: 12/07/2020
	 */
	
	namespace App\Models\Base;
	
	use App\Models\Contacts\ContactsCollection;
	use WP_Error;
	use WP_REST_Response;
	
	class DataResponse {
		public static function With( $paginatedResult, $collection, $code = 200, $message = "Successful" ) {
			if ( $code <= 300 ) {
				if ( ! is_wp_error( $paginatedResult ) ) {
					return new WP_REST_Response(
						array(
							'status'     => $code,
							'response'   => $message,
							'body'       => $collection::Collect( $paginatedResult->getCollection() ),
							'pagination' => self::PaginationInfo( $paginatedResult->toArray() )
						)
					);
				}
			}
			
			return new WP_Error( $code, $message, [
				'status'     => $code,
				'response'   => $message,
				'body'       => $collection::Collect( $paginatedResult->getCollection() ),
				'pagination' => self::PaginationInfo( $paginatedResult->toArray() )
			] );
		}
		
		public static function PaginationInfo( $data ) {
			return [
				'rowsNumber'   => $data['total'],
				'itemsPerPage' => $data['per_page'],
				'page'         => $data['current_page'],
			];
		}
		
		public
		static function Single(
			$result, $resource, $code = 200, $message = "Successful"
		) {
			if ( ! is_wp_error( $result ) ) {
				return new WP_REST_Response(
					array(
						'status'   => $code,
						'response' => $message,
						'body'     => $resource->transform( $result ),
					)
				);
			}
			
			return new WP_Error( 500, "Error", "Error" );
		}
	}
