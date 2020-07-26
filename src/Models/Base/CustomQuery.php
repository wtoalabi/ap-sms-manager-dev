<?php
	/**
	 * Created by Alabi Olawale
	 * Date: 12/07/2020
	 */
	
	namespace App\Models\Base;
	
	use Illuminate\Pagination\LengthAwarePaginator;
	use Illuminate\Support\Collection;
	use WP_REST_Request;
	
	trait CustomQuery {
		protected $queryBuilder;
		protected $request;
		
		public function filterQuery( WP_REST_Request $request ) {
			$this->queryBuilder = self::query();
			$this->request      = collect( $request->get_json_params() );
			$this->request->each( function ( $value, $query ) {
				if ( method_exists( $this, $query ) ) {
					$json_value = collect( $value );
					if ( $json_value->isNotEmpty() ) {
						$this->$query( $json_value );
					}
				}
			} );
			return $this->orderQuery();
		}
		
		public function orderQuery() {
			$request        = $this->request['queryPagination'];
			$sortDesc       = $request['sortDesc'][0];
			$sortBy         = $request['sortBy'][0];
			$itemsPerPage   = $request['itemsPerPage'] ?? 10;
			$page           = $request['page'];
			$sortDesc       = $sortDesc ?? true;
			$sortBy         = $sortBy ?? 'created_at';
			$data           = $this->queryBuilder->orderBy( $sortBy, $sortDesc
				? 'desc' : 'asc' );
			$data           = $data->get();
			$currentResults = $data->slice( ( $page - 1 ) * $itemsPerPage, $itemsPerPage )->values();
			return new LengthAwarePaginator( $currentResults, count( $data ), $itemsPerPage, $page );
		}
		
		public function filterBySearch( $searchArray ) {
			$searchColumn = $searchArray[0];
			$searchText   = $searchArray[1];
			if ( $searchText ) {
				return $this->queryBuilder->where( $searchColumn, 'like', "%$searchText%" );
			}
			
			return $this->queryBuilder;
		}
		
		public function searchMultipleColumns( $searchArray ) {
			$searchColumns = $searchArray[0];
			$searchText    = $searchArray[1];
			if ( $searchText ) {
				$this->queryBuilder->where( $searchColumns[0], 'like', "%$searchText%" );
				foreach ( $searchColumns as $column ) {
					$this->queryBuilder->orWhere( $column, 'like', "%$searchText%" );
				}
			}
			
			return $this->queryBuilder;
		}
		
		public function filterByDate( $dateArray ) {
			
			if ( $dateArray ) {
				$column = $dateArray['column'];
				$from   = $dateArray['fromDate'];
				$to     = $dateArray['toDate'];
				if ( $from && $to ) {
					return $this->queryBuilder->whereBetween( $column, [ $from, $to ] );
				} else {
					return $this->queryBuilder;
				}
			}
			
			return $this->queryBuilder;
		}
		
		public function filterByColumn( Collection $queryArray ) {
			$queryArray->each( function ( $item, $column ) {
				$this->queryBuilder->where( $column, $item );
			} );
		}
		
		public function filterByRelationship( $relationshipArray ) {
			dd( $relationshipArray );
			collect( $relationshipArray )->values()->each( function ( $relationship ) {
				list( $table, $column, $value ) = $relationship;
				if ( $value !== "None" ) {
					if ( is_array( $value ) ) {
						collect( $value )->each( function ( $eachValue ) use ( $table, $column ) {
							return $this->queryBuilder->whereHas( $table, function ( $query ) use (
								$eachValue,
								$column
							) {
								return $query->where( $column, 'like', "%$eachValue%" );
							} );
						} );
					} else {
						return $this->queryBuilder->whereHas( $table, function ( $query ) use (
							$value,
							$column
						) {
							return $query->where( $column, 'like', "%$value%" );
						} );
					}
					
					return $this->queryBuilder;
				}
				
				return $this->queryBuilder;
			} );
			
			return $this->queryBuilder;
		}
		
		public
		static function PaginatedCollection(
			$collection
		) {
			return [
				'data'       => $collection,
				'pagination' => Pagination::Get( $collection )
			];
		}
		
		
	}
