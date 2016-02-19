<?php

class Utils_Form extends Form
{
	
	public static function select($field, $values = null, array $options = array(), array $attributes = array())
	{
		if (is_array($field))
		{
			$attributes = $field;

			if ( ! isset($attributes['selected']))
			{
				$attributes['selected'] = ! isset($attributes['value']) ? null : $attributes['value'];
			}
		}
		else
		{
			$attributes['name'] = (string) $field;
			$attributes['selected'] = $values;
			$attributes['options'] = $options;
		}
		unset($attributes['value']);

		if ( ! isset($attributes['options']) || ! is_array($attributes['options']))
		{
			throw new \InvalidArgumentException(sprintf('Select element "%s" is either missing the "options" or "options" is not array.', $attributes['name']));
		}
		// Get the options then unset them from the array
		$options = $attributes['options'];
		unset($attributes['options']);

		// Get the selected options then unset it from the array
		// and make sure they're all strings to avoid type conversions
		$selected = ! isset($attributes['selected']) ? array() : array_map(function($a) { return (string) $a; }, array_values((array) $attributes['selected']));

		unset($attributes['selected']);

		// closure to recusively process the options array
		$listoptions = function (array $options, $selected, $level = 1) use (&$listoptions) {

			$input = PHP_EOL;
			foreach ($options as $key => $val)
			{
				$opt_attr = array('value' => $key, 'style' => 'text-indent: '.(10*($level-1)).'px;');
				(in_array((string)$key, $selected, TRUE)) && $opt_attr[] = 'selected';
				$input .= str_repeat("\t", $level);
				$opt_attr['value'] = (\Config::get('form.prep_value', true) && empty($attributes['dont_prep'])) ?
					\Form::prep_value($opt_attr['value']) : $opt_attr['value'];

				if (isset($val['data']))
				{
					foreach ($val['data'] as $tag => $value)
					{
						$opt_attr[$tag] = $value;
					}
				}

				$input .= html_tag('option', $opt_attr, $val['text']).PHP_EOL;
			}

			return $input;
		};

		// generate the select options list
		$input = $listoptions($options, $selected).str_repeat("\t", 0);

		if (empty($attributes['id']) && \Config::get('form.auto_id', false) == true)
		{
			$attributes['id'] = \Config::get('form.auto_id_prefix', '').$attributes['name'];
		}

		return html_tag('select', \Form::attr_to_string($attributes), $input);
	}

}
