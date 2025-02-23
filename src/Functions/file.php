<?php
if ( ! \defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'wpe_template_path' ) ) {
	function wpe_template_path ()
	{
		if ( false !== strpos( __FILE__, WP_PLUGIN_DIR ) || false !== strpos( __FILE__, WPMU_PLUGIN_DIR ) ) {
			$dir = plugin_dir_path( __DIR__ ) . '/';
		}
		else {
			$dir = get_template_directory() . '/';
		}

		return apply_filters( 'wpe/template/path', $dir );
	}
}
if ( ! function_exists( 'wpe_template_dir' ) ) {
	/**
	 * Retrieve|Find the full location in themes and plugins.
	 *
	 * @param string $path root path.
	 *
	 * @return string|WP_Error The resource or WP_Error message on failure
	 */
	function wpe_template_dir ( $path )
	{
		$find_in = apply_filters( 'wpe/template/dir', get_theme_file_path( $path ) );
		if ( is_dir( $find_in ) ) {
			return $find_in;
		}

		$find_in = $path;
		if ( is_dir( $find_in ) ) {
			return $find_in;
		}

		// Check in active plugins
		$active_plugins = get_option( 'active_plugins', [] );
		foreach ( $active_plugins as $plugin ) {
			$find_in = WP_PLUGIN_DIR . '/' . dirname( $plugin ) . '/' . ltrim( $path, '/' );
			if ( is_dir( $find_in ) ) {
				return $find_in;
			}
		}

		$error = new WP_Error(
			[
				404,
				sprintf( esc_html__( 'File %s not found', 'TEXT_DOMAIN' ), basename( $find_in ) ),
				$path
			]
		);
		return $error->get_error_message();
	}
}

if ( ! function_exists( 'wpe_template_load' ) ) {
	/**
	 * Retrieve|Find the file location in themes and plugins.
	 *
	 * @param string $slug         The $slug represent the file slug.
	 * @param string $name         The $name represent the file name.
	 * @param bool   $echo         The $echo represent the file either echo or not.
	 * @param bool   $require      The $reuqire represent the method type.
	 * @param bool   $require_once The $require_once represent the method type.
	 *
	 * @return string|WP_Error The resource or WP_Error message on failure
	 */
	function wpe_template_load ( $slug, $name = '', $echo = true, $require = false, $require_once = false )
	{
		$slug = str_replace( '.php', '', $slug );
		$name = str_replace( '.php', '', $name );

		if ( $name ) {
			$template = locate_template( [
				"{$slug}-{$name}.php",
				wpe_template_path() . "{$slug}-{$name}.php",
			] );

			if ( ! $template ) {
				$fallback = plugin_dir_path( __DIR__ ) . "/templates/{$slug}-{$name}.php";
				$template = file_exists( $fallback ) ? $fallback : '';
			}

			if ( ! $template ) {
				$fallback = get_template_directory() . "/vendor/wpessential/wpessential-theme-module/{$slug}-{$name}.php";
				$template = ( file_exists( $fallback ) ) ? $fallback : '';
			}

		}
		else {
			// If a template file doesn't exist, look in yourtheme/slug.php and yourtheme/wpessential/slug.php.
			$template = locate_template( [
				"{$slug}.php",
				wpe_template_path() . "{$slug}.php",
			] );

			if ( ! $template ) {
				$fallback = plugin_dir_path( __DIR__ ) . "/templates/{$slug}.php";
				$template = ( file_exists( $fallback ) ) ? $fallback : '';
			}

			if ( ! $template ) {
				$fallback = get_template_directory() . "/vendor/wpessential/wpessential-theme-module/{$slug}.php";
				$template = ( file_exists( $fallback ) ) ? $fallback : '';
			}
		}

		// Allow 3rd party plugins to filter template file from their plugin.
		$template = apply_filters( 'wpe/template/load', $template, $slug, $name );

		if ( ! $echo ) {
			return $template;
		}

		if ( $template && $require ) {
			load_template( $template, $require_once );
		}
		else {
			return $template;
		}
	}
}

if ( ! function_exists( 'wpe_plugin_template_load' ) ) {
	/**
	 * Retrieve|Find the file location in plugins.
	 *
	 * @param string $path root path of the file.
	 * @param string $file file name.
	 *
	 * @return string|WP_Error The resource or WP_Error message on failure
	 */
	function wpe_plugin_template_load ( $path, $file )
	{
		$_file = "templates/{$path}/{$file}";

		$find_in = apply_filters( 'wpe/plugin/template/load', get_theme_file_path( $_file ) );
		if ( file_exists( $find_in ) ) {
			return $find_in;
		}

		$find_in = $_file;
		if ( file_exists( $find_in ) ) {
			return $find_in;
		}

		$find_in = "{$path}templates/{$file}";
		if ( file_exists( $find_in ) ) {
			return $find_in;
		}

		$find_in = plugin_dir_path( __DIR__ ) . "/{$_file}";
		if ( file_exists( $find_in ) ) {
			return $find_in;
		}

		$error = new WP_Error(
			[
				404,
				sprintf( esc_html__( 'File %s not found', 'TEXT_DOMAIN' ), basename( $find_in ) ),
				$_file
			]
		);
		return $error->get_error_message();
	}
}

if ( ! function_exists( 'wpe_get_data_by_url' ) ) {
	/**
	 * Get code from file.
	 *
	 * @param string $url  URL to retrieve.
	 * @param array  $args Optional. Request arguments. Default empty array.
	 *
	 * @return string|array|WP_Error The data or WP_Error message on failure.
	 */
	function wpe_get_data_by_url ( $url, $args = [] )
	{
		$file = wp_remote_get( $url, $args );
		if ( ! is_wp_error( $file ) ) {
			return wp_remote_retrieve_body( $file );
		}

		return $file;
	}
}

if ( ! function_exists( 'wpe_post_data_by_url' ) ) {
	/**
	 * Post code via url.
	 *
	 * @param string $url  URL to retrieve.
	 * @param array  $args Optional. Request arguments. Default empty array.
	 *
	 * @return string|array|WP_Error The data or WP_Error message on failure.
	 */
	function wpe_post_data_by_url ( $url, $args = [] )
	{
		$file = wp_remote_post( $url, $args );
		if ( ! is_wp_error( $file ) ) {
			return wp_remote_retrieve_body( $file );
		}
		return $file;
	}
}
