<?php
/**
 * Do not show the Compare in the list product by default
 */
add_filter( 'filter_wooscp_button_archive', '__return_false', 90 );

/**
 * Add class `button` to compare button
 *
 * @param string $class
 *
 * @return string
 */
function tophive_wooscp_button_class(  $class = '' ){
	if ( empty( $class ) || is_string( $class ) ) {
		return $class . ' button';
	}
	return $class;
}

add_filter( 'pre_option__wooscp_button_class', 'tophive_wooscp_button_class', 90 );
add_filter( 'option__wooscp_button_class', 'tophive_wooscp_button_class', 90 );
add_filter( 'option_wooscp_button_class', 'tophive_wooscp_button_class', 90 );