<?php
	/**
	 * Created by Alabi Olawale
	 * Date: 13/07/2020
	 */

	namespace AppsBay\Controllers\Metas;

	use AppsBay\Models\Contacts\Contact;
	use AppsBay\Models\Gateways\Gateway;
	use AppsBay\Models\Gateways\GatewaysCollection;
	use AppsBay\Models\Groups\GroupsCollection;
	use AppsBay\Models\Messages\Message;
	use AppsBay\Models\Settings\Setting;
	use AppsBay\Models\Groups\Group;
	use AppsBay\Models\Settings\SettingResource;
	use Carbon\Carbon;
	use WP_REST_Response;

class MetaController {


	public static function index() {
		$stats    = static::generate_stats();
		$setting  = Setting::find( 1 );
		$groups   = GroupsCollection::Collect( Group::all() );
		$gateways = GatewaysCollection::collect( Gateway::all() );
		$sources  = Contact::pluck( 'source' )->unique();
		$sources->prepend( 'None' );
		$data = array(
			'stats'    => $stats,
			'gateways' => $gateways,
			'sources'  => $sources,
			'groups'   => $groups,
			'settings' => $setting->settings,
		);
		return new WP_REST_Response(
			array(
				'status'   => 200,
				'response' => 'Success',
				'body'     => $data,
			)
		);
	}
	private static function generate_stats() {
		return array(
			'contacts' => static::contacts_additions_by_months_stats(),
			'messages' => static::messages_delivery_by_month_stats(),
			'groups'   => static::top_groups_by_contacts_stats(),
			'gateways' => static::top_gateway_by_sent_messages_stats(),
		);
	}

	protected static function contacts_additions_by_months_stats() {
		return Contact::get()->sortBy( 'created_at' )->groupBy(
			function( $contacts ) {
				return Carbon::parse( $contacts->created_at )->format( 'Y-M' );

			}
		)->map(
			function( $contacts ) {
				return $contacts->count();
			}
		)->take( 8 );
	}
	protected static function messages_delivery_by_month_stats() {
		return Message::get()->sortBy( 'created_at' )->groupBy(
			function( $message ) {
				return Carbon::parse( $message->created_at )->format( 'Y-M' );

			}
		)->map(
			function( $message ) {
				return $message->count();
			}
		);
	}
	protected static function top_groups_by_contacts_stats() {
		return Group::all()->sortBy(
			function( $group ) {
				return $group->contacts->count();
			}
		)->filter(
			function( $group ) {
				return $group->contacts->count() > 0;
			}
		)->map(
			function ( $group ) {
				return array(
					$group->name => $group->contacts->count(),
				);
			}
		)->reduce(
			function ( $carry, $item ) {
				return collect( $carry )->merge( $item );
			},
			collect( array() )
		)->take( 8 );
	}
	protected static function top_gateway_by_sent_messages_stats() {
		return Gateway::all()->sortBy(
			function( $gateway ) {
				return $gateway->messages->count();
			}
		)->filter(
			function( $gateway ) {
				return $gateway->messages->count() > 0;
			}
		)->map(
			function ( $gateway ) {
				return array(
					$gateway->name => $gateway->messages->count(),
				);
			}
		)->reduce(
			function ( $carry, $item ) {
				return collect( $carry )->merge( $item );
			},
			collect( array() )
		)->take( 8 );
	}

}
