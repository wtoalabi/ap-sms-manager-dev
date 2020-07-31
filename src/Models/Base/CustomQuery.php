<?php
/**
 * Created by Alabi Olawale
 * Date: 12/07/2020
 */

namespace AppsBay\Models\Base;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use WP_REST_Request;

trait CustomQuery {
	protected $query_builder;
	protected $request;
	public function filter_query( WP_REST_Request $request ) {
		$this->query_builder = self::query();
		$this->request       = collect( $request->get_json_params() );
		$this->request->each(
			function ( $value, $query ) {
				if ( method_exists( $this, $query ) ) {
					$json_value = collect( $value );
					if ( $json_value->isNotEmpty() ) {
						$this->$query( $json_value );
					}
				}
			}
		);

		return $this->order_query();
	}

	public function order_query() {
		$request         = $this->request['queryPagination'];
		$sort_desc       = $request['sortDesc'][0];
		$sort_by         = $request['sortBy'][0];
		$items_per_page  = $request['itemsPerPage'] ?? 10;
		$page            = $request['page'];
		$sort_desc       = $sort_desc ?? true;
		$sort_by         = $sort_by ?? 'created_at';
		$data            = $this->query_builder->orderBy(
			$sort_by,
			$sort_desc
				? 'desc' : 'asc'
		);
		$data            = $data->get();
		$current_results = $data->slice( ( $page - 1 ) * $items_per_page, $items_per_page )->values();

		return new LengthAwarePaginator( $current_results, count( $data ), $items_per_page, $page );
	}

	public function filter_by_search( $search_array ) {
		$search_column = $search_array[0];
		$search_text   = $search_array[1];
		if ( $search_text ) {
			return $this->query_builder->where( $search_column, 'like', "%$search_text%" );
		}

		return $this->query_builder;
	}

	public function search_multiple_columns( $search_array ) {
		$search_columns = $search_array[0];
		$search_text    = $search_array[1];
		if ( $search_text ) {
			$this->query_builder->where( $search_columns[0], 'like', "%$search_text%" );
			foreach ( $search_columns as $column ) {
				$this->query_builder->orWhere( $column, 'like', "%$search_text%" );
			}
		}

		return $this->query_builder;
	}

	public function filter_by_date( $date_array ) {

		if ( $date_array ) {
			$column = $date_array['column'];
			$from   = $date_array['fromDate'];
			$to     = $date_array['toDate'];
			if ( $from && $to ) {
				return $this->query_builder->whereBetween( $column, array( $from, $to ) );
			} else {
				return $this->query_builder;
			}
		}

		return $this->query_builder;
	}

	public function filter_by_column( Collection $query_array ) {
		$query_array->each(
			function ( $item, $column ) {
				$this->query_builder->where( $column, $item );
			}
		);
	}

	public function filter_by_relationship( $relationship_array ) {
		collect( $relationship_array )->values()->each(
			function ( $relationship ) {
				list( $table, $column, $value ) = $relationship;
				if ( 'None' !== $value ) {
					if ( is_array( $value ) ) {
						collect( $value )->each(
							function ( $each_value ) use ( $table, $column ) {
								return $this->query_builder->whereHas(
									$table,
									function ( $query ) use (
										$each_value,
										$column
									) {
										return $query->where( $column, 'like', "%$each_value%" );
									}
								);
							}
						);
					} else {
						return $this->query_builder->whereHas(
							$table,
							function ( $query ) use (
								$value,
								$column
							) {
								return $query->where( $column, 'like', "%$value%" );
							}
						);
					}

					return $this->query_builder;
				}

				return $this->query_builder;
			}
		);

		return $this->query_builder;
	}


}
