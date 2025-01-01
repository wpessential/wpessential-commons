<?php

namespace WPEssential\Library;

if ( ! \defined( 'ABSPATH' ) )
{
	exit; // Exit if accessed directly.
}

use ArrayAccess;
use InvalidArgumentException;
use WPEssential\Library\Helper\Macroable;

class Arr
{
	use Macroable;

	/**
	 * Array Get
	 *
	 * Strictly get a value from an array using dot notation without wilds (*).
	 *
	 * @param array|\ArrayAccess $array   Array to search.
	 * @param string|array       $key     Value to check in dot notation, or an array of string values.
	 * @param mixed              $default Fallback if value is null.
	 */
	public static function get ( $array, $key, $default = null )
	{
		$search = is_array( $key ) ? $key : explode( '.', $key );

		foreach ( $search as $index )
		{
			if ( is_array( $array ) && array_key_exists( $index, $array ) )
			{
				$array = $array[ $index ];
			}
			else
			{
				return $default;
			}
		}

		return $array;
	}

	/**
	 * Determine whether the given value is array accessible.
	 *
	 * @param mixed $value
	 *
	 * @return bool
	 */
	public static function accessible ( $value )
	{
		return is_array( $value ) || $value instanceof ArrayAccess;
	}

	/**
	 * Determine if the given key exists in the provided array.
	 *
	 * @param \ArrayAccess|array $array
	 * @param string|int         $key
	 *
	 * @return bool
	 */
	public static function exists ( $array, $key )
	{
		if ( $array instanceof ArrayAccess )
		{
			return $array->offsetExists( $key );
		}

		return array_key_exists( $key, $array );
	}

	/**
	 * Dots Set
	 *
	 * Set an array value using dot notation.
	 *
	 * @param array  $array the original array
	 * @param string $keys  dot notation path to set
	 * @param mixed  $value the value to set
	 *
	 * @return array
	 */
	public static function set ( array $array, $keys, $value )
	{
		$set      = &$array;
		$traverse = explode( '.', $keys );
		foreach ( $traverse as $step )
		{
			$set = &$set[ $step ];
		}
		$set = $value;

		return $array;
	}

	/**
	 * Collapse an array of arrays into a single array.
	 *
	 * @param array $array
	 *
	 * @return array
	 */
	public static function collapse ( $array )
	{
		$results = [];

		foreach ( $array as $values )
		{
			if ( $values instanceof Collection )
			{
				$values = $values->all();
			}
			elseif ( ! is_array( $values ) )
			{
				continue;
			}

			$results[] = $values;
		}

		return array_merge( [], ...$results );
	}

	/**
	 * Cross join the given arrays, returning all possible permutations.
	 *
	 * @param array ...$arrays
	 *
	 * @return array
	 */
	public static function crossJoin ( ...$arrays )
	{
		$results = [ [] ];

		foreach ( $arrays as $index => $array )
		{
			$append = [];

			foreach ( $results as $product )
			{
				foreach ( $array as $item )
				{
					$product[ $index ] = $item;

					$append[] = $product;
				}
			}

			$results = $append;
		}

		return $results;
	}

	/**
	 * Divide an array into two arrays. One with keys and the other with values.
	 *
	 * @param array $array
	 *
	 * @return array
	 */
	public static function divide ( $array )
	{
		return [ array_keys( $array ), array_values( $array ) ];
	}

	/**
	 * Flatten a multi-dimensional associative array with dots.
	 *
	 * @param array  $array
	 * @param string $prepend
	 *
	 * @return array
	 */
	public static function dot ( $array, $prepend = '' )
	{
		$iterator = new \RecursiveIteratorIterator( new \RecursiveArrayIterator( $array ) );
		$result   = [];
		foreach ( $iterator as $value )
		{
			$keys  = [];
			$depth = range( 0, $iterator->getDepth() );
			foreach ( $depth as $step )
			{
				$keys[] = $iterator->getSubIterator( $step )->key();
			}
			$result[ implode( '.', $keys ) ] = $value;
		}

		return $result;
	}

	/**
	 * Get all of the given array except for a specified array of keys.
	 *
	 * @param array        $array
	 * @param array|string $keys
	 *
	 * @return array
	 */
	public static function except ( $array, $keys )
	{
		static::forget( $array, $keys );

		return $array;
	}

	/**
	 * Remove one or many array items from a given array using "dot" notation.
	 *
	 * @param array        $array
	 * @param array|string $keys
	 *
	 * @return void
	 */
	public static function forget ( &$array, $keys )
	{
		$original = &$array;

		$keys = (array) $keys;

		if ( count( $keys ) === 0 )
		{
			return;
		}

		foreach ( $keys as $key )
		{
			// if the exact key exists in the top-level, remove it
			if ( static::exists( $array, $key ) )
			{
				unset( $array[ $key ] );

				continue;
			}

			$parts = explode( '.', $key );

			// clean up before each pass
			$array = &$original;

			while ( count( $parts ) > 1 )
			{
				$part = array_shift( $parts );

				if ( isset( $array[ $part ] ) && is_array( $array[ $part ] ) )
				{
					$array = &$array[ $part ];
				}
				else
				{
					continue 2;
				}
			}

			unset( $array[ array_shift( $parts ) ] );
		}
	}

