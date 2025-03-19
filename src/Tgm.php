<?php

namespace WPEssential\Library;

if ( ! \defined( 'ABSPATH' ) )
{
	exit; // Exit if accessed directly.
}

final class Tgm
{
	private static $WPE_TGM_CONFIG_DIR = '/config/tgm/';

	public static function init ()
	{
		if ( ! \defined( 'WPE_TGM' ) ) return;

		self::$WPE_TGM_CONFIG_DIR = get_template_directory() . self::$WPE_TGM_CONFIG_DIR;

		require_once __DIR__ . '/class-tgm-plugin-activation.php';

		add_action( 'tgmpa_register', [ __CLASS__, 'plugin_list' ] );
	}

	public static function plugin_list ()
	{
		$plugin_list = [
			'example' => [
				'name'               => 'TGM Example Plugin',
				// The plugin source.
				'required'           => true,
				'version'            => '1.0.0',
				'force_activation'   => false,
				'force_deactivation' => false,
				'external_url'       => '',
				'is_callable'        => '',
			],
		];

		$plugin_list = apply_filters( 'wpe/register/plugins', $plugin_list );

		$ready_plugins = [];
		foreach ( $plugin_list as $plugin_slug => $plugin_info )
		{
			if ( true === wpe_array_get( $plugin_info, 'local' ) && file_exists( self::$WPE_TGM_CONFIG_DIR . "{$plugin_slug}.zip" ) )
			{
				$plugin_info[ 'source' ] = self::$WPE_TGM_CONFIG_DIR . "{$plugin_slug}.zip";
			}

			$plugin_info[ 'slug' ] = $plugin_slug;
			$ready_plugins[]       = $plugin_info;
		}

		tgmpa( $ready_plugins, self::config() );
	}

	private static function config ()
	{
		$config = [
			'id'           => 'wpessential-54rtr5465',
			// Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' => '',
			// Default absolute path to bundled plugins.
			'menu'         => 'wpessential-install-plugins',
			// Menu slug.
			'parent_slug'  => 'plugins.php',
			// Parent menu slug.
			'capability'   => 'manage_options',
			// Capability needed to view plugin install page, should be a capability associated with the parent menu used.
			'has_notices'  => true,
			// Show admin notices or not.
			'dismissable'  => true,
			// If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',
			// If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => false,
			// Automatically activate plugins after installation or not.
			'message'      => '',
			// Message to output right before the plugins table.

			/*
			'strings'      => array(
				'page_title'                      => esc_html__( 'Install Required Plugins', 'wpessential' ),
				'menu_title'                      => esc_html__( 'Install Plugins', 'wpessential' ),
				/* translators: %s: plugin name. * /
				'installing'                      => esc_html__( 'Installing Plugin: %s', 'wpessential' ),
				/* translators: %s: plugin name. * /
				'updating'                        => esc_html__( 'Updating Plugin: %s', 'wpessential' ),
				'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'wpessential' ),
				'notice_can_install_required'     => _n_noop(
					/* translators: 1: plugin name(s). * /
					'This theme requires the following plugin: %1$s.',
					'This theme requires the following plugins: %1$s.',
					'wpessential'
				),
				'notice_can_install_recommended'  => _n_noop(
					/* translators: 1: plugin name(s). * /
					'This theme recommends the following plugin: %1$s.',
					'This theme recommends the following plugins: %1$s.',
					'wpessential'
				),
				'notice_ask_to_update'            => _n_noop(
					/* translators: 1: plugin name(s). * /
					'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
					'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
					'wpessential'
				),
				'notice_ask_to_update_maybe'      => _n_noop(
					/* translators: 1: plugin name(s). * /
					'There is an update available for: %1$s.',
					'There are updates available for the following plugins: %1$s.',
					'wpessential'
				),
				'notice_can_activate_required'    => _n_noop(
					/* translators: 1: plugin name(s). * /
					'The following required plugin is currently inactive: %1$s.',
					'The following required plugins are currently inactive: %1$s.',
					'wpessential'
				),
				'notice_can_activate_recommended' => _n_noop(
					/* translators: 1: plugin name(s). * /
					'The following recommended plugin is currently inactive: %1$s.',
					'The following recommended plugins are currently inactive: %1$s.',
					'wpessential'
				),
				'install_link'                    => _n_noop(
					'Begin installing plugin',
					'Begin installing plugins',
					'wpessential'
				),
				'update_link' 					  => _n_noop(
					'Begin updating plugin',
					'Begin updating plugins',
					'wpessential'
				),
				'activate_link'                   => _n_noop(
					'Begin activating plugin',
					'Begin activating plugins',
					'wpessential'
				),
				'return'                          => esc_html__( 'Return to Required Plugins Installer', 'wpessential' ),
				'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'wpessential' ),
				'activated_successfully'          => esc_html__( 'The following plugin was activated successfully:', 'wpessential' ),
				/* translators: 1: plugin name. * /
				'plugin_already_active'           => esc_html__( 'No action taken. Plugin %1$s was already active.', 'wpessential' ),
				/* translators: 1: plugin name. * /
				'plugin_needs_higher_version'     => esc_html__( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'wpessential' ),
				/* translators: 1: dashboard link. * /
				'complete'                        => esc_html__( 'All plugins installed and activated successfully. %1$s', 'wpessential' ),
				'dismiss'                         => esc_html__( 'Dismiss this notice', 'wpessential' ),
				'notice_cannot_install_activate'  => esc_html__( 'There are one or more required or recommended plugins to install, update or activate.', 'wpessential' ),
				'contact_admin'                   => esc_html__( 'Please contact the administrator of this site for help.', 'wpessential' ),

				'nag_type'                        => '', // Determines admin notice type - can only be one of the typical WP notice classes, such as 'updated', 'update-nag', 'notice-warning', 'notice-info' or 'error'. Some of which may not work as expected in older WP versions.
			),
			*/
		];
		return apply_filters( 'wpe/tgm/config', $config );
	}
}
