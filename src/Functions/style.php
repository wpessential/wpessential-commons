<?php
if ( ! \defined( 'ABSPATH' ) )
{
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'wpe_style_unites' ) )
{
	/**
	 * Style unites.
	 * px:pixels (1px = 1/96th of 1in).
	 * em:Relative to the font-size of the element (2em means 2 times the size of the current font).
	 * ex:Relative to the x-height of the current font (rarely used).
	 * ch:Relative to width of the "0" (zero).
	 * rem:Relative to font-size of the root element.
	 * vm:Relative to 1% of the width of the viewport*.
	 * vh:Relative to 1% of the height of the viewport*.
	 * vmin:Relative to 1% of viewport's* smaller dimension.
	 * vmax:Relative to 1% of viewport's* larger dimension.
	 * %:Relative to the parent element.
	 * cm:centimeters.
	 * mm:millimeters.
	 * in:inches (1in = 96px = 2.54cm).
	 * pt:points (1pt = 1/72 of 1in).
	 * pc:picas (1pc = 12 pt).
	 *
	 * @return array
	 */
	function wpe_style_unites ()
	{
		return apply_filters(
			'wpe/style/unites',
			[
				'px'     => esc_html__( 'PX', 'TEXT_DOMAIN' ),
				'em'     => esc_html__( 'EM', 'TEXT_DOMAIN' ),
				'ex'     => esc_html__( 'EX', 'TEXT_DOMAIN' ),
				'ch'     => esc_html__( 'CH', 'TEXT_DOMAIN' ),
				'rem'    => esc_html__( 'REM', 'TEXT_DOMAIN' ),
				'vw'     => esc_html__( 'VW', 'TEXT_DOMAIN' ),
				'vh'     => esc_html__( 'VH', 'TEXT_DOMAIN' ),
				'vmin'   => esc_html__( 'VMIN', 'TEXT_DOMAIN' ),
				'vmax'   => esc_html__( 'VMAX', 'TEXT_DOMAIN' ),
				'%'      => esc_html__( '%', 'TEXT_DOMAIN' ),
				'cm'     => esc_html__( 'CM', 'TEXT_DOMAIN' ),
				'mm'     => esc_html__( 'MM', 'TEXT_DOMAIN' ),
				'in'     => esc_html__( 'IN', 'TEXT_DOMAIN' ),
				'pt'     => esc_html__( 'PT', 'TEXT_DOMAIN' ),
				'pc'     => esc_html__( 'PC', 'TEXT_DOMAIN' ),
				'custom' => esc_html__( 'Custom', 'TEXT_DOMAIN' ),
			]
		);
	}
}

if ( ! function_exists( 'wpe_transtion_time_unites' ) )
{
	/**
	 * Transtion time unite.
	 * ms:milliseconds.
	 * s:seconds.
	 *
	 * @return array
	 */
	function wpe_transtion_time_unites ()
	{
		return apply_filters( 'wpe/transtion/time/unites', [ 'ms', 's' ] );
	}
}

if ( ! function_exists( 'wpe_border_style' ) )
{
	/**
	 * Border styles.
	 *
	 * @return array
	 */
	function wpe_border_style ()
	{
		return apply_filters(
			'wpe/border/styles',
			[
				''       => esc_html__( 'None', 'TEXT_DOMAIN' ),
				'solid'  => esc_html__( 'Solid', 'TEXT_DOMAIN' ),
				'double' => esc_html__( 'Double', 'TEXT_DOMAIN' ),
				'dotted' => esc_html__( 'Dotted', 'TEXT_DOMAIN' ),
				'dashed' => esc_html__( 'Dashed', 'TEXT_DOMAIN' ),
				'groove' => esc_html__( 'Groove', 'TEXT_DOMAIN' ),
				'ridge'  => esc_html__( 'Ridge', 'TEXT_DOMAIN' ),
				'inset'  => esc_html__( 'Inset', 'TEXT_DOMAIN' ),
				'outset' => esc_html__( 'Outset', 'TEXT_DOMAIN' ),
			]
		);
	}
}

if ( ! function_exists( 'wpe_generate_css' ) )
{
	/**
	 * Print|Generate CSS.
	 *
	 * @param string $selector The CSS selector.
	 * @param string $style    The CSS style.
	 * @param string $value    The CSS value.
	 * @param string $prefix   The CSS prefix.
	 * @param string $suffix   The CSS suffix.
	 * @param bool   $echo     Echo the styles.
	 *
	 * @return string|void
	 */
	function wpe_generate_css ( string $selector, string $style, string $value, $prefix = '', $suffix = '', $echo = true )
	{
		$return = '';
		/*
		 * Bail early if we have no $selector elements or properties and $value.
		 */
		if ( ! $value || ! $selector )
		{
			return;
		}
		$return = sprintf( '%s { %s: %s; }', $selector, $style, $prefix . $value . $suffix );
		if ( $echo )
		{
			echo $return;
		}
		return $return;
	}
}