	/**
	 * Return the last element in an array passing a given truth test.
	 *
	 * @param array         $array
	 * @param callable|null $callback
	 * @param mixed         $default
	 *
	 * @return mixed
	 */
	public static function last ( $array, callable $callback = null, $default = null )
	{
		if ( is_null( $callback ) )
		{
			return empty( $array ) ? wpe_value( $default ) : end( $array );
		}

		return static::first( array_reverse( $array, true ), $callback, $default );
	}

	/**
	 * Return the first element in an array passing a given truth test.
	 *
	 * @param array         $array
	 * @param callable|null $callback
	 * @param mixed         $default
	 *
	 * @return mixed
	 */
	public static function first ( $array, callable $callback = null, $default = null )
	{
		if ( is_null( $callback ) )
		{
			if ( empty( $array ) )
			{
				return wpe_value( $default );
			}

			return array_key_first( $array );
		}

		foreach ( $array as $key => $value )
		{
			if ( call_user_func( $callback, $value, $key ) )
			{
				return $value;
			}
		}

		return wpe_value( $default );
	}

	/**
	 * Flatten a multi-dimensional array into a single level.
	 *
	 * @param array $array
	 * @param int   $depth
	 *
	 * @return array
	 */
	public static function flatten ( $array, $depth = INF )
	{
		$result = [];

		foreach ( $array as $item )
		{
			$item = $item instanceof Collection ? $item->all() : $item;

			if ( ! is_array( $item ) )
			{
				$result[] = $item;
			}
			else
			{
				$values = $depth === 1
					? array_values( $item )
					: static::flatten( $item, $depth - 1 );

				foreach ( $values as $value )
				{
					$result[] = $value;
				}
			}
		}

		return $result;
	}

	/**
	 * Check if an item or items exist in an array using "dot" notation.
	 *
	 * @param \ArrayAccess|array $array
	 * @param string|array       $keys
	 *
	 * @return bool
	 */
	public static function has ( $array, $keys )
	{
		$keys = (array) $keys;

		if ( ! $array || $keys === [] )
		{
			return false;
		}

		foreach ( $keys as $key )
		{
			$subKeyArray = $array;

			if ( static::exists( $array, $key ) )
			{
				continue;
			}

			foreach ( explode( '.', $key ) as $segment )
			{
				if ( static::accessible( $subKeyArray ) && static::exists( $subKeyArray, $segment ) )
				{
					$subKeyArray = $subKeyArray[ $segment ];
				}
				else
				{
					return false;
				}
			}
		}

		return true;
	}

	/**
	 * Get a subset of the items from the given array.
	 *
	 * @param array        $array
	 * @param array|string $keys
	 *
	 * @return array
	 */
	public static function only ( $array, $keys )
	{
		return array_intersect_key( $array, array_flip( (array) $keys ) );
	}

	/**
	 * Pluck an array of values from an array.
	 *
	 * @param array             $array
	 * @param string|array      $value
	 * @param string|array|null $key
	 *
	 * @return array
	 */
	public static function pluck ( $array, $value, $key = null )
	{
		$list    = [];
		$columns = (array) $value;

		if ( count( $columns ) > 1 )
		{
			$cb = static function ( $item, $columns )
			{
				return static::only( $item, $columns );
			};
		}
		else
		{
			$cb = function ( $item, $columns )
			{
				return self::walk( $columns, $item );
			};
		}

		foreach ( $array as $item )
		{

			$item_value = $cb( $item, $columns );

			if ( $key )
			{
				$index_key = self::walk( $key, $item );

				if ( array_key_exists( $index_key, $list ) )
				{
					throw new \Exception( 'Array key must be unique for Arr::pluck with index.' );
				}

				$list[ $index_key ] = $item_value;
			}
			else
			{
				$list[] = $item_value;
			}
		}

		return $list;
	}

	/**
	 * Explode the "value" and "key" arguments passed to "pluck".
	 *
	 * @param string|array      $value
	 * @param string|array|null $key
	 *
	 * @return array
	 */
	protected static function explodePluckParameters ( $value, $key )
	{
		$value = is_string( $value ) ? explode( '.', $value ) : $value;

		$key = is_null( $key ) || is_array( $key ) ? $key : explode( '.', $key );

		return [ $value, $key ];
	}

	/**
	 * Push an item onto the beginning of an array.
	 *
	 * @param array $array
	 * @param mixed $value
	 * @param mixed $key
	 *
	 * @return array
	 */
	public static function prepend ( $array, $value, $key = null )
	{
		if ( is_null( $key ) )
		{
			array_unshift( $array, $value );
		}
		else
		{
			$array = [ $key => $value ] + $array;
		}

		return $array;
	}

