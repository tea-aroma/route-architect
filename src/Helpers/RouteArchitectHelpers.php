<?php

namespace TeaAroma\RouteArchitect\Helpers;


use TeaAroma\RouteArchitect\Abstracts\RouteArchitect;
use TeaAroma\RouteArchitect\Callables\IsNotMiddleware;
use TeaAroma\RouteArchitect\Enums\RouteArchitectConfig;


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
	 * @deprecated
	 *
	 * @see RouteArchitect::is_group()
	 *
	 * Determines whether the give RouteArchitect is a group.
	 *
	 * @param RouteArchitect $route_architect
	 *
	 * @return bool
	 */
	static public function is_group_route(RouteArchitect $route_architect): bool
	{
		return !$route_architect->has_action();
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
	 * @deprecated
	 *
	 * @see RouteArchitectConfig::get_config()
	 *
	 * Gets the config value by the given case of enum.
	 *
	 * @param RouteArchitectConfig $config
	 *
	 * @return mixed
	 */
	static public function get_config(RouteArchitectConfig $config): mixed
	{
		return config('route-architect.' . $config->value);
	}
}
