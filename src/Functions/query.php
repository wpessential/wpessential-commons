<?php
if ( ! \defined( 'ABSPATH' ) )
{
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'wpe_get_data_from_table_select' ) )
{
	/**
	 * Retrieve the data from table.
	 *
	 * @param string $table name of table to get the data.
	 *
	 * @return array
	 */
	function wpe_get_data_from_table_select ( $table )
	{
		global $wpdb;

		return $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}{$table} WHERE %d", [ 1 ] ) );
	}
}

if ( ! function_exists( 'wpe_formidable_table_query' ) )
{
	/**
	 * Retrieve the array of posts.
	 *
	 * @param bool $is_multiselect enable or disable the first option like empty.
	 *
	 * @return array
	 */
	function wpe_formidable_table_query ( $is_multiselect = false )
	{
		// Get the posts.
		$results = wpe_get_data_from_table_select( 'frm_forms' );

		$items = [];
		if ( ! $is_multiselect )
		{
			$items[] = esc_html__( 'Choose', 'TEXT_DOMAIN' );
		}

		// Build the array.
		if ( $results )
		{
			foreach ( $results as $result )
			{
				$items[ $result->id ] = $result->name;
			}
		}
		else
		{
			$items[ 'no' ] = esc_html__( 'No Post Found', 'TEXT_DOMAIN' );
		}

		return apply_filters( 'wpe/form/formidable/posts', $items );
	}
}

if ( ! function_exists( 'wpe_caldera_table_query' ) )
{
	/**
	 * Retrieve the array of posts.
	 *
	 * @param bool $is_multiselect enable or disable the first option like empty.
	 *
	 * @return array
	 */
	function wpe_caldera_table_query ( $is_multiselect = false )
	{
		// Get the posts.
		$results = wpe_get_data_from_table_select( 'cf_forms' );

		$items = [];
		if ( ! $is_multiselect )
		{
			$items[] = esc_html__( 'Choose', 'TEXT_DOMAIN' );
		}

		// Build the array.
		if ( $results )
		{
			foreach ( $results as $result )
			{
				$items[ $result->id ] = $result->name;
			}
		}
		else
		{
			$items[ 'no' ] = esc_html__( 'No Post Found', 'TEXT_DOMAIN' );
		}

		return apply_filters( 'wpe/form/caldera/posts', $items );
	}
}

if ( ! function_exists( 'wpe_ninja_table_query' ) )
{
	/**
	 * Retrieve the array of posts.
	 *
	 * @param bool $is_multiselect enable or disable the first option like empty.
	 *
	 * @return array
	 */
	function wpe_ninja_table_query ( $is_multiselect = false )
	{
		// Get the posts.
		$results = wpe_get_data_from_table_select( 'nf3_forms' );

		$items = [];
		if ( ! $is_multiselect )
		{
			$items[] = esc_html__( 'Choose', 'TEXT_DOMAIN' );
		}

		// Build the array.
		if ( $results )
		{
			foreach ( $results as $result )
			{
				$items[ $result->id ] = $result->name;
			}
		}
		else
		{
			$items[ 'no' ] = esc_html__( 'No Post Found', 'TEXT_DOMAIN' );
		}

		return apply_filters( 'wpe/form/ninja/posts', $items );
	}
}

if ( ! function_exists( 'wpe_layer_slider_table_query' ) )
{
	/**
	 * Retrieve the array of posts.
	 *
	 * @param bool $is_multiselect enable or disable the first option like empty.
	 *
	 * @return array
	 */
	function wpe_layer_slider_table_query ( $is_multiselect = false )
	{
		// Get the posts.
		$results = wpe_get_data_from_table_select( 'layerslider' );

		$items = [];
		if ( ! $is_multiselect )
		{
			$items[] = esc_html__( 'Choose', 'TEXT_DOMAIN' );
		}

		// Build the array.
		if ( $results )
		{
			foreach ( $results as $result )
			{
				$items[ $result->id ] = $result->name;
			}
		}
		else
		{
			$items[ 'no' ] = esc_html__( 'No Post Found', 'TEXT_DOMAIN' );
		}

		return apply_filters( 'wpe/slider/layer/posts', $items );
	}
}

if ( ! function_exists( 'wpe_rev_slider_table_query' ) )
{
	/**
	 * Retrieve the array of posts.
	 *
	 * @param bool $is_multiselect enable or disable the first option like empty.
	 *
	 * @return array
	 */
	function wpe_rev_slider_table_query ( $is_multiselect = false )
	{
		// Get the posts.
		$results = wpe_get_data_from_table_select( 'revslider_sliders' );

		$items = [];
		if ( ! $is_multiselect )
		{
			$items[] = esc_html__( 'Choose', 'TEXT_DOMAIN' );
		}

		// Build the array.
		if ( $results )
		{
			foreach ( $results as $result )
			{
				$items[ $result->id ] = $result->name;
			}
		}
		else
		{
			$items[ 'no' ] = esc_html__( 'No Post Found', 'TEXT_DOMAIN' );
		}

		return apply_filters( 'wpe/slider/rev/posts', $items );
	}
}

if ( ! function_exists( 'wpe_smart_slider_table_query' ) )
{
	/**
	 * Retrieve the array of posts.
	 *
	 * @param bool $is_multiselect enable or disable the first option like empty.
	 *
	 * @return array
	 */
	function wpe_smart_slider_table_query ( $is_multiselect = false )
	{
		// Get the posts.
		$results = wpe_get_data_from_table_select( 'nextend2_smartslider3_sliders' );

		$items = [];
		if ( ! $is_multiselect )
		{
			$items[] = esc_html__( 'Choose', 'TEXT_DOMAIN' );
		}

		// Build the array.
		if ( $results )
		{
			foreach ( $results as $result )
			{
				$items[ $result->id ] = $result->name;
			}
		}
		else
		{
			$items[ 'no' ] = esc_html__( 'No Post Found', 'TEXT_DOMAIN' );
		}

		return apply_filters( 'wpe/slider/smart/posts', $items );
	}
}
