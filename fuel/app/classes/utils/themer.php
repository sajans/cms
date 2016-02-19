<?php

class Utils_Themer
{

	public static $routes = array();

	public static $base_theme = array();

	public static $route_search = array();

	public static $selected_theme = array();

	public static function _init()
	{
		Config::load('navigation', true);

		self::$routes = Config::get('navigation.routes', array());
		self::$base_theme = Config::get('navigation.default', array());

	}

	public static function get_theme($uri)
	{

		self::set_route($uri);

		self::select_theme();

		$theme = Arr::merge(self::$base_theme, self::$selected_theme);
		//if (is_array(self::$selected_theme['css']))
		//{
		//	unset($theme['css']);
		//	$theme['css'] = array_merge(self::$base_theme['css'], self::$selected_theme['css']);
		//}
		//if (is_array(self::$selected_theme['js']))
		//{
		//	unset($theme['js']);
		//	$theme['js'] = array_merge(self::$base_theme['js'], self::$selected_theme['js']);
		//}
//var_dump($theme); exit;
		return $theme;

	}

	public static function set_route($uri)
	{
		if (empty($uri))
		{
			$route_parts = array(
				'_root_',
			);
		}
		else
		{
			$route_parts = explode('/', $uri);
		}

		$count = count($route_parts) - 1;
		$routes = array();
		$build = "";
		foreach ($route_parts as $key => $part)
		{
			$build .= ($key!=0) ? '/' : '';
			$build .= $part;
			$routes[] = $build;

			if ($key!=$count)
			{
				$wildcard = $build . '/*';
				$routes[] = $wildcard;
			}

		}
                
		self::$route_search = $routes;

	}

	public static function select_theme()
	{
            
		foreach (self::$routes as $key => $route)
		{
			if (in_array($key, self::$route_search))
			{
				self::$selected_theme = Arr::merge(self::$selected_theme, $route);
			}
		}
                
	}

	public static function sidebar($content)
	{
            	$rendered_content = "";

		if (is_array($content))
		{
			foreach ($content as $item)
			{
				$rendered_content .= Request::forge($item)->execute()->response();
			}
		}
		else 
		{
			$rendered_content = Request::forge($content, false)->execute()->response();
		}

		return $rendered_content;

	}
        public static function header($content)
	{
            	$rendered_content = "";

		if (is_array($content))
		{
			foreach ($content as $item)
			{
				$rendered_content .= Request::forge($item)->execute()->response();
			}
		}
		else 
		{
			$rendered_content = Request::forge($content, false)->execute()->response();
		}

		return $rendered_content;

	}
}
