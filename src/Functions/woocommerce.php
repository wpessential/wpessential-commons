<?php
if ( ! \defined( 'ABSPATH' ) )
{
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'WC' ) ) return;

if ( ! function_exists( 'wpe_wc_cart_count' ) )
{
	/**
	 * WooCommerce cart count
	 *
	 * @return int
	 */
	function wpe_wc_cart_count ()
	{
		return WC()->cart->get_cart_contents_count();
	}
}
