<?php
	/**
	 * Created by Alabi Olawale
	 * Date: 12/07/2020
	 */

	namespace AppsBay\Models\Base;

	use App\Models\Contacts\ContactsCollection;
	use WP_Error;
	use WP_REST_Response;

class DataResponse {
	public static function with( $paginated_result, $collection, $code = 200, $message = 'Successful' ) {
		if ( $code <= 300 ) {
			if ( ! is_wp_error( $paginated_result ) ) {
				return new WP_REST_Response(
					array(
						'status'     => $code,
						'response'   => $message,
						'body'       => $collection::Collect( $paginated_result->getCollection() ),
						'pagination' => self::pagination_info( $paginated_result->toArray() ),
					)
				);
			}
		}

		return new WP_Error(
			$code,
			$message,
			array(
				'status'     => $code,
				'response'   => $message,
				'body'       => $collection::Collect( $paginated_result->getCollection() ),
				'pagination' => self::pagination_info( $paginated_result->toArray() ),
			)
		);
	}

	public static function pagination_info( $data ) {
		return array(
			'rowsNumber'   => $data['total'],
			'itemsPerPage' => $data['per_page'],
			'page'         => $data['current_page'],
		);
	}

	public static function single(
		$result, $resource, $code = 200, $message = 'Successful'
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

		return new WP_Error( 500, 'Error', 'Error' );
	}
}
