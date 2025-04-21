<?php

namespace TeaAroma\RouteArchitect\Helpers;


use Illuminate\Support\Facades\Log;
use TeaAroma\RouteArchitect\Callables\IsNotMiddleware;
use TeaAroma\RouteArchitect\Enums\RouteArchitectConfig;
use TeaAroma\RouteArchitect\Enums\RouteArchitectErrors;


/**
 * Provides utility methods for working with RouteArchitect logic.
 */
class RouteArchitectHelpers
{
	/**
	 * Determines whether the given input is (or consists of) valid middleware.
	 *
	 * If input is an array, returns true only if all items are valid middleware.
	 *
	 * @param class-string|class-string[] $middleware
	 *
	 * @return bool
	 */
	static public function is_middleware(string | array $middleware): bool
	{
		if (is_array($middleware))
		{
			if (empty($middleware))
			{
				return false;
			}
			
			$filter = array_filter($middleware, new IsNotMiddleware);
			
			return empty($filter);
		}
		
		return method_exists($middleware, 'handle');
	}
	
	/**
	 * Converts the variables of the given 'RouteArchitect' class to string.
	 *
	 * [ 'id' ] => ...{id}
	 *
	 * [ 'posts' => 'id_post' ] => ...posts/{id_post}
	 *
	 * @param string[] $variables
	 *
	 * @return string
	 */
	static public function variables_to_string(array $variables): string
	{
		$string = '';
		
		foreach ($variables as $key => $variable)
		{
			if (!empty($string))
			{
				$string .= RouteArchitectConfig::URL_DELIMITER->get_config();
			}
			
			if (!array_is_list($variables))
			{
				$string .= $key . RouteArchitectConfig::URL_DELIMITER->get_config();
			}
			
			$string .= sprintf(RouteArchitectConfig::URL_VARIABLE_TEMPLATE->get_config(), $variable);
		}
		
		return $string;
	}

	/**
	 * Gets the 'callable' of the given class / object by the given name of the method.
	 *
	 * @param class-string|object $class_or_object
	 * @param string        $method_name
	 *
	 * @return callable
	 */
	public static function get_callable(string | object $class_or_object, string $method_name): callable
	{
		return [ $class_or_object, $method_name ];
	}

	/**
	 * Gets the 'Closure' of the given class / object by the given name of the method.
	 *
	 * @param class-string|object $class_or_object
	 * @param string        $method_name
	 *
	 * @return callable
	 */
	public static function get_closure(string | object $class_or_object, string $method_name): \Closure
	{
		try
		{
			$closure = self::get_callable($class_or_object, $method_name)( ... );
		}
		catch (\Exception $exception)
		{
			Log::error(RouteArchitectErrors::UNDEFINED_METHOD->format($method_name, $class_or_object::class), [ 'exception' => $exception ]);

			$closure = fn () => null;
		}

		return $closure;
	}
}