if ( ! function_exists( 'wpe_font_weights' ) )
{
	/**
	 * Font Weights styles.
	 *
	 * @return array
	 */
	function wpe_font_weights ()
	{
		return apply_filters(
			'wpe/font/weights',
			[
				''       => esc_html__( 'Default', 'TEXT_DOMAIN' ),
				'100'    => '100 ' . _x( '(Thin)', 'Typography Control', 'TEXT_DOMAIN' ),
				'200'    => '200 ' . _x( '(Extra Light)', 'Typography Control', 'TEXT_DOMAIN' ),
				'300'    => '300 ' . _x( '(Light)', 'Typography Control', 'TEXT_DOMAIN' ),
				'400'    => '400 ' . _x( '(Normal)', 'Typography Control', 'TEXT_DOMAIN' ),
				'500'    => '500 ' . _x( '(Medium)', 'Typography Control', 'TEXT_DOMAIN' ),
				'600'    => '600 ' . _x( '(Semi Bold)', 'Typography Control', 'TEXT_DOMAIN' ),
				'700'    => '700 ' . _x( '(Bold)', 'Typography Control', 'TEXT_DOMAIN' ),
				'800'    => '800 ' . _x( '(Extra Bold)', 'Typography Control', 'TEXT_DOMAIN' ),
				'900'    => '900 ' . _x( '(Black)', 'Typography Control', 'TEXT_DOMAIN' ),
				'normal' => _x( 'Normal', 'Typography Control', 'TEXT_DOMAIN' ),
				'bold'   => _x( 'Bold', 'Typography Control', 'TEXT_DOMAIN' ),
			]
		);
	}
}

if ( ! function_exists( 'wpe_font_variant_capitals' ) )
{
	/**
	 * Font Variant capitals styles.
	 *
	 * @return array
	 */
	function wpe_font_variant_capitals ()
	{
		return apply_filters(
			'wpe/font/variant/caps',
			[
				''                => esc_html__( 'Default', 'TEXT_DOMAIN' ),
				'normal'          => esc_html__( 'Normal Capitals', 'TEXT_DOMAIN' ),
				'small-caps'      => esc_html__( 'Small Capitals', 'TEXT_DOMAIN' ),
				'all-small-caps'  => esc_html__( 'All Small Capitals', 'TEXT_DOMAIN' ),
				'petite-caps'     => esc_html__( 'Petite Capitals', 'TEXT_DOMAIN' ),
				'all-petite-caps' => esc_html__( 'All Petite Capitals', 'TEXT_DOMAIN' ),
				'unicase'         => esc_html__( 'Unicase Capitals', 'TEXT_DOMAIN' ),
				'titling-caps'    => esc_html__( 'Titling Capitals', 'TEXT_DOMAIN' ),
				'initial'         => esc_html__( 'Initial Capitals', 'TEXT_DOMAIN' ),
				'inherit'         => esc_html__( 'Inherit Capitals', 'TEXT_DOMAIN' ),
				'unset'           => esc_html__( 'Unset Capitals', 'TEXT_DOMAIN' ),
			]
		);
	}
}

if ( ! function_exists( 'wpe_font_kerning' ) )
{
	/**
	 * Font kerning styles.
	 *
	 * @return array
	 */
	function wpe_font_kerning ()
	{
		return apply_filters(
			'wpe/font/kerning',
			[
				''       => esc_html__( 'Default', 'TEXT_DOMAIN' ),
				'normal' => esc_html__( 'Normal Capitals', 'TEXT_DOMAIN' ),
				'auto'   => esc_html__( 'Auto', 'TEXT_DOMAIN' ),
				'none'   => esc_html__( 'None', 'TEXT_DOMAIN' ),
			]
		);
	}
}

if ( ! function_exists( 'wpe_font_cases' ) )
{
	/**
	 * Font cases styles.
	 *
	 * @return array
	 */
	function wpe_font_cases ()
	{
		return apply_filters(
			'wpe/font/cases',
			[
				''           => esc_html__( 'Default', 'TEXT_DOMAIN' ),
				'uppercase'  => _x( 'Uppercase', 'Typography Control', 'TEXT_DOMAIN' ),
				'lowercase'  => _x( 'Lowercase', 'Typography Control', 'TEXT_DOMAIN' ),
				'capitalize' => _x( 'Capitalize', 'Typography Control', 'TEXT_DOMAIN' ),
				'none'       => _x( 'Normal', 'Typography Control', 'TEXT_DOMAIN' ),
			]
		);
	}
}

if ( ! function_exists( 'wpe_font_style' ) )
{
	/**
	 * Font cases styles.
	 *
	 * @return array
	 */
	function wpe_font_style ()
	{
		return apply_filters(
			'wpe/font/style',
			[
				''        => esc_html__( 'Default', 'TEXT_DOMAIN' ),
				'normal'  => _x( 'Normal', 'Typography Control', 'TEXT_DOMAIN' ),
				'italic'  => _x( 'Italic', 'Typography Control', 'TEXT_DOMAIN' ),
				'oblique' => _x( 'Oblique', 'Typography Control', 'TEXT_DOMAIN' ),
			]
		);
	}
}

if ( ! function_exists( 'wpe_font_decoration' ) )
{
	/**
	 * Font cases styles.
	 *
	 * @return array
	 */
	function wpe_font_decoration ()
	{
		return apply_filters(
			'wpe/font/decoration',
			[
				''             => esc_html__( 'Default', 'TEXT_DOMAIN' ),
				'underline'    => _x( 'Underline', 'Typography Control', 'TEXT_DOMAIN' ),
				'overline'     => _x( 'Overline', 'Typography Control', 'TEXT_DOMAIN' ),
				'line-through' => _x( 'Line Through', 'Typography Control', 'TEXT_DOMAIN' ),
				'none'         => _x( 'None', 'Typography Control', 'TEXT_DOMAIN' ),
			]
		);
	}
}
