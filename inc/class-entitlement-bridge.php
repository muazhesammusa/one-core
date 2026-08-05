<?php
/**
 * Read-only bridge to the One theme entitlement state.
 *
 * @package One_Core
 */

namespace ONECORE;

final class EntitlementBridge {
	public static function status() {
		$status = apply_filters(
			'tophive_one_license_status',
			array(
				'state' => 'inactive',
				'entitled' => false,
			)
		);

		return is_array( $status ) ? $status : array( 'state' => 'inactive', 'entitled' => false );
	}

	public static function has( $feature = 'one_core' ) {
		return (bool) apply_filters( 'tophive_one_has_entitlement', false, sanitize_key( (string) $feature ) );
	}

	public static function features() {
		$features = apply_filters( 'tophive_one_license_features', array() );
		return is_array( $features ) ? $features : array();
	}
}