	/**
	 * Get a value from the array, and remove it.
	 *
	 * @param array  $array
	 * @param string $key
	 * @param mixed  $default
	 *
	 * @return mixed
	 */
	public static function pull ( &$array, $key, $default = null )
	{
		$value = static::get( $array, $key, $default );

		static::forget( $array, $key );

		return $value;
	}

	/**
	 * Get one or a specified number of random values from an array.
	 *
	 * @param array    $array
	 * @param int|null $number
	 *
	 * @return mixed
	 *
	 * @throws \InvalidArgumentException
	 */
	public static function random ( $array, $number = null )
	{
		$requested = is_null( $number ) ? 1 : $number;

		$count = count( $array );

		if ( $requested > $count )
		{
			throw new InvalidArgumentException(
				"You requested {$requested} items, but there are only {$count} items available."
			);
		}

		if ( is_null( $number ) )
		{
			return $array[ array_rand( $array ) ];
		}

		if ( (int) $number === 0 )
		{
			return [];
		}

		$keys = array_rand( $array, $number );

		$results = [];

		foreach ( (array) $keys as $key )
		{
			$results[] = $array[ $key ];
		}

		return $results;
	}

	/**
	 * Shuffle the given array and return the result.
	 *
	 * @param array    $array
	 * @param int|null $seed
	 *
	 * @return array
	 */
	public static function shuffle ( $array, $seed = null )
	{
		if ( is_null( $seed ) )
		{
			shuffle( $array );
		}
		else
		{
			mt_srand( $seed );
			shuffle( $array );
			mt_srand();
		}

		return $array;
	}

	/**
	 * Sort the array using the given callback or "dot" notation.
	 *
	 * @param array                $array
	 * @param callable|string|null $callback
	 *
	 * @return array
	 */
	public static function sort ( $array, $callback = null )
	{
		return Collection::make( $array )->sortBy( $callback )->all();
	}

	/**
	 * Recursively sort an array by keys and values.
	 *
	 * @param array $array
	 *
	 * @return array
	 */
	public static function sortRecursive ( $array )
	{
		foreach ( $array as &$value )
		{
			if ( is_array( $value ) )
			{
				$value = static::sortRecursive( $value );
			}
		}

		if ( static::isAssoc( $array ) )
		{
			ksort( $array );
		}
		else
		{
			sort( $array );
		}

		return $array;
	}

	/**
	 * Determines if an array is associative.
	 *
	 * An array is "associative" if it doesn't have sequential numerical keys beginning with zero.
	 *
	 * @param array $array
	 *
	 * @return bool
	 */
	public static function isAssoc ( array $array )
	{
		$keys = array_keys( $array );

		return array_keys( $keys ) !== $keys;
	}

	/**
	 * Convert the array into a query string.
	 *
	 * @param array $array
	 *
	 * @return string
	 */
	public static function query ( $array )
	{
		return http_build_query( $array, null, '&', PHP_QUERY_RFC3986 );
	}

	/**
	 * Filter the array using the given callback.
	 *
	 * @param array    $array
	 * @param callable $callback
	 *
	 * @return array
	 */
	public static function where ( $array, callable $callback )
	{
		return array_filter( $array, $callback, ARRAY_FILTER_USE_BOTH );
	}

	/**
	 * If the given value is not an array and not null, wrap it in one.
	 *
	 * @param mixed $value
	 *
	 * @return array
	 */
	public static function wrap ( $value )
	{
		if ( is_null( $value ) )
		{
			return [];
		}

		return is_array( $value ) ? $value : [ $value ];
	}

	/**
	 * HTML class names helper
	 *
	 * @param array $array
	 *
	 * @return string
	 */
	public static function reduceAllowedStr ( $array )
	{
		$reduced = '';
		array_walk( $array, function ( $val, $key ) use ( &$reduced )
		{
			$reduced .= $val ? " $key" : '';
		} );
		$cleaned = implode( ' ', array_unique( array_map( 'trim', explode( ' ', trim( $reduced ) ) ) ) );
		return $cleaned;
	}

	/**
	 * Dots Walk
	 *
	 * Traverse array with dot notation with wilds (*).
	 *
	 * @param array|object $array an array to traverse
	 * @param string|array $dots  dot notation key.next.final
	 * @param null|mixed   $default
	 *
	 * @return array|mixed|null
	 */
	public static function walk ( $array, $dots, $default = null )
	{
		$traverse = is_array( $dots ) ? $dots : explode( '.', $dots );
		foreach ( $traverse as $i => $step )
		{
			unset( $traverse[ $i ] );
			if ( $step === '*' && is_array( $array ) )
			{
				return array_map( function ( $item ) use ( $traverse, $default )
				{
					return static::walk( $traverse, $item, $default );
				}, $array );
			}

			$v = is_object( $array ) ? ( $array->$step ?? null ) : ( $array[ $step ] ?? null );

			if ( ! isset( $v ) && ! is_string( $array ) )
			{
				return $default;
			}
			$array = $v ?? $default;
		}

		return $array;
	}
}
