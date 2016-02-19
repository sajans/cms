<?php

class Utils_Navigation
{
	public static $links_wrapper = array(
		'top_links' => array(
			'attr' => array(
				'class' => 'nav navbar-nav pull-right',
			),
			'links' => array(),
		),
		'bottom_links' => array(
			'attr' => array(
				'class' => 'child-menu',
			),
			'links' => array(),
		),
	);

	public static function _init()
	{
		Config::load('navigation', true);
	}
			
	public static function get_links($name)
	{
		$links = Config::get('navigation.links.'.$name, array());
		
		$links_array = self::process_links($links);

		self::$links_wrapper['top_links']['links'] = $links_array['links'];

		if (isset($links_array['children']))
		{
			self::$links_wrapper['bottom_links']['links'] = $links_array['children']['links'];
		}

		return self::$links_wrapper;
	}

	public static function process_links($links)
	{
		$processed_links = array(
			'links' => array(),
			'active_branch' => false,
		);
		$total = count($links);
		$count = 1;
		if ($total > 0)
		{
			foreach ($links as $uri => $link)
			{
				$class = array('navi');
				if ($count == 1)
				{
					$class[] = 'first';
				}
				if ($count == $total)
				{
					$class[] = 'last';
				}

				$active = self::is_active($uri, $link);
				
				if (is_array($link) && isset($link['children']))
				{
					$children = self::process_links($link['children']);

					if ($children['active_branch'])
					{
						$active = true;
					}
					if ($active)
					{
						$processed_links['children'] = $children;
					}
				}

				if ($active)
				{
					$class[] = 'active';
					$processed_links['active_branch'] = true;
				}

				$link_array = array(
					'attr' => array(
						'class' => $class,
					),
					'text' => '',
				);


				if (is_array($link))
				{
					$link_array = array_merge($link_array, $link);
				}
				else 
				{
					$link_array['href'] = $uri;
					$link_array['text'] = $link;
				}

				$link_array['attr']['class'] = implode(' ', $link_array['attr']['class']);

				$processed_links['links'][] = $link_array;

				$count++;

			}
		}

		return $processed_links;
	}

	public static function is_active($uri, $link)
	{
		if ($uri == Request::active()->uri->uri)
		{
			return true;
		}
		elseif (is_array($link))
		{
			if (isset($link['children']) && array_key_exists(Request::active()->uri->uri, $link['children']))
			{
				return true;
			}
		}
		else
		{
			return false;
		}
	}



}	
