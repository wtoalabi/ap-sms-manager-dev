<?php
	/**
	 * Created by Alabi Olawale
	 * Date: 08/07/2020
	 */
	
	namespace App\Controllers\Dashboard;
	
	use App\Controllers\Controller;
	use App\Models\Contacts\Contact;
	use App\Models\Contacts\ContactResource;
	use App\Models\Contacts\ContactsCollection;
	use App\Models\Groups\Group;
	use Illuminate\Database\Capsule\Manager as Capsule;
	use League\Fractal\Manager;
	use League\Fractal\Resource\Collection;
	use Spatie\Fractalistic\Fractal;
	
	
	class DashboardControllers {
		public function index($request) {
			$result = (new Contact())->filterQuery($request);
			return new ContactsCollection($result);
		}
		
		public function store() {
			var_dump( "storing!" );
		}
		
		public function update() {
			var_dump( "updating..." );
		}
		
		public function delete() {
			var_dump( "deleting..." );
		}
	}
